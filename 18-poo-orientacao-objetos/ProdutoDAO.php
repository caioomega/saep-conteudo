<?php
// ==============================================================
// PRODUTODAO.PHP - CRUD orientado a objetos com PDO
// (o jeito "mais profissional" de acessar o banco em PHP)
// Usa o banco saep_estoque da pasta 11.
// Abra: localhost/18-poo-orientacao-objetos/ProdutoDAO.php
//
// PDO x mysqli: os dois funcionam. O PDO usa "prepared statements"
// (os ? ou :nome) que protegem contra SQL Injection sem precisar
// de mysqli_real_escape_string.
// ==============================================================

class ProdutoDAO {
    private PDO $pdo;

    public function __construct() {
        // "mysql:host=...;dbname=...;charset=..." , usuário, senha
        $this->pdo = new PDO("mysql:host=localhost;dbname=saep_estoque;charset=utf8mb4", "root", "");
        // Faz o PDO avisar erro com exceção (fica mais fácil achar o problema)
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Linhas vêm como array associativo: $linha['nome']
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    // R - listar todos
    public function listar(): array {
        return $this->pdo->query("SELECT * FROM produtos ORDER BY nome")->fetchAll();
    }

    // R - buscar um pelo id
    public function buscar(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM produtos WHERE id = ?");
        $stmt->execute([$id]);                 // o ? vira o $id
        return $stmt->fetch() ?: null;
    }

    // C - inserir (devolve o id novo)
    public function inserir(string $nome, int $quantidade, int $minimo): int {
        $stmt = $this->pdo->prepare(
            "INSERT INTO produtos (nome, quantidade, estoque_minimo) VALUES (:nome, :qtd, :min)"
        );
        $stmt->execute([':nome' => $nome, ':qtd' => $quantidade, ':min' => $minimo]);
        return (int)$this->pdo->lastInsertId();
    }

    // U - alterar
    public function alterar(int $id, string $nome, int $quantidade, int $minimo): bool {
        $stmt = $this->pdo->prepare(
            "UPDATE produtos SET nome = ?, quantidade = ?, estoque_minimo = ? WHERE id = ?"
        );
        return $stmt->execute([$nome, $quantidade, $minimo, $id]);
    }

    // D - excluir
    public function excluir(int $id): bool {
        return $this->pdo->prepare("DELETE FROM produtos WHERE id = ?")->execute([$id]);
    }
}

// ================== TESTE ==================
try {
    $dao = new ProdutoDAO();
    $novoId = $dao->inserir("Produto teste POO", 5, 2);
    $dao->alterar($novoId, "Produto teste POO (alterado)", 1, 2);
    foreach ($dao->listar() as $p) {
        echo htmlspecialchars($p['nome']) . " - " . $p['quantidade'] . "<br>";
    }
    $dao->excluir($novoId);
    echo "<p>Teste de inserir, alterar, listar e excluir OK.</p>";
} catch (PDOException $e) {
    echo "Erro no banco: " . $e->getMessage();
}
?>
