<?php
include "conexao.php";
include "funcoes.php";
$mensagem = "";
if (isset($_POST['produto_id'])) {
    $mensagem = registrarMovimentacao($conexao) ? "Movimentação registrada com sucesso." : "Não foi possível registrar. Confira a quantidade em estoque.";
}
$produtos = listarProdutos($conexao);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Movimentar estoque</title></head>
<body>
    <p><a href="index.php">Início</a> | <a href="listar.php">Listar produtos</a></p>
    <h1>Entrada ou saída de estoque</h1>
    <?php if ($mensagem != "") { ?><p><?php echo $mensagem; ?></p><?php } ?>
    <form method="post" action="estoque.php">
        <label>Produto</label><br>
        <select name="produto_id" required><?php while ($produto = mysqli_fetch_assoc($produtos)) { ?><option value="<?php echo $produto['id']; ?>"><?php echo htmlspecialchars($produto['nome']); ?></option><?php } ?></select><br><br>
        <label>Tipo</label><br><select name="tipo"><option value="entrada">Entrada</option><option value="saida">Saída</option></select><br><br>
        <label>Quantidade</label><br><input required min="1" type="number" name="quantidade"><br><br>
        <label>Observação</label><br><input name="observacao"><br><br>
        <button type="submit">Salvar movimentação</button>
    </form>
</body>
</html>
