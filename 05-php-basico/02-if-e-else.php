<?php
// ==============================================================
// 02 - CONDIÇÕES (IF / ELSE)
// "Se acontecer isso, faça aquilo. Senão, faça outra coisa."
// ==============================================================

$quantidade = 2;
$estoque_minimo = 5;

// COMPARAÇÕES:
//   ==  igual           !=  diferente
//   >   maior           <   menor
//   >=  maior ou igual  <=  menor ou igual
//   &&  E (as duas coisas têm que ser verdade)
//   ||  OU (basta uma ser verdade)
//   !   NÃO (inverte)

if ($quantidade < $estoque_minimo) {
    echo "<p style='color:red'>ALERTA: estoque abaixo do mínimo!</p>";
} else {
    echo "<p>Estoque OK.</p>";
}

// Vários casos: if / elseif / else
$nota = 7.5;
if ($nota >= 9) {
    echo "Ótimo<br>";
} elseif ($nota >= 6) {
    echo "Aprovado<br>";
} else {
    echo "Reprovado<br>";
}

// Duas condições juntas
$idade = 20;
$tem_cnh = true;
if ($idade >= 18 && $tem_cnh) {
    echo "Pode dirigir<br>";
}

// Verificar se um texto está vazio (MUITO usado em validação)
$nome = "";
if ($nome == "") {
    echo "O nome é obrigatório!<br>";
}
// mesma coisa com empty():
if (empty($nome)) {
    echo "O nome é obrigatório! (com empty)<br>";
}
// CUIDADO: empty("0") e empty(0) também dão verdadeiro.
// Pra quantidade, prefira:  if ($qtd === "")  ou  if (!is_numeric($qtd))

// Verificar se é número
$valor = "abc";
if (!is_numeric($valor)) {
    echo "Digite um número válido!<br>";
}

// SWITCH: quando tem várias opções pra mesma variável
$tipo = "saida";
switch ($tipo) {
    case "entrada":
        echo "Vai somar no estoque<br>";
        break;   // break = para aqui (não esqueça!)
    case "saida":
        echo "Vai tirar do estoque<br>";
        break;
    default:
        echo "Tipo inválido<br>";
}

// IF CURTO (ternário):  condição ? se_sim : se_nao
$status = ($quantidade < $estoque_minimo) ? "BAIXO" : "OK";
echo "Status: $status<br>";

// ?? = "se não existir, usa este valor" (muito usado com $_POST)
$busca = $_GET['busca'] ?? '';
echo "Busca: '$busca'<br>";
?>
