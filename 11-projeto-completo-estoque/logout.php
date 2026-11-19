<?php
// Sai do sistema e volta pro login
session_start();
session_destroy();
header("Location: login.php?saiu=1");
exit;
?>
