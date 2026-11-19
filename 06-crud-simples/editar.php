<?php
// ==============================================================
// EDITAR.PHP - ALTERAR (o "U" do CRUD)
// 1. Abre com editar.php?id=3 -> busca o cliente 3 e preenche o form
// 2. Clicou em salvar -> faz o UPDATE
// ==============================================================
include "conexao.php";

$erro = "";

// (int) transforma em número: protege contra coisa estranha na URL
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

// ---------- SALVAR A ALTERAÇÃO ----------
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome     = trim($_POST['nome'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $cidade   = trim($_POST['cidade'] ?? '');

    if ($nome == "") {
        $erro = "O nome é obrigatório.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Digite um e-mail válido.";
    }

    if ($erro == "") {
        $n = mysqli_real_escape_string($conexao, $nome);
        $e = mysqli_real_escape_string($conexao, $email);
        $t = mysqli_real_escape_string($conexao, $telefone);
        $c = mysqli_real_escape_string($conexao, $cidade);

        // NUNCA ESQUEÇA O WHERE id = ...
        $sql = "UPDATE clientes
                SET nome='$n', email='$e', telefone='$t', cidade='$c'
                WHERE id = $id";

        if (mysqli_query($conexao, $sql)) {
            header("Location: index.php?msg=editado");
            exit;
        } else {
            $erro = "Erro ao alterar: " . mysqli_error($conexao);
        }
    }
    // Se deu erro, o formulário mostra o que a pessoa digitou
    $cliente = ['nome' => $nome, 'email' => $email, 'telefone' => $telefone, 'cidade' => $cidade];

} else {
    // ---------- ABRIU A PÁGINA: BUSCAR O CLIENTE ----------
    $resultado = mysqli_query($conexao, "SELECT * FROM clientes WHERE id = $id");
    $cliente = mysqli_fetch_assoc($resultado); // pega UMA linha só

    // Se não existe cliente com esse id, volta pra lista
    if (!$cliente) {
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar cliente</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="topo">
        <strong>CRUD Simples</strong>
        <div><a href="index.php">Listar</a> <a href="cadastrar.php">Cadastrar</a></div>
    </div>

    <div class="conteudo">
        <h1>Editar cliente</h1>

        <?php if ($erro != "") { ?>
            <div class="mensagem erro"><?php echo $erro; ?></div>
        <?php } ?>

        <form method="post" action="editar.php">
            <!-- O id vai escondido pra saber QUAL cliente alterar -->
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <label for="nome">Nome *</label>
            <input type="text" id="nome" name="nome" required value="<?php echo htmlspecialchars($cliente['nome']); ?>">

            <label for="email">E-mail *</label>
            <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($cliente['email']); ?>">

            <label for="telefone">Telefone</label>
            <input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($cliente['telefone']); ?>">

            <label for="cidade">Cidade</label>
            <input type="text" id="cidade" name="cidade" value="<?php echo htmlspecialchars($cliente['cidade']); ?>">

            <button type="submit">Salvar alteração</button>
            <a href="index.php" class="botao botao-perigo">Cancelar</a>
        </form>
    </div>
</body>
</html>
