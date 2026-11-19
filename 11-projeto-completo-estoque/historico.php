<?php
// ==============================================================
// HISTORICO.PHP - todas as entradas e saídas (usa JOIN)
// Junta 3 tabelas pra mostrar o NOME do produto e do usuário.
// ==============================================================
include "verifica_login.php";
include "conexao.php";
include "funcoes.php";

// Filtro opcional por tipo (todos / entrada / saida)
$filtro = $_GET['tipo'] ?? '';
$where = "";
if ($filtro == "entrada" || $filtro == "saida") {
    $where = "WHERE m.tipo = '$filtro'";
}

$sql = "SELECT m.*, p.nome AS produto, u.nome AS usuario
        FROM movimentacoes m
        INNER JOIN produtos p ON m.produto_id = p.id
        INNER JOIN usuarios u ON m.usuario_id = u.id
        $where
        ORDER BY m.data_movimentacao DESC, m.id DESC";
$movs = mysqli_query($conexao, $sql);

$titulo = "Histórico";
include "topo.php";
?>
    <h1>Histórico de movimentações</h1>

    <p>
        Filtrar:
        <a href="historico.php">Todas</a> |
        <a href="historico.php?tipo=entrada">Só entradas</a> |
        <a href="historico.php?tipo=saida">Só saídas</a>
    </p>

    <table>
        <tr>
            <th>Data</th>
            <th>Produto</th>
            <th>Tipo</th>
            <th>Quantidade</th>
            <th>Responsável</th>
            <th>Observação</th>
        </tr>
        <?php if (mysqli_num_rows($movs) == 0) { ?>
            <tr><td colspan="6">Nenhuma movimentação.</td></tr>
        <?php } ?>
        <?php while ($m = mysqli_fetch_assoc($movs)) { ?>
            <tr>
                <td><?php echo data_br($m['data_movimentacao']); ?></td>
                <td><?php echo e($m['produto']); ?></td>
                <td><?php echo $m['tipo'] == 'entrada' ? 'Entrada' : 'Saída'; ?></td>
                <td><?php echo $m['quantidade']; ?></td>
                <td><?php echo e($m['usuario']); ?></td>
                <td><?php echo e($m['observacao']); ?></td>
            </tr>
        <?php } ?>
    </table>
<?php include "rodape.php"; ?>
