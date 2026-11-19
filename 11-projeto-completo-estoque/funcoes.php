<?php
// ==============================================================
// FUNCOES.PHP - funções usadas em várias páginas
// ==============================================================

// Mostra texto com segurança no HTML (evita código malicioso)
function e($texto) {
    return htmlspecialchars((string)$texto);
}

// 1234.5 -> "R$ 1.234,50"
function dinheiro($valor) {
    return "R$ " . number_format((float)$valor, 2, ',', '.');
}

// "2026-11-17" -> "17/11/2026"
function data_br($data) {
    return date('d/m/Y', strtotime($data));
}

// ==============================================================
// ALGORITMO DE ORDENAÇÃO: BUBBLE SORT
// Ordena uma lista de linhas do banco pelo campo informado,
// em ordem alfabética (A -> Z), sem usar ORDER BY nem sort().
// Compara os vizinhos de 2 em 2 e troca se estiverem fora de ordem.
// ==============================================================
function bubbleSortPorCampo($lista, $campo) {
    $n = count($lista);
    for ($i = 0; $i < $n - 1; $i++) {
        for ($j = 0; $j < $n - 1 - $i; $j++) {
            if (strcasecmp($lista[$j][$campo], $lista[$j + 1][$campo]) > 0) {
                $temp = $lista[$j];
                $lista[$j] = $lista[$j + 1];
                $lista[$j + 1] = $temp;
            }
        }
    }
    return $lista;
}

// ==============================================================
// VALIDAÇÃO DO PRODUTO (usada no cadastrar e no editar)
// Devolve "" se estiver tudo certo, ou a mensagem de erro.
// ==============================================================
function validarProduto($nome, $preco, $quantidade, $estoque_minimo) {
    if ($nome == "") {
        return "O nome do produto é obrigatório.";
    }
    if (!is_numeric($preco) || $preco < 0) {
        return "O preço tem que ser um número maior ou igual a zero (use ponto: 10.50).";
    }
    // ctype_digit = só dígitos 0-9 (não aceita negativo nem vírgula)
    if (!ctype_digit((string)$quantidade)) {
        return "A quantidade tem que ser um número inteiro maior ou igual a zero.";
    }
    if (!ctype_digit((string)$estoque_minimo)) {
        return "O estoque mínimo tem que ser um número inteiro maior ou igual a zero.";
    }
    return "";
}

// Busca todos os produtos e devolve como lista (array) já ordenada
// pelo nome usando o Bubble Sort acima.
function produtosOrdenados($conexao) {
    $resultado = mysqli_query($conexao, "SELECT * FROM produtos"); // sem ORDER BY de propósito
    $produtos = [];
    while ($linha = mysqli_fetch_assoc($resultado)) {
        $produtos[] = $linha;
    }
    return bubbleSortPorCampo($produtos, 'nome');
}
?>
