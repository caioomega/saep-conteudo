<?php
// ==============================================================
// PRODUTOS.PHP - CADASTRO DE PRODUTOS (listagem + busca)
// Daqui a pessoa vai pra: cadastrar, editar, excluir.
// ==============================================================
include "verifica_login.php";
include "conexao.php";
include "funcoes.php";

$busca = trim($_GET['busca'] ?? '');

if ($busca != "") {
    $b = mysqli_real_escape_string($conexao, $busca);
    $sql = "SELECT * FROM produtos
            WHERE nome LIKE '%$b%' OR categoria LIKE '%$b%' OR marca LIKE '%$b%'
            ORDER BY nome";
} else {
    $sql = "SELECT * FROM produtos ORDER BY nome";
}
$produtos = mysqli_query($conexao, $sql);

$msg = $_GET['msg'] ?? '';

$titulo = "Produtos";
include "topo.php";
?>
    <h1>Cadastro de Produtos</h1>

    <?php if ($msg == "salvo") { ?>
        <div class="mensagem sucesso">Produto cadastrado com sucesso!</div>
    <?php } elseif ($msg == "editado") { ?>
        <div class="mensagem sucesso">Produto alterado com sucesso!</div>
    <?php } elseif ($msg == "excluido") { ?>
        <div class="mensagem sucesso">Produto excluído com sucesso!</div>
    <?php } ?>

    <!-- BUSCA -->
    <form method="get" action="produtos.php" class="busca">
        <div style="flex:1">
            <label for="busca">Buscar (nome, categoria ou marca)</label>
            <input type="text" id="busca" name="busca" value="<?php echo e($busca); ?>">
        </div>
        <button type="submit">Buscar</button>
        <a class="botao" href="produtos.php" style="margin-top:0">Limpar</a>
    </form>

    <a class="botao" href="produto_cadastrar.php">+ Novo produto</a>

    <table>
        <tr>
            <th>Nome</th>
            <th>Categoria</th>
            <th>Marca</th>
            <th>Preço</th>
            <th>Qtd.</th>
            <th>Mínimo</th>
            <th>Ações</th>
        </tr>
        <?php if (mysqli_num_rows($produtos) == 0) { ?>
            <tr><td colspan="7">Nenhum produto encontrado.</td></tr>
        <?php } ?>

        <?php while ($p = mysqli_fetch_assoc($produtos)) {
            $baixo = $p['quantidade'] < $p['estoque_minimo']; ?>
            <tr class="<?php echo $baixo ? 'linha-alerta' : ''; ?>">
                <td><?php echo e($p['nome']); ?></td>
                <td><?php echo e($p['categoria']); ?></td>
                <td><?php echo e($p['marca']); ?></td>
                <td><?php echo dinheiro($p['preco']); ?></td>
                <td><?php echo $p['quantidade']; ?><?php echo $baixo ? ' ⚠' : ''; ?></td>
                <td><?php echo $p['estoque_minimo']; ?></td>
                <td>
                    <a class="botao botao-pequeno" href="produto_editar.php?id=<?php echo $p['id']; ?>">Editar</a>
                    <a class="botao botao-pequeno botao-perigo"
                       href="produto_excluir.php?id=<?php echo $p['id']; ?>"
                       onclick="return confirm('Tem certeza que deseja excluir este produto? O histórico dele também será apagado.');">Excluir</a>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php include "rodape.php"; ?>
