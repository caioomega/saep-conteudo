<?php
// ==============================================================
// 03 - REPETIÇÃO (FOR, WHILE, FOREACH)
// "Faça isso várias vezes."
// ==============================================================

// FOR: quando você sabe QUANTAS vezes
// for (começo; condição pra continuar; o que muda a cada volta)
echo "<h3>for de 1 a 5</h3>";
for ($i = 1; $i <= 5; $i++) {
    echo "Volta número $i<br>";
}

// Tabuada do 7
echo "<h3>Tabuada do 7</h3>";
for ($i = 1; $i <= 10; $i++) {
    echo "7 x $i = " . (7 * $i) . "<br>";
}

// WHILE: repete ENQUANTO a condição for verdade
echo "<h3>while</h3>";
$contador = 3;
while ($contador > 0) {
    echo "Contagem: $contador<br>";
    $contador--;  // diminui 1 (se esquecer, fica rodando pra sempre!)
}

// No banco de dados, o while é usado assim (você vai ver na pasta 06):
//   while ($linha = mysqli_fetch_assoc($resultado)) {
//       echo $linha['nome'];
//   }
// Ele pega uma linha por vez até acabarem as linhas.

// FOREACH: passa por cada item de uma lista (array)
echo "<h3>foreach</h3>";
$frutas = ["maçã", "banana", "uva"];
foreach ($frutas as $fruta) {
    echo "Fruta: $fruta<br>";
}

// foreach com a posição (índice)
foreach ($frutas as $posicao => $fruta) {
    echo "Posição $posicao: $fruta<br>";
}

// Montar uma tabela HTML com repetição
echo "<h3>Tabela gerada com for</h3>";
echo "<table border='1'><tr><th>Número</th><th>Dobro</th></tr>";
for ($i = 1; $i <= 4; $i++) {
    echo "<tr><td>$i</td><td>" . ($i * 2) . "</td></tr>";
}
echo "</table>";
?>
