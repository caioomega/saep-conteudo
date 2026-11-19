<?php
include "conexao.php";
include "funcoes.php";

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

$salvo = $nome !== null && gravar_produto($conexao, $nome, $marca, $modelo, $categoria, $material, $tamanho, $peso, $tensao, $caracteristicas, $estoque, $estoque_minimo);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Cadastrar produto</title></head>
<body>
    <p><a href="index.php">Início</a> | <a href="listar.php">Listar produtos</a></p>
    <h1>Cadastrar produto</h1>
    <p><?php echo $salvo ? 'Produto salvo com sucesso.' : ''; ?></p>
    <form method="post" action="cadastro.php">
        <label>Nome *</label><br><input required name="nome"><br><br>
        <label>Marca *</label><br><input required name="marca"><br><br>
        <label>Modelo *</label><br><input required name="modelo"><br><br>
        <label>Categoria *</label><br><input required name="categoria"><br><br>
        <label>Material ou cabo</label><br><input name="material"><br><br>
        <label>Tamanho</label><br><input name="tamanho"><br><br>
        <label>Peso</label><br><input name="peso"><br><br>
        <label>Tensão elétrica</label><br><input name="tensao"><br><br>
        <label>Estoque atual</label><br><input required min="0" type="number" name="estoque" value="0"><br><br>
        <label>Alerta abaixo de</label><br><input required min="0" type="number" name="estoque_minimo" value="0"><br><br>
        <label>Outras características</label><br><textarea name="caracteristicas"></textarea><br><br>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>
