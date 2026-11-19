<?php
// ==============================================================
// LOGOUT.PHP - sair do sistema
// Apaga a sessão (esquece quem estava logado) e volta pro login.
// ==============================================================
session_start();
session_destroy();
header("Location: login.php?saiu=1");
exit;
?>
