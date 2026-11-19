// ==============================================================
// APP.JS - sistema de estoque inteiro em JavaScript puro.
// Os dados ficam salvos no localStorage (memória do navegador).
// Não precisa de XAMPP, banco nem internet: dois cliques no
// index.html e pronto.
// ==============================================================

// ---------- USUÁRIOS (fixos, só pra teste) ----------
const USUARIOS = [
    { login: "admin", senha: "123", nome: "Administrador" },
    { login: "maria", senha: "123", nome: "Maria Silva" },
    { login: "joao",  senha: "123", nome: "João Santos" },
];

// ---------- "BANCO DE DADOS" NO LOCALSTORAGE ----------
// localStorage só guarda TEXTO. Por isso:
//   JSON.stringify(objeto) -> transforma em texto pra salvar
//   JSON.parse(texto)      -> transforma de volta em objeto
function lerDados(chave, padrao) {
    const texto = localStorage.getItem(chave);
    return texto ? JSON.parse(texto) : padrao;
}
function salvarDados(chave, valor) {
    localStorage.setItem(chave, JSON.stringify(valor));
}

// Dados iniciais (3 produtos) se for a primeira vez
let produtos = lerDados("produtos", [
    { id: 1, nome: "Martelo", quantidade: 8, minimo: 3 },
    { id: 2, nome: "Furadeira", quantidade: 2, minimo: 3 },
    { id: 3, nome: "Alicate", quantidade: 15, minimo: 5 },
]);
let movimentacoes = lerDados("movimentacoes", []);

function salvarTudo() {
    salvarDados("produtos", produtos);
    salvarDados("movimentacoes", movimentacoes);
}

// Atalho pra pegar elemento pelo id
function $(id) { return document.getElementById(id); }

// ---------- MENSAGENS ----------
function mostrarMensagem(texto, tipo) {   // tipo: sucesso, erro, aviso
    $("mensagem").innerHTML = '<div class="mensagem ' + tipo + '">' + texto + '</div>';
}

// ---------- BUBBLE SORT (ordem alfabética pelo nome) ----------
function bubbleSort(lista) {
    const v = lista.slice();   // copia
    for (let i = 0; i < v.length - 1; i++) {
        for (let j = 0; j < v.length - 1 - i; j++) {
            if (v[j].nome.localeCompare(v[j + 1].nome, "pt-BR", { sensitivity: "base" }) > 0) {
                const temp = v[j];
                v[j] = v[j + 1];
                v[j + 1] = temp;
            }
        }
    }
    return v;
}

// ==============================================================
// LOGIN / LOGOUT  (sessionStorage = some quando fecha o navegador)
// ==============================================================
function usuarioLogado() {
    return JSON.parse(sessionStorage.getItem("usuario"));
}

function mostrarTela() {
    const usuario = usuarioLogado();
    if (usuario) {
        $("tela-login").style.display = "none";
        $("tela-sistema").style.display = "block";
        $("nome-usuario").innerText = usuario.nome;
        desenhar();
    } else {
        $("tela-login").style.display = "block";
        $("tela-sistema").style.display = "none";
    }
}

$("form-login").addEventListener("submit", function (evento) {
    evento.preventDefault();   // NÃO recarrega a página
    const login = $("login").value.trim();
    const senha = $("senha").value;
    // find: procura o primeiro usuário que bate login E senha
    const usuario = USUARIOS.find(u => u.login === login && u.senha === senha);
    if (usuario) {
        sessionStorage.setItem("usuario", JSON.stringify(usuario));
        $("erro-login").innerHTML = "";
        mostrarTela();
    } else {
        $("erro-login").innerHTML = '<div class="mensagem erro">Login ou senha incorretos.</div>';
    }
});

$("sair").addEventListener("click", function (evento) {
    evento.preventDefault();
    sessionStorage.removeItem("usuario");
    mostrarTela();
});

// ==============================================================
// DESENHAR A TELA (tabela, select, histórico)
// ==============================================================
function desenhar() {
    const busca = $("busca").value.trim().toLowerCase();
    const ordenados = bubbleSort(produtos);

    // Tabela de produtos (com filtro da busca)
    let html = "";
    for (const p of ordenados) {
        if (busca && !p.nome.toLowerCase().includes(busca)) continue;
        const baixo = p.quantidade < p.minimo;
        html += '<tr class="' + (baixo ? "linha-alerta" : "") + '">'
              + "<td>" + escapar(p.nome) + "</td>"
              + "<td>" + p.quantidade + (baixo ? " ⚠ ABAIXO DO MÍNIMO" : "") + "</td>"
              + "<td>" + p.minimo + "</td>"
              + '<td><button class="botao-pequeno" onclick="editar(' + p.id + ')">Editar</button> '
              + '<button class="botao-pequeno botao-perigo" onclick="excluir(' + p.id + ')">Excluir</button></td>'
              + "</tr>";
    }
    $("tabela").innerHTML = html || '<tr><td colspan="4">Nenhum produto.</td></tr>';

    // Select da movimentação
    $("mov-produto").innerHTML = ordenados
        .map(p => '<option value="' + p.id + '">' + escapar(p.nome) + " (" + p.quantidade + ")</option>")
        .join("");

    // Histórico (mais recente primeiro)
    $("historico").innerHTML = movimentacoes.slice().reverse().map(m =>
        "<tr><td>" + m.data.split("-").reverse().join("/") + "</td><td>" + escapar(m.produto)
        + "</td><td>" + (m.tipo === "entrada" ? "Entrada" : "Saída") + "</td><td>" + m.quantidade
        + "</td><td>" + escapar(m.usuario) + "</td></tr>"
    ).join("") || '<tr><td colspan="5">Nenhuma movimentação.</td></tr>';

    if (!$("mov-data").value) $("mov-data").value = new Date().toISOString().slice(0, 10);
}

// Evita que alguém coloque HTML no nome e "quebre" a página
function escapar(texto) {
    const div = document.createElement("div");
    div.innerText = texto;
    return div.innerHTML;
}

$("busca").addEventListener("input", desenhar);   // filtra enquanto digita

// ==============================================================
// CADASTRAR / EDITAR
// ==============================================================
$("form-produto").addEventListener("submit", function (evento) {
    evento.preventDefault();
    const id = $("id").value;
    const nome = $("nome").value.trim();
    const quantidade = $("quantidade").value;
    const minimo = $("minimo").value;

    // VALIDAÇÃO
    if (nome === "") return mostrarMensagem("O nome é obrigatório.", "erro");
    if (quantidade === "" || Number(quantidade) < 0 || !Number.isInteger(Number(quantidade)))
        return mostrarMensagem("Quantidade tem que ser inteiro, zero ou mais.", "erro");
    if (minimo === "" || Number(minimo) < 0 || !Number.isInteger(Number(minimo)))
        return mostrarMensagem("Estoque mínimo tem que ser inteiro, zero ou mais.", "erro");

    if (id) {
        // EDITAR: acha o produto e troca os valores
        const p = produtos.find(p => p.id === Number(id));
        p.nome = nome;
        p.quantidade = Number(quantidade);
        p.minimo = Number(minimo);
        mostrarMensagem("Produto alterado com sucesso!", "sucesso");
    } else {
        // CADASTRAR: novo id = maior id + 1
        const novoId = produtos.reduce((maior, p) => Math.max(maior, p.id), 0) + 1;
        produtos.push({ id: novoId, nome: nome, quantidade: Number(quantidade), minimo: Number(minimo) });
        mostrarMensagem("Produto cadastrado com sucesso!", "sucesso");
    }
    salvarTudo();
    limparFormulario();
    desenhar();
});

function editar(id) {
    const p = produtos.find(p => p.id === id);
    $("id").value = p.id;
    $("nome").value = p.nome;
    $("quantidade").value = p.quantidade;
    $("minimo").value = p.minimo;
    $("titulo-form").innerText = "Editar produto";
    window.scrollTo(0, 0);
}

function excluir(id) {
    if (!confirm("Tem certeza que deseja excluir?")) return;
    // filter: fica só com os que têm id DIFERENTE
    produtos = produtos.filter(p => p.id !== id);
    salvarTudo();
    mostrarMensagem("Produto excluído.", "sucesso");
    desenhar();
}

function limparFormulario() {
    $("form-produto").reset();
    $("id").value = "";
    $("titulo-form").innerText = "Novo produto";
}
$("cancelar").addEventListener("click", limparFormulario);

// ==============================================================
// ENTRADA / SAÍDA + ALERTA
// ==============================================================
$("form-mov").addEventListener("submit", function (evento) {
    evento.preventDefault();
    const p = produtos.find(p => p.id === Number($("mov-produto").value));
    const tipo = $("mov-tipo").value;
    const qtd = Number($("mov-qtd").value);
    const data = $("mov-data").value;

    if (!p) return mostrarMensagem("Selecione um produto.", "erro");
    if (!Number.isInteger(qtd) || qtd <= 0) return mostrarMensagem("Quantidade tem que ser maior que zero.", "erro");
    if (!data) return mostrarMensagem("Informe a data.", "erro");
    if (tipo === "saida" && qtd > p.quantidade)
        return mostrarMensagem("Estoque insuficiente. Disponível: " + p.quantidade, "erro");

    p.quantidade += (tipo === "entrada" ? qtd : -qtd);
    movimentacoes.push({ produto: p.nome, tipo: tipo, quantidade: qtd, data: data, usuario: usuarioLogado().nome });
    salvarTudo();
    $("mov-qtd").value = "";

    if (p.quantidade < p.minimo) {
        const aviso = "ATENÇÃO: " + p.nome + " ficou com " + p.quantidade + ", abaixo do mínimo de " + p.minimo + "!";
        mostrarMensagem(aviso, "aviso");
        alert(aviso);
    } else {
        mostrarMensagem("Movimentação registrada. Estoque atual: " + p.quantidade, "sucesso");
    }
    desenhar();
});

$("zerar").addEventListener("click", function () {
    if (confirm("Apagar TODOS os produtos e o histórico?")) {
        localStorage.clear();
        location.reload();
    }
});

// Começa mostrando a tela certa
mostrarTela();
