<?php
include "conexao.php";
include "funcoes.php";

$id = $_POST['id'] ?? $_GET['id'];
$produto = buscarProduto($conexao, $id);
$nome = $_POST['nome'] ?? null;
$marca = $_POST['marca'] ?? '';
$modelo = $_POST['modelo'] ?? '';
$categoria = $_POST['categoria'] ?? '';
$material = $_POST['material'] ?? '';
$tamanho = $_POST['tamanho'] ?? '';
$peso = $_POST['peso'] ?? '';
$tensao = $_POST['tensao'] ?? '';
$caracteristicas = $_POST['caracteristicas'] ?? '';
$estoque = $_POST['estoque'] ?? 0;
$estoque_minimo = $_POST['estoque_minimo'] ?? 0;

$salvo = $nome !== null && alterar_produto($conexao, $id, $nome, $marca, $modelo, $categoria, $material, $tamanho, $peso, $tensao, $caracteristicas, $estoque, $estoque_minimo);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Alterar produto</title></head>
<body>
    <p><a href="index.php">Início</a> | <a href="listar.php">Listar produtos</a></p>
    <h1>Alterar produto</h1>
    <p><?php echo $salvo ? 'Produto alterado com sucesso.' : ''; ?></p>
    <form method="post" action="alterar.php">
        <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">
        <label>Nome *</label><br><input required name="nome" value="<?php echo htmlspecialchars($produto['nome']); ?>"><br><br>
        <label>Marca *</label><br><input required name="marca" value="<?php echo htmlspecialchars($produto['marca']); ?>"><br><br>
        <label>Modelo *</label><br><input required name="modelo" value="<?php echo htmlspecialchars($produto['modelo']); ?>"><br><br>
        <label>Categoria *</label><br><input required name="categoria" value="<?php echo htmlspecialchars($produto['categoria']); ?>"><br><br>
        <label>Material ou cabo</label><br><input name="material" value="<?php echo htmlspecialchars($produto['material']); ?>"><br><br>
        <label>Tamanho</label><br><input name="tamanho" value="<?php echo htmlspecialchars($produto['tamanho']); ?>"><br><br>
        <label>Peso</label><br><input name="peso" value="<?php echo htmlspecialchars($produto['peso']); ?>"><br><br>
        <label>Tensão elétrica</label><br><input name="tensao" value="<?php echo htmlspecialchars($produto['tensao']); ?>"><br><br>
        <label>Estoque atual</label><br><input required min="0" type="number" name="estoque" value="<?php echo $produto['estoque']; ?>"><br><br>
        <label>Alerta abaixo de</label><br><input required min="0" type="number" name="estoque_minimo" value="<?php echo $produto['estoque_minimo']; ?>"><br><br>
        <label>Outras características</label><br><textarea name="caracteristicas"><?php echo htmlspecialchars($produto['caracteristicas']); ?></textarea><br><br>
        <button type="submit">Salvar alteração</button>
    </form>
</body>
</html>
