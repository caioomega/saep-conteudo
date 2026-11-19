// ==============================================================
// SERVIDOR.JS - API de produtos em Node.js SEM INSTALAR NADA
// Usa só o que já vem no Node 22+ (node:http e node:sqlite).
//
// Rodar (no terminal, dentro desta pasta):
//   node servidor.js
// Depois abra no navegador:  http://localhost:3000
// Pra parar o servidor: Ctrl + C no terminal.
// ==============================================================

const http = require("node:http");          // cria o servidor web
const fs = require("node:fs");              // lê arquivos (o index.html)
const path = require("node:path");
const { DatabaseSync } = require("node:sqlite"); // banco SQLite embutido

// ---------- BANCO DE DADOS ----------
// Cria (ou abre) o arquivo estoque.db nesta pasta.
const db = new DatabaseSync(path.join(__dirname, "estoque.db"));

db.exec(`
    CREATE TABLE IF NOT EXISTS produtos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT NOT NULL,
        quantidade INTEGER NOT NULL DEFAULT 0,
        estoque_minimo INTEGER NOT NULL DEFAULT 0
    )
`);

// Se a tabela estiver vazia, coloca 3 produtos de exemplo
const total = db.prepare("SELECT COUNT(*) AS n FROM produtos").get().n;
if (total === 0) {
    const inserir = db.prepare("INSERT INTO produtos (nome, quantidade, estoque_minimo) VALUES (?, ?, ?)");
    inserir.run("Martelo", 8, 3);
    inserir.run("Furadeira", 2, 3);
    inserir.run("Alicate", 15, 5);
}

// ---------- FUNÇÕES DE AJUDA ----------
// Responde em JSON
function responder(res, status, dados) {
    res.writeHead(status, { "Content-Type": "application/json; charset=utf-8" });
    res.end(JSON.stringify(dados));
}

// Lê o corpo da requisição (os dados que o navegador mandou) como JSON
function lerCorpo(req) {
    return new Promise((resolve) => {
        let texto = "";
        req.on("data", (pedaco) => (texto += pedaco));
        req.on("end", () => {
            try { resolve(JSON.parse(texto || "{}")); }
            catch { resolve({}); }
        });
    });
}

// Validação dos dados do produto. Devolve "" se estiver OK.
function validar(p) {
    if (!p.nome || String(p.nome).trim() === "") return "O nome é obrigatório.";
    if (!Number.isInteger(Number(p.quantidade)) || Number(p.quantidade) < 0) return "Quantidade inválida.";
    if (!Number.isInteger(Number(p.estoque_minimo)) || Number(p.estoque_minimo) < 0) return "Estoque mínimo inválido.";
    return "";
}

// ---------- AS ROTAS (cada endereço faz uma coisa) ----------
//   GET    /api/produtos        -> listar (R)
//   POST   /api/produtos        -> cadastrar (C)
//   PUT    /api/produtos/5      -> editar o 5 (U)
//   DELETE /api/produtos/5      -> excluir o 5 (D)
//   qualquer outro endereço     -> manda o index.html
const servidor = http.createServer(async (req, res) => {
    const url = new URL(req.url, "http://localhost");
    const partes = url.pathname.split("/").filter(Boolean); // "/api/produtos/5" -> ["api","produtos","5"]

    if (partes[0] === "api" && partes[1] === "produtos") {
        const id = Number(partes[2]);

        // LISTAR (com busca opcional: /api/produtos?busca=mar)
        if (req.method === "GET") {
            const busca = "%" + (url.searchParams.get("busca") || "") + "%";
            // O "?" é trocado pelo valor com segurança (evita SQL Injection)
            const lista = db.prepare("SELECT * FROM produtos WHERE nome LIKE ? ORDER BY nome").all(busca);
            return responder(res, 200, lista);
        }

        // CADASTRAR
        if (req.method === "POST") {
            const p = await lerCorpo(req);
            const erro = validar(p);
            if (erro) return responder(res, 400, { erro });
            const r = db.prepare("INSERT INTO produtos (nome, quantidade, estoque_minimo) VALUES (?, ?, ?)")
                        .run(String(p.nome).trim(), Number(p.quantidade), Number(p.estoque_minimo));
            return responder(res, 201, { id: Number(r.lastInsertRowid) });
        }

        // EDITAR
        if (req.method === "PUT" && id) {
            const p = await lerCorpo(req);
            const erro = validar(p);
            if (erro) return responder(res, 400, { erro });
            db.prepare("UPDATE produtos SET nome = ?, quantidade = ?, estoque_minimo = ? WHERE id = ?")
              .run(String(p.nome).trim(), Number(p.quantidade), Number(p.estoque_minimo), id);
            return responder(res, 200, { ok: true });
        }

        // EXCLUIR
        if (req.method === "DELETE" && id) {
            db.prepare("DELETE FROM produtos WHERE id = ?").run(id);
            return responder(res, 200, { ok: true });
        }

        return responder(res, 404, { erro: "Rota não encontrada" });
    }

    // Qualquer outra coisa: devolve a página
    const html = fs.readFileSync(path.join(__dirname, "index.html"));
    res.writeHead(200, { "Content-Type": "text/html; charset=utf-8" });
    res.end(html);
});

servidor.listen(3000, () => {
    console.log("Servidor rodando! Abra http://localhost:3000  (Ctrl + C pra parar)");
});
