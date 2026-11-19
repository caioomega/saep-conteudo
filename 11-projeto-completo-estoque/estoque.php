<?php
// ==============================================================
// ESTOQUE.PHP - GESTÃO DE ESTOQUE
//  - Lista os produtos em ordem alfabética usando o BUBBLE SORT
//    (função bubbleSortPorCampo no funcoes.php)
//  - Registra ENTRADA ou SAÍDA com data
//  - Avisa (alerta) quando o estoque fica abaixo do mínimo
// ==============================================================
include "verifica_login.php";
include "conexao.php";
include "funcoes.php";

$erro = "";
$sucesso = "";
$alerta = "";   // mensagem de estoque baixo

// Valores do formulário (data já vem com hoje)
$produto_id = (int)($_GET['produto'] ?? 0);  // dá pra pré-selecionar pela URL
$tipo = "entrada";
$quantidade = "";
$data = date('Y-m-d');
$observacao = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $produto_id = (int)($_POST['produto_id'] ?? 0);
    $tipo       = $_POST['tipo'] ?? '';
    $quantidade = trim($_POST['quantidade'] ?? '');
    $data       = trim($_POST['data'] ?? '');
    $observacao = trim($_POST['observacao'] ?? '');

    // Busca o produto escolhido
    $res = mysqli_query($conexao, "SELECT * FROM produtos WHERE id = $produto_id");
    $produto = mysqli_fetch_assoc($res);

    // ---------- VALIDAÇÕES ----------
    if (!$produto) {
        $erro = "Selecione um produto.";
    } elseif ($tipo != "entrada" && $tipo != "saida") {
        $erro = "Escolha se é entrada ou saída.";
    } elseif (!ctype_digit($quantidade) || (int)$quantidade <= 0) {
        $erro = "A quantidade tem que ser um número inteiro maior que zero.";
    } elseif ($data == "" || !strtotime($data)) {
        $erro = "Informe a data da movimentação.";
    } elseif ($tipo == "saida" && (int)$quantidade > $produto['quantidade']) {
        $erro = "Não há estoque suficiente. Disponível: " . $produto['quantidade'] . ".";
    }

    // ---------- SALVAR ----------
    if ($erro == "") {
        $qtd = (int)$quantidade;

        // Calcula a nova quantidade
        if ($tipo == "entrada") {
            $nova_quantidade = $produto['quantidade'] + $qtd;
        } else {
            $nova_quantidade = $produto['quantidade'] - $qtd;
        }

        $usuario_id = (int)$_SESSION['usuario_id'];   // quem fez a movimentação
        $d   = mysqli_real_escape_string($conexao, $data);
        $obs = mysqli_real_escape_string($conexao, $observacao);

        // 1) Grava no histórico
        $sql1 = "INSERT INTO movimentacoes (produto_id, usuario_id, tipo, quantidade, data_movimentacao, observacao)
                 VALUES ($produto_id, $usuario_id, '$tipo', $qtd, '$d', '$obs')";
        // 2) Atualiza a quantidade do produto
        $sql2 = "UPDATE produtos SET quantidade = $nova_quantidade WHERE id = $produto_id";

        if (mysqli_query($conexao, $sql1) && mysqli_query($conexao, $sql2)) {
            $sucesso = ($tipo == "entrada" ? "Entrada" : "Saída") . " de $qtd unidade(s) de "
                     . $produto['nome'] . " registrada. Estoque atual: $nova_quantidade.";

            // ---------- ALERTA DE ESTOQUE MÍNIMO ----------
            if ($nova_quantidade < $produto['estoque_minimo']) {
                $alerta = "ATENÇÃO: o produto " . $produto['nome'] . " ficou com $nova_quantidade unidade(s), "
                        . "abaixo do estoque mínimo de " . $produto['estoque_minimo'] . "!";
            }

            // Limpa o formulário pra próxima movimentação
            $quantidade = "";
            $observacao = "";
        } else {
            $erro = "Erro ao registrar: " . mysqli_error($conexao);
        }
    }
}

// Lista ordenada com o algoritmo (depois de salvar, pra já mostrar atualizada)
$produtos = produtosOrdenados($conexao);

$titulo = "Gestão de Estoque";
include "topo.php";
?>
    <h1>Gestão de Estoque</h1>

    <?php if ($erro != "") { ?>
        <div class="mensagem erro"><?php echo e($erro); ?></div>
    <?php } ?>
    <?php if ($sucesso != "") { ?>
        <div class="mensagem sucesso"><?php echo e($sucesso); ?></div>
    <?php } ?>
    <?php if ($alerta != "") { ?>
        <div class="mensagem aviso"><strong><?php echo e($alerta); ?></strong></div>
        <!-- Alerta em janelinha também (JavaScript). json_encode deixa o texto seguro pro JS. -->
        <script>alert(<?php echo json_encode($alerta); ?>);</script>
    <?php } ?>

    <h2>Registrar movimentação</h2>
    <form method="post" action="estoque.php">
        <label for="produto_id">Produto *</label>
        <select id="produto_id" name="produto_id" required>
            <option value="">-- selecione --</option>
            <?php foreach ($produtos as $p) { ?>
                <option value="<?php echo $p['id']; ?>" <?php echo $p['id'] == $produto_id ? 'selected' : ''; ?>>
                    <?php echo e($p['nome']); ?> (estoque: <?php echo $p['quantidade']; ?>)
                </option>
            <?php } ?>
        </select>

        <label>Tipo *</label>
        <label style="display:inline; font-weight:normal">
            <input type="radio" name="tipo" value="entrada" style="width:auto" <?php echo $tipo != 'saida' ? 'checked' : ''; ?>> Entrada
        </label>
        &nbsp;&nbsp;
        <label style="display:inline; font-weight:normal">
            <input type="radio" name="tipo" value="saida" style="width:auto" <?php echo $tipo == 'saida' ? 'checked' : ''; ?>> Saída
        </label>

        <label for="quantidade">Quantidade *</label>
        <input type="number" id="quantidade" name="quantidade" required min="1" step="1" value="<?php echo e($quantidade); ?>">

        <label for="data">Data da movimentação *</label>
        <input type="date" id="data" name="data" required value="<?php echo e($data); ?>">

        <label for="observacao">Observação</label>
        <input type="text" id="observacao" name="observacao" maxlength="255" value="<?php echo e($observacao); ?>">

        <button type="submit">Registrar</button>
    </form>

    <h2>Produtos (ordem alfabética — Bubble Sort)</h2>
    <table>
        <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Estoque mínimo</th>
            <th>Situação</th>
            <th></th>
        </tr>
        <?php foreach ($produtos as $p) {
            $baixo = $p['quantidade'] < $p['estoque_minimo']; ?>
            <tr class="<?php echo $baixo ? 'linha-alerta' : ''; ?>">
                <td><?php echo e($p['nome']); ?></td>
                <td><?php echo $p['quantidade']; ?></td>
                <td><?php echo $p['estoque_minimo']; ?></td>
                <td><?php echo $baixo ? '<strong style="color:#c0392b">ABAIXO DO MÍNIMO</strong>' : 'OK'; ?></td>
                <td><a class="botao botao-pequeno" href="estoque.php?produto=<?php echo $p['id']; ?>">Movimentar</a></td>
            </tr>
        <?php } ?>
    </table>
<?php include "rodape.php"; ?>
