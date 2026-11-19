<?php
include "conexao.php";
$sql = "SELECT movimentacoes.*, produtos.nome FROM movimentacoes INNER JOIN produtos ON movimentacoes.produto_id = produtos.id WHERE movimentacoes.tipo = 'saida' ORDER BY movimentacoes.data_movimentacao DESC";
$saidas = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Saídas de estoque</title></head>
<body>
    <p><a href="index.php">Início</a> | <a href="estoque.php">Movimentar estoque</a></p>
    <h1>Saídas de estoque</h1>
    <table border="1">
        <tr><th>Produto</th><th>Quantidade</th><th>Observação</th><th>Data</th></tr>
        <?php while ($saida = mysqli_fetch_assoc($saidas)) { ?>
        <tr><td><?php echo htmlspecialchars($saida['nome']); ?></td><td><?php echo $saida['quantidade']; ?></td><td><?php echo htmlspecialchars($saida['observacao']); ?></td><td><?php echo $saida['data_movimentacao']; ?></td></tr>
        <?php } ?>
    </table>
</body>
</html>
