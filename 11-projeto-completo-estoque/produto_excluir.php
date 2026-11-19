<?php
// ==============================================================
// PRODUTO_EXCLUIR.PHP - apaga o produto e volta pra lista
// (o histórico dele é apagado junto por causa do ON DELETE CASCADE)
// ==============================================================
include "verifica_login.php";
include "conexao.php";

$id = (int)($_GET['id'] ?? 0);
if ($id > 0) {
    mysqli_query($conexao, "DELETE FROM produtos WHERE id = $id");
}
header("Location: produtos.php?msg=excluido");
exit;
?>
