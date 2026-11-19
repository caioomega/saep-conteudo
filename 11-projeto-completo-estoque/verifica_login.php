<?php
// ==============================================================
// VERIFICA_LOGIN.PHP - bloqueia quem não fez login.
// Inclua na PRIMEIRA linha de toda página protegida.
// ==============================================================
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
?>
