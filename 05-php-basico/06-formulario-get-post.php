<?php
// ==============================================================
// 06 - RECEBER DADOS DE UM FORMULÁRIO
// Esta página envia o formulário PARA ELA MESMA (action="").
// Abra: localhost/05-php-basico/06-formulario-get-post.php
// ==============================================================

// $_POST = dados de formulário com method="post"
// $_GET  = dados que vêm na URL: pagina.php?busca=martelo&id=3
// O nome dentro dos [ ] é o "name" do campo no HTML.

$mensagem = "";
$nome = "";
$quantidade = "";

// Só processa se o formulário FOI ENVIADO (clicou no botão)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // trim tira espaços sobrando. ?? '' evita erro se o campo não vier.
    $nome = trim($_POST['nome'] ?? '');
    $quantidade = trim($_POST['quantidade'] ?? '');

    // VALIDAÇÃO NO PHP (a prova gosta disso!)
    if ($nome == "") {
        $mensagem = "<p style='color:red'>Preencha o nome.</p>";
    } elseif (!is_numeric($quantidade) || $quantidade < 0) {
        $mensagem = "<p style='color:red'>A quantidade tem que ser um número maior ou igual a zero.</p>";
    } else {
        // Aqui você salvaria no banco (veja a pasta 06-crud-simples)
        // htmlspecialchars evita que alguém coloque código HTML/JS no campo
        $mensagem = "<p style='color:green'>Recebido: " . htmlspecialchars($nome) . " - quantidade $quantidade</p>";
    }
}

// Exemplo de GET: abra a página com ?cor=azul no final do endereço
$cor = $_GET['cor'] ?? 'nenhuma';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Formulário</title></head>
<body>
    <h1>Formulário de teste</h1>

    <?php echo $mensagem; ?>

    <form method="post" action="">
        <label>Nome:</label><br>
        <!-- value=... mantém o que a pessoa digitou se der erro -->
        <input type="text" name="nome" value="<?php echo htmlspecialchars($nome); ?>"><br><br>

        <label>Quantidade:</label><br>
        <input type="number" name="quantidade" value="<?php echo htmlspecialchars($quantidade); ?>"><br><br>

        <button type="submit">Enviar</button>
    </form>

    <hr>
    <p>Cor recebida pelo GET: <?php echo htmlspecialchars($cor); ?></p>
    <p><a href="?cor=azul">Clique aqui pra mandar cor=azul pela URL</a></p>
</body>
</html>
