<?php
// Todas as ações do sistema ficam aqui, de forma procedural e simples.

function limpar($conexao, $texto) {
    return mysqli_real_escape_string($conexao, trim($texto));
}

function listarProdutos($conexao) {
    $sql = "SELECT * FROM produtos ORDER BY nome";
    return mysqli_query($conexao, $sql);
}

function buscarProduto($conexao, $id) {
    $id = (int)$id;
    $sql = "SELECT * FROM produtos WHERE id = $id";
    return mysqli_fetch_assoc(mysqli_query($conexao, $sql));
}

function gravar_produto($conexao, $nome, $marca, $modelo, $categoria, $material, $tamanho, $peso, $tensao, $caracteristicas, $estoque, $estoque_minimo) {
    $nome = limpar($conexao, $nome);
    $marca = limpar($conexao, $marca);
    $modelo = limpar($conexao, $modelo);
    $categoria = limpar($conexao, $categoria);
    $material = limpar($conexao, $material);
    $tamanho = limpar($conexao, $tamanho);
    $peso = limpar($conexao, $peso);
    $tensao = limpar($conexao, $tensao);
    $caracteristicas = limpar($conexao, $caracteristicas);
    $estoque = (int)$estoque;
    $estoque_minimo = (int)$estoque_minimo;

    $sql = "INSERT INTO produtos (nome, marca, modelo, categoria, material, tamanho, peso, tensao, caracteristicas, estoque, estoque_minimo) VALUES ('$nome', '$marca', '$modelo', '$categoria', '$material', '$tamanho', '$peso', '$tensao', '$caracteristicas', $estoque, $estoque_minimo)";
    return mysqli_query($conexao, $sql);
}

function alterar_produto($conexao, $id, $nome, $marca, $modelo, $categoria, $material, $tamanho, $peso, $tensao, $caracteristicas, $estoque, $estoque_minimo) {
    $id = (int)$id;
    $nome = limpar($conexao, $nome);
    $marca = limpar($conexao, $marca);
    $modelo = limpar($conexao, $modelo);
    $categoria = limpar($conexao, $categoria);
    $material = limpar($conexao, $material);
    $tamanho = limpar($conexao, $tamanho);
    $peso = limpar($conexao, $peso);
    $tensao = limpar($conexao, $tensao);
    $caracteristicas = limpar($conexao, $caracteristicas);
    $estoque = (int)$estoque;
    $estoque_minimo = (int)$estoque_minimo;

    $sql = "UPDATE produtos SET nome='$nome', marca='$marca', modelo='$modelo', categoria='$categoria', material='$material', tamanho='$tamanho', peso='$peso', tensao='$tensao', caracteristicas='$caracteristicas', estoque=$estoque, estoque_minimo=$estoque_minimo WHERE id=$id";
    return mysqli_query($conexao, $sql);
}

function excluirProduto($conexao, $id) {
    $id = (int)$id;
    return mysqli_query($conexao, "DELETE FROM produtos WHERE id = $id");
}

function registrarMovimentacao($conexao) {
    $produto_id = (int)$_POST['produto_id'];
    $tipo = $_POST['tipo'] == 'saida' ? 'saida' : 'entrada';
    $quantidade = (int)$_POST['quantidade'];
    $observacao = limpar($conexao, $_POST['observacao']);
    $produto = buscarProduto($conexao, $produto_id);

    if (!$produto || $quantidade <= 0) return false;
    if ($tipo == 'saida' && $quantidade > $produto['estoque']) return false;

    if ($tipo == 'entrada') {
        $novo_estoque = $produto['estoque'] + $quantidade;
    } else {
        $novo_estoque = $produto['estoque'] - $quantidade;
    }

    mysqli_query($conexao, "INSERT INTO movimentacoes (produto_id, tipo, quantidade, observacao) VALUES ($produto_id, '$tipo', $quantidade, '$observacao')");
    return mysqli_query($conexao, "UPDATE produtos SET estoque = $novo_estoque WHERE id = $produto_id");
}
?>
