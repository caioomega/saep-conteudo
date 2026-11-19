<?php
// Altere estes dados se o seu MySQL tiver outro usuário ou senha.
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "loja_materiais";

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

if (!$conexao) {
    die("Erro na conexão: " . mysqli_connect_error());
}

mysqli_set_charset($conexao, "utf8mb4");
?>
