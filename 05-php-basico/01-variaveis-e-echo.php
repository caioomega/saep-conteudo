<?php
// ==============================================================
// 01 - VARIÁVEIS E ECHO
// Copie a pasta 05-php-basico pra C:\xampp\htdocs\ e abra:
// localhost/05-php-basico/01-variaveis-e-echo.php
// ==============================================================

// Todo código PHP fica entre a abertura "<?php" e o fechamento
// (interrogação + maior que). CUIDADO: se você escrever esse fechamento
// dentro de um comentário com //, o PHP fecha ali mesmo e quebra tudo!
// Toda linha de comando termina com ; (ponto e vírgula)
// Variável SEMPRE começa com $

$nome = "Maria";        // texto (string) vai entre aspas
$idade = 17;            // número inteiro (int)
$altura = 1.65;         // número com vírgula (float) usa PONTO
$aprovado = true;       // verdadeiro/falso (boolean)

// echo = escrever na tela (vira HTML)
echo "Olá, mundo!<br>";
echo "Nome: " . $nome . "<br>";   // o PONTO junta textos
echo "Idade: $idade<br>";         // com aspas DUPLAS a variável aparece dentro
echo 'Idade: $idade<br>';         // com aspas SIMPLES NÃO funciona (mostra $idade)

// Contas
$a = 10;
$b = 3;
echo "Soma: " . ($a + $b) . "<br>";
echo "Subtração: " . ($a - $b) . "<br>";
echo "Multiplicação: " . ($a * $b) . "<br>";
echo "Divisão: " . ($a / $b) . "<br>";
echo "Resto da divisão: " . ($a % $b) . "<br>";

// Atalhos
$a = $a + 1;   // é igual a:  $a++;
$a += 5;       // soma 5 no que já tinha

// Formatar dinheiro no padrão brasileiro: 1.234,50
$preco = 1234.5;
echo "Preço: R$ " . number_format($preco, 2, ',', '.') . "<br>";

// Data de hoje
echo "Hoje é " . date('d/m/Y') . " e agora são " . date('H:i') . "<br>";
// Converter data do banco (2026-11-17) pra brasileira (17/11/2026):
echo date('d/m/Y', strtotime('2026-11-17')) . "<br>";

// Funções de texto úteis
echo strtoupper("martelo") . "<br>";   // MARTELO
echo strtolower("MARTELO") . "<br>";   // martelo
echo strlen("martelo") . "<br>";       // 7 (quantidade de letras)
echo trim("   espaço   ") . "<br>";    // tira espaços do começo e fim

// Mostrar o conteúdo de uma variável pra DEBUGAR (descobrir erro)
var_dump($altura);
echo "<br>";
?>

<!-- Dá pra misturar HTML e PHP no mesmo arquivo: -->
<h1>Bem-vinda, <?php echo $nome; ?>!</h1>
<!-- forma curta do echo: -->
<p>Você tem <?= $idade ?> anos.</p>
