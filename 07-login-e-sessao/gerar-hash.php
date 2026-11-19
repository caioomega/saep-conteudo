<?php
// ==============================================================
// GERAR-HASH.PHP - cria a senha criptografada pra colocar no banco
// Abra: localhost/07-login-e-sessao/gerar-hash.php
// Digite a senha, copie o resultado e use no INSERT do seu .sql:
//   INSERT INTO usuarios (nome, login, senha) VALUES ('Fulano', 'fulano', 'COLE_AQUI');
// ==============================================================
$senha = $_POST['senha'] ?? '';
$hash = $senha != '' ? password_hash($senha, PASSWORD_DEFAULT) : '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Gerar hash</title><link rel="stylesheet" href="estilo.css"></head>
<body>
    <div class="conteudo">
        <h1>Gerar senha criptografada</h1>
        <form method="post">
            <label>Senha</label>
            <input type="text" name="senha" value="<?php echo htmlspecialchars($senha); ?>">
            <button type="submit">Gerar</button>
        </form>
        <?php if ($hash != '') { ?>
            <p>Copie isto:</p>
            <input type="text" readonly value="<?php echo $hash; ?>" onclick="this.select()">
        <?php } ?>
    </div>
</body>
</html>
