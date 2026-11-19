<?php
// Conexão com o banco (mesma ideia da pasta 06)
$servidor = "localhost";
$usuario  = "root";
$senha    = "";
$banco    = "login_teste";

mysqli_report(MYSQLI_REPORT_OFF);
$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);
if (!$conexao) {
    die("Erro ao conectar no banco: " . mysqli_connect_error());
}
mysqli_set_charset($conexao, "utf8mb4");
?>
