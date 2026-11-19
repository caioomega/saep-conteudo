<?php
// ARQUIVO DE TESTE
// Copie este arquivo para C:\xampp\htdocs\teste.php
// e abra no navegador: localhost/teste.php

echo "<h1>O PHP está funcionando!</h1>";
echo "<p>Versão do PHP: " . phpversion() . "</p>";

// Agora testa se consegue conectar no MySQL.
// Se o seu MySQL tiver senha, coloque ela entre as aspas de $senha.
$senha = "";
mysqli_report(MYSQLI_REPORT_OFF); // faz o erro aparecer como texto em vez de travar a página
$conexao = @mysqli_connect("localhost", "root", $senha);

if ($conexao) {
    echo "<p style='color:green'>Conectou no MySQL! Versão: " . mysqli_get_server_info($conexao) . "</p>";
} else {
    echo "<p style='color:red'>NÃO conectou no MySQL: " . mysqli_connect_error() . "</p>";
    echo "<p>Veja a pasta 13-erros-comuns.</p>";
}
?>
