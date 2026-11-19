<?php
// ==============================================================
// VERIFICA_LOGIN.PHP - o "segurança da porta"
// Coloque  include "verifica_login.php";  na PRIMEIRA linha de toda
// página que só quem fez login pode ver.
// Se a pessoa não fez login, ela é mandada pro login.php.
// ==============================================================

// Só inicia a sessão se ela ainda não foi iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
?>
