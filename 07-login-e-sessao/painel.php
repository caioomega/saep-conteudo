<?php
// ==============================================================
// PAINEL.PHP - página protegida (só entra quem fez login)
// ==============================================================
include "verifica_login.php";   // <- isso é o que protege a página
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="topo">
        <!-- Mostra o nome de quem está logado (a prova costuma pedir!) -->
        <span>Olá, <strong><?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></strong></span>
        <div>
            <a href="painel.php">Início</a>
            <a href="logout.php">Sair</a>
        </div>
    </div>
    <div class="conteudo">
        <h1>Painel principal</h1>
        <p>Você só está vendo esta página porque fez login.</p>
        <p>Teste: clique em "Sair" e depois tente abrir <code>localhost/07-login-e-sessao/painel.php</code>
           direto pelo endereço. Você vai ser mandado de volta pro login.</p>
    </div>
</body>
</html>
