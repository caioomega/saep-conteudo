<?php
// ==============================================================
// PRODUTO_CADASTRAR.PHP - inserir novo produto (com validação)
// ==============================================================
include "verifica_login.php";
include "conexao.php";
include "funcoes.php";

$erro = "";
// Valores iniciais do formulário
$p = ['nome' => '', 'descricao' => '', 'categoria' => '', 'marca' => '',
      'preco' => '0.00', 'quantidade' => '0', 'estoque_minimo' => '0'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pega tudo do formulário (trim tira espaços sobrando)
    foreach ($p as $campo => $valor) {
        $p[$campo] = trim($_POST[$campo] ?? '');
    }
    // Aceita preço com vírgula (10,50) trocando por ponto (10.50)
    $p['preco'] = str_replace(',', '.', $p['preco']);

    $erro = validarProduto($p['nome'], $p['preco'], $p['quantidade'], $p['estoque_minimo']);

    if ($erro == "") {
        $nome      = mysqli_real_escape_string($conexao, $p['nome']);
        $descricao = mysqli_real_escape_string($conexao, $p['descricao']);
        $categoria = mysqli_real_escape_string($conexao, $p['categoria']);
        $marca     = mysqli_real_escape_string($conexao, $p['marca']);
        $preco     = (float)$p['preco'];
        $qtd       = (int)$p['quantidade'];
        $minimo    = (int)$p['estoque_minimo'];

        $sql = "INSERT INTO produtos (nome, descricao, categoria, marca, preco, quantidade, estoque_minimo)
                VALUES ('$nome', '$descricao', '$categoria', '$marca', $preco, $qtd, $minimo)";

        if (mysqli_query($conexao, $sql)) {
            header("Location: produtos.php?msg=salvo");
            exit;
        }
        $erro = "Erro ao salvar: " . mysqli_error($conexao);
    }
}

$titulo = "Novo produto";
include "topo.php";
?>
    <h1>Novo produto</h1>

    <?php if ($erro != "") { ?>
        <div class="mensagem erro"><?php echo e($erro); ?></div>
    <?php } ?>

    <form method="post" action="">
        <label for="nome">Nome *</label>
        <input type="text" id="nome" name="nome" required maxlength="100" value="<?php echo e($p['nome']); ?>">

        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao"><?php echo e($p['descricao']); ?></textarea>

        <label for="categoria">Categoria</label>
        <input type="text" id="categoria" name="categoria" maxlength="50" value="<?php echo e($p['categoria']); ?>">

        <label for="marca">Marca</label>
        <input type="text" id="marca" name="marca" maxlength="50" value="<?php echo e($p['marca']); ?>">

        <label for="preco">Preço (R$) *</label>
        <input type="number" id="preco" name="preco" required min="0" step="0.01" value="<?php echo e($p['preco']); ?>">

        <label for="quantidade">Quantidade inicial *</label>
        <input type="number" id="quantidade" name="quantidade" required min="0" step="1" value="<?php echo e($p['quantidade']); ?>">

        <label for="estoque_minimo">Estoque mínimo (alerta abaixo disso) *</label>
        <input type="number" id="estoque_minimo" name="estoque_minimo" required min="0" step="1" value="<?php echo e($p['estoque_minimo']); ?>">

        <button type="submit">Salvar</button>
        <a class="botao botao-perigo" href="produtos.php">Cancelar</a>
    </form>
<?php include "rodape.php"; ?>
