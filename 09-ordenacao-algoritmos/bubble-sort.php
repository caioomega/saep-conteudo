<?php
// ==============================================================
// BUBBLE SORT (ordenação por "bolha") - EM PHP
//
// IDEIA: passa pela lista comparando os vizinhos, 2 a 2.
// Se o da esquerda for "maior" que o da direita, TROCA eles de lugar.
// Repete até não precisar trocar mais. Os maiores vão "subindo" pro
// final igual bolha na água, por isso o nome.
//
// Exemplo com [5, 3, 8, 1]:
//   volta 1: [3, 5, 8, 1] -> [3, 5, 8, 1] -> [3, 5, 1, 8]  (8 foi pro fim)
//   volta 2: [3, 5, 1, 8] -> [3, 1, 5, 8]                  (5 no lugar)
//   volta 3: [1, 3, 5, 8]                                   pronto!
//
// Abra: localhost/09-ordenacao-algoritmos/bubble-sort.php
// ==============================================================

// ---------- 1) ORDENAR NÚMEROS ----------
function bubbleSortNumeros($lista) {
    $n = count($lista);                       // quantos itens tem

    for ($i = 0; $i < $n - 1; $i++) {          // quantas voltas
        for ($j = 0; $j < $n - 1 - $i; $j++) { // compara os vizinhos
            if ($lista[$j] > $lista[$j + 1]) {
                // TROCA usando uma variável temporária
                $temp = $lista[$j];
                $lista[$j] = $lista[$j + 1];
                $lista[$j + 1] = $temp;
            }
        }
    }
    return $lista;
}

// ---------- 2) ORDENAR NOMES (ordem alfabética) ----------
// strcasecmp(a, b) compara dois textos sem ligar pra maiúscula/minúscula:
//   devolve número > 0 se a vem DEPOIS de b no alfabeto
//   devolve número < 0 se a vem ANTES de b
//   devolve 0 se são iguais
function bubbleSortTexto($lista) {
    $n = count($lista);
    for ($i = 0; $i < $n - 1; $i++) {
        for ($j = 0; $j < $n - 1 - $i; $j++) {
            if (strcasecmp($lista[$j], $lista[$j + 1]) > 0) {
                $temp = $lista[$j];
                $lista[$j] = $lista[$j + 1];
                $lista[$j + 1] = $temp;
            }
        }
    }
    return $lista;
}

// ---------- 3) ORDENAR LINHAS DO BANCO PELO NOME ----------
// (É ESTE que você usa na prova pra "listar produtos em ordem
//  alfabética usando algoritmo de ordenação")
// $produtos é uma lista de arrays: [ ['nome'=>'Serrote', ...], ... ]
function bubbleSortPorCampo($produtos, $campo) {
    $n = count($produtos);
    for ($i = 0; $i < $n - 1; $i++) {
        for ($j = 0; $j < $n - 1 - $i; $j++) {
            if (strcasecmp($produtos[$j][$campo], $produtos[$j + 1][$campo]) > 0) {
                $temp = $produtos[$j];          // troca a LINHA inteira
                $produtos[$j] = $produtos[$j + 1];
                $produtos[$j + 1] = $temp;
            }
        }
    }
    return $produtos;
}

// ================== TESTANDO ==================
$numeros = [5, 3, 8, 1, 9, 2];
echo "<h2>Números</h2>";
echo "Antes: " . implode(", ", $numeros) . "<br>";
echo "Depois: " . implode(", ", bubbleSortNumeros($numeros)) . "<br>";

$nomes = ["Serrote", "alicate", "Martelo", "Chave de fenda", "Broca"];
echo "<h2>Nomes</h2>";
echo "Antes: " . implode(", ", $nomes) . "<br>";
echo "Depois: " . implode(", ", bubbleSortTexto($nomes)) . "<br>";

$produtos = [
    ['nome' => 'Serrote', 'quantidade' => 4],
    ['nome' => 'Alicate', 'quantidade' => 12],
    ['nome' => 'Martelo', 'quantidade' => 2],
];
echo "<h2>Produtos (como vêm do banco)</h2>";
foreach (bubbleSortPorCampo($produtos, 'nome') as $p) {
    echo $p['nome'] . " - " . $p['quantidade'] . "<br>";
}

// COMO PEGAR DO BANCO E ORDENAR (veja o estoque.php da pasta 11):
//
//   $resultado = mysqli_query($conexao, "SELECT * FROM produtos");  // SEM ORDER BY
//   $produtos = [];
//   while ($linha = mysqli_fetch_assoc($resultado)) {
//       $produtos[] = $linha;        // guarda cada linha na lista
//   }
//   $produtos = bubbleSortPorCampo($produtos, 'nome');
//   foreach ($produtos as $p) { echo $p['nome']; }
?>
