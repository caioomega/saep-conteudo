<?php
// ==============================================================
// 04 - ARRAYS (LISTAS)
// Uma variável que guarda VÁRIOS valores.
// ==============================================================

// Lista simples: as posições começam no 0 (zero)!
$nomes = ["Ana", "Bruno", "Carla"];
echo $nomes[0] . "<br>";   // Ana
echo $nomes[2] . "<br>";   // Carla
echo "Total: " . count($nomes) . "<br>";  // 3

$nomes[] = "Diego";        // adiciona no final
echo "Agora tem " . count($nomes) . "<br>";

// Array com NOMES nas posições (associativo)
// É EXATAMENTE assim que uma linha do banco chega no PHP!
$produto = [
    "id" => 1,
    "nome" => "Martelo",
    "quantidade" => 10,
];
echo "Produto: " . $produto['nome'] . " - Qtd: " . $produto['quantidade'] . "<br>";

// Lista de produtos (array dentro de array) = várias linhas do banco
$produtos = [
    ["nome" => "Serrote",  "quantidade" => 4],
    ["nome" => "Alicate",  "quantidade" => 12],
    ["nome" => "Martelo",  "quantidade" => 2],
];

echo "<h3>Lista de produtos</h3>";
foreach ($produtos as $p) {
    echo $p['nome'] . " (" . $p['quantidade'] . ")<br>";
}

// Funções úteis de array
echo "<h3>Funções</h3>";
$numeros = [5, 3, 9, 1];
echo "Soma: " . array_sum($numeros) . "<br>";
echo "Maior: " . max($numeros) . "<br>";
echo "Tem o 9? " . (in_array(9, $numeros) ? "sim" : "não") . "<br>";

// sort() ordena pronto (mas a prova pode pedir pra você FAZER o
// algoritmo de ordenação na mão -> veja a pasta 09)
sort($numeros);
echo "Ordenado: " . implode(", ", $numeros) . "<br>";  // implode junta com vírgula

// Mostrar o array inteiro pra debugar
echo "<pre>";
print_r($produtos);
echo "</pre>";
?>
