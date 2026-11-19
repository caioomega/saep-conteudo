<?php
// ==============================================================
// LOGIN.PHP - autenticação do usuário
// ==============================================================
session_start();
include "conexao.php";
include "funcoes.php";

// Já está logado? Vai pra tela principal.
if (isset($_SESSION['usuario_id'])) {
    header("Location: principal.php");
    exit;
}

$erro = "";
$login = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = trim($_POST['login'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($login == "" || $senha == "") {
        $erro = "Preencha o login e a senha.";
    } else {
        $l = mysqli_real_escape_string($conexao, $login);
        $resultado = mysqli_query($conexao, "SELECT * FROM usuarios WHERE login = '$l'");
        $usuario = mysqli_fetch_assoc($resultado);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            header("Location: principal.php");
            exit;
        } else {
            // Falhou: mostra mensagem e continua na tela de login
            $erro = "Login ou senha incorretos.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Controle de Estoque</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="caixa-login">
        <h1>Controle de Estoque</h1>

        <?php if ($erro != "") { ?>
            <div class="mensagem erro"><?php echo $erro; ?></div>
        <?php } ?>
        <?php if (isset($_GET['saiu'])) { ?>
            <div class="mensagem sucesso">Você saiu do sistema.</div>
        <?php } ?>

        <form method="post" action="">
            <label for="login">Login</label>
            <input type="text" id="login" name="login" required value="<?php echo e($login); ?>">

            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>

            <button type="submit" style="width:100%">Entrar</button>
        </form>
    </div>
</body>
</html>
