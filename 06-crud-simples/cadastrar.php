<?php
// ==============================================================
// CADASTRAR.PHP - INSERIR (o "C" do CRUD)
// A mesma página MOSTRA o formulário e SALVA quando clicar no botão.
// ==============================================================
include "conexao.php";

$erro = "";
// Variáveis começam vazias (pra o formulário abrir vazio)
$nome = "";
$email = "";
$telefone = "";
$cidade = "";

// Entrou aqui = a pessoa clicou em "Salvar" (formulário enviado)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // 1) PEGAR os dados do formulário
    $nome     = trim($_POST['nome'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $cidade   = trim($_POST['cidade'] ?? '');

    // 2) VALIDAR
    if ($nome == "") {
        $erro = "O nome é obrigatório.";
    } elseif ($email == "") {
        $erro = "O e-mail é obrigatório.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Digite um e-mail válido.";
    }

    // 3) SALVAR (só se não teve erro)
    if ($erro == "") {
        // Protege os textos antes de colocar no SQL
        $n = mysqli_real_escape_string($conexao, $nome);
        $e = mysqli_real_escape_string($conexao, $email);
        $t = mysqli_real_escape_string($conexao, $telefone);
        $c = mysqli_real_escape_string($conexao, $cidade);

        $sql = "INSERT INTO clientes (nome, email, telefone, cidade)
                VALUES ('$n', '$e', '$t', '$c')";

        if (mysqli_query($conexao, $sql)) {
            // 4) Deu certo: volta pra lista com mensagem
            header("Location: index.php?msg=salvo");
            exit; // SEMPRE coloque exit depois do header Location
        } else {
            $erro = "Erro ao salvar: " . mysqli_error($conexao);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar cliente</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="topo">
        <strong>CRUD Simples</strong>
        <div><a href="index.php">Listar</a> <a href="cadastrar.php">Cadastrar</a></div>
    </div>

    <div class="conteudo">
        <h1>Cadastrar cliente</h1>

        <?php if ($erro != "") { ?>
            <div class="mensagem erro"><?php echo $erro; ?></div>
        <?php } ?>

        <!-- action vazio = envia pra esta mesma página -->
        <form method="post" action="">
            <label for="nome">Nome *</label>
            <input type="text" id="nome" name="nome" required value="<?php echo htmlspecialchars($nome); ?>">

            <label for="email">E-mail *</label>
            <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($email); ?>">

            <label for="telefone">Telefone</label>
            <input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($telefone); ?>">

            <label for="cidade">Cidade</label>
            <input type="text" id="cidade" name="cidade" value="<?php echo htmlspecialchars($cidade); ?>">

            <button type="submit">Salvar</button>
            <a href="index.php" class="botao botao-perigo">Cancelar</a>
        </form>
    </div>
</body>
</html>
