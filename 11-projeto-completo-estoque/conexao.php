<?php
// ==============================================================
// CONEXAO.PHP - conexão com o banco
// Se o MySQL tiver outro usuário/senha, troque SÓ AQUI.
// ==============================================================
$servidor = "localhost";
$usuario  = "root";
$senha    = "";
$banco    = "saep_estoque";

mysqli_report(MYSQLI_REPORT_OFF);
$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

if (!$conexao) {
    die("Erro ao conectar no banco: " . mysqli_connect_error());
}
mysqli_set_charset($conexao, "utf8mb4");
?>
