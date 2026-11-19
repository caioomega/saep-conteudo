<?php
// ==============================================================
// CONEXAO.PHP - liga o PHP no banco de dados.
// Todas as outras páginas fazem:  include "conexao.php";
// ==============================================================

// Se o MySQL tiver outro usuário/senha, troque AQUI (só aqui).
$servidor = "localhost";
$usuario  = "root";
$senha    = "";              // no XAMPP normalmente é vazio
$banco    = "crud_simples";  // nome do banco criado no banco.sql

// Faz o PHP não "travar" com tela de erro feia; a gente trata o erro.
mysqli_report(MYSQLI_REPORT_OFF);

// Conecta
$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

// Se não conectou, para tudo e mostra o motivo
if (!$conexao) {
    die("Erro ao conectar no banco: " . mysqli_connect_error());
}

// Acentos funcionando
mysqli_set_charset($conexao, "utf8mb4");
?>
