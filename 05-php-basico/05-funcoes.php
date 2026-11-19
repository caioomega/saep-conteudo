<?php
// ==============================================================
// 05 - FUNÇÕES
// Um "bloco de código com nome" que você pode chamar várias vezes.
// ==============================================================

// Criando uma função:
//   function nome($parametro1, $parametro2) { ... return resultado; }
function somar($a, $b) {
    return $a + $b;   // return = devolve o resultado
}

echo somar(2, 3) . "<br>";     // 5
$total = somar(10, 20);
echo "Total: $total<br>";      // 30

// Função que diz se o estoque está baixo
function estoqueBaixo($quantidade, $minimo) {
    if ($quantidade < $minimo) {
        return true;
    }
    return false;
}

if (estoqueBaixo(2, 5)) {
    echo "Estoque baixo!<br>";
}

// Função que formata dinheiro (use no projeto todo)
function dinheiro($valor) {
    return "R$ " . number_format($valor, 2, ',', '.');
}
echo dinheiro(1500.5) . "<br>";   // R$ 1.500,50

// Função com valor padrão (se não mandar, usa o padrão)
function saudacao($nome = "visitante") {
    return "Olá, $nome!";
}
echo saudacao() . "<br>";          // Olá, visitante!
echo saudacao("Caio") . "<br>";    // Olá, Caio!

// DICA: coloque suas funções num arquivo separado (funcoes.php) e
// use   include "funcoes.php";   no começo das outras páginas.
// Veja o 07-include.php.
?>
