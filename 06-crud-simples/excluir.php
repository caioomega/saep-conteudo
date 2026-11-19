<?php
// ==============================================================
// EXCLUIR.PHP - APAGAR (o "D" do CRUD)
// É chamado pelo link: excluir.php?id=3
// Não tem tela: apaga e volta pra lista.
// ==============================================================
include "conexao.php";

$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {
    mysqli_query($conexao, "DELETE FROM clientes WHERE id = $id");
}

header("Location: index.php?msg=excluido");
exit;
?>
