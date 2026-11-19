<?php
// ==============================================================
// PRINCIPAL.PHP - tela inicial depois do login
// Mostra o nome do usuário, os menus e um resumo com alertas.
// ==============================================================
include "verifica_login.php";
include "conexao.php";
include "funcoes.php";

// Produtos com estoque abaixo do mínimo (pra mostrar o alerta logo de cara)
$baixos = mysqli_query($conexao, "SELECT * FROM produtos WHERE quantidade < estoque_minimo");

$titulo = "Início";
include "topo.php";
?>
    <h1>Bem-vindo(a), <?php echo e($_SESSION['usuario_nome']); ?>!</h1>
    <p>Escolha uma opção:</p>

    <p>
        <a class="botao" href="produtos.php">Cadastro de Produtos</a>
        <a class="botao" href="estoque.php">Gestão de Estoque</a>
        <a class="botao" href="historico.php">Histórico de Movimentações</a>
    </p>

    <?php if (mysqli_num_rows($baixos) > 0) { ?>
        <div class="mensagem aviso">
            <strong>Atenção! Produtos abaixo do estoque mínimo:</strong>
            <ul>
                <?php while ($p = mysqli_fetch_assoc($baixos)) { ?>
                    <li><?php echo e($p['nome']); ?> — tem <?php echo $p['quantidade']; ?>, mínimo <?php echo $p['estoque_minimo']; ?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
<?php include "rodape.php"; ?>
