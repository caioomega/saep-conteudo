<?php
include "conexao.php";
include "funcoes.php";
if (isset($_GET['excluir'])) {
    excluirProduto($conexao, $_GET['excluir']);
    header("Location: listar.php");
    exit;
}
$produtos = listarProdutos($conexao);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Lista de produtos</title></head>
<body>
    <p><a href="index.php">Início</a> | <a href="cadastro.php">Cadastrar produto</a></p>
    <h1>Produtos cadastrados</h1>
    <table border="1">
        <tr><th>Nome</th><th>Marca</th><th>Modelo</th><th>Categoria</th><th>Características</th><th>Estoque</th><th>Estoque mínimo</th><th>Ações</th></tr>
        <?php while ($produto = mysqli_fetch_assoc($produtos)) { ?>
        <tr>
            <td><?php echo htmlspecialchars($produto['nome']); ?></td>
            <td><?php echo htmlspecialchars($produto['marca']); ?></td>
            <td><?php echo htmlspecialchars($produto['modelo']); ?></td>
            <td><?php echo htmlspecialchars($produto['categoria']); ?></td>
            <td><?php echo htmlspecialchars($produto['caracteristicas']); ?></td>
            <td><?php echo $produto['estoque']; ?></td>
            <td><?php echo $produto['estoque_minimo']; ?><?php if ($produto['estoque'] <= $produto['estoque_minimo']) echo " - ESTOQUE BAIXO"; ?></td>
            <td><a href="alterar.php?id=<?php echo $produto['id']; ?>">Editar</a> | <a href="listar.php?excluir=<?php echo $produto['id']; ?>">Excluir</a></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
