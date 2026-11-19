<?php
// ==============================================================
// INSERTION SORT (ordenação por inserção) - EM PHP
//
// IDEIA: igual organizar cartas na mão. Pega uma carta por vez e
// "encaixa" ela no lugar certo entre as que já estão organizadas.
//
// Exemplo com [5, 3, 8, 1]:
//   pega 3: [3, 5, 8, 1]
//   pega 8: [3, 5, 8, 1]  (já está no lugar)
//   pega 1: [1, 3, 5, 8]  (vai empurrando os maiores pra direita)
// ==============================================================

function insertionSort($lista) {
    $n = count($lista);
    for ($i = 1; $i < $n; $i++) {
        $atual = $lista[$i];      // a "carta" que vou encaixar
        $j = $i - 1;
        // empurra pra direita todo mundo que é maior que a atual
        while ($j >= 0 && $lista[$j] > $atual) {
            $lista[$j + 1] = $lista[$j];
            $j--;
        }
        $lista[$j + 1] = $atual;  // encaixa no buraco que sobrou
    }
    return $lista;
}

// Versão pra ordenar linhas do banco por um campo de texto
function insertionSortPorCampo($linhas, $campo) {
    $n = count($linhas);
    for ($i = 1; $i < $n; $i++) {
        $atual = $linhas[$i];
        $j = $i - 1;
        while ($j >= 0 && strcasecmp($linhas[$j][$campo], $atual[$campo]) > 0) {
            $linhas[$j + 1] = $linhas[$j];
            $j--;
        }
        $linhas[$j + 1] = $atual;
    }
    return $linhas;
}

// ================== TESTANDO ==================
$numeros = [5, 3, 8, 1, 9, 2];
echo "Antes: " . implode(", ", $numeros) . "<br>";
echo "Depois: " . implode(", ", insertionSort($numeros)) . "<br><br>";

$produtos = [
    ['nome' => 'Serrote'],
    ['nome' => 'alicate'],
    ['nome' => 'Martelo'],
];
foreach (insertionSortPorCampo($produtos, 'nome') as $p) {
    echo $p['nome'] . "<br>";
}
?>
