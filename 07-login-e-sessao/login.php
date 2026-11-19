<?php
// ==============================================================
// LOGIN.PHP - tela de login
// ==============================================================

// session_start() TEM que ser a primeira coisa, antes de qualquer HTML.
// A "sessão" é uma memória do servidor que lembra quem está logado
// enquanto o navegador estiver aberto.
session_start();
include "conexao.php";

// Se já está logado, nem mostra o login: vai direto pro painel
if (isset($_SESSION['usuario_id'])) {
    header("Location: painel.php");
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
        // Procura o usuário pelo login
        $login_seguro = mysqli_real_escape_string($conexao, $login);
        $resultado = mysqli_query($conexao, "SELECT * FROM usuarios WHERE login = '$login_seguro'");
        $usuario = mysqli_fetch_assoc($resultado);

        // password_verify compara a senha digitada com o hash do banco
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // DEU CERTO: guarda na sessão quem é
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];

            header("Location: painel.php");
            exit;
        } else {
            // Mensagem genérica (não diga se foi o login ou a senha que errou)
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
    <title>Login</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="caixa-login">
        <h1>Entrar</h1>

        <?php if ($erro != "") { ?>
            <div class="mensagem erro"><?php echo $erro; ?></div>
        <?php } ?>

        <?php if (isset($_GET['saiu'])) { ?>
            <div class="mensagem sucesso">Você saiu do sistema.</div>
        <?php } ?>

        <form method="post" action="">
            <label for="login">Login</label>
            <input type="text" id="login" name="login" required value="<?php echo htmlspecialchars($login); ?>">

            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>

            <button type="submit" style="width:100%">Entrar</button>
        </form>
        <p style="font-size:13px;color:#666">Teste: admin / 123</p>
    </div>
</body>
</html>
