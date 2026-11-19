<?php
// ==============================================================
// PRODUTO_EDITAR.PHP - alterar um produto (com validação)
// Abre com produto_editar.php?id=1
// ==============================================================
include "verifica_login.php";
include "conexao.php";
include "funcoes.php";

$erro = "";
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

// Busca o produto no banco pra preencher o formulário
$resultado = mysqli_query($conexao, "SELECT * FROM produtos WHERE id = $id");
$p = mysqli_fetch_assoc($resultado);
if (!$p) {
    header("Location: produtos.php");  // id não existe
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach (['nome', 'descricao', 'categoria', 'marca', 'preco', 'quantidade', 'estoque_minimo'] as $campo) {
        $p[$campo] = trim($_POST[$campo] ?? '');
    }
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

        $sql = "UPDATE produtos SET
                    nome = '$nome', descricao = '$descricao', categoria = '$categoria',
                    marca = '$marca', preco = $preco, quantidade = $qtd,
                    estoque_minimo = $minimo
                WHERE id = $id";

        if (mysqli_query($conexao, $sql)) {
            header("Location: produtos.php?msg=editado");
            exit;
        }
        $erro = "Erro ao alterar: " . mysqli_error($conexao);
    }
}

$titulo = "Editar produto";
include "topo.php";
?>
    <h1>Editar produto</h1>

    <?php if ($erro != "") { ?>
        <div class="mensagem erro"><?php echo e($erro); ?></div>
    <?php } ?>

    <form method="post" action="produto_editar.php">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

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

        <label for="quantidade">Quantidade *</label>
        <input type="number" id="quantidade" name="quantidade" required min="0" step="1" value="<?php echo e($p['quantidade']); ?>">

        <label for="estoque_minimo">Estoque mínimo *</label>
        <input type="number" id="estoque_minimo" name="estoque_minimo" required min="0" step="1" value="<?php echo e($p['estoque_minimo']); ?>">

        <button type="submit">Salvar alteração</button>
        <a class="botao botao-perigo" href="produtos.php">Cancelar</a>
    </form>
<?php include "rodape.php"; ?>
