<?php
// ==============================================================
// TOPO.PHP - o começo do HTML + o menu, igual em todas as páginas.
// Antes de incluir, defina o título:  $titulo = "Produtos";
// ==============================================================
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($titulo ?? 'Controle de Estoque'); ?></title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="topo">
        <!-- Nome de quem está logado (requisito comum da prova) -->
        <span>Controle de Estoque | Usuário: <strong><?php echo e($_SESSION['usuario_nome']); ?></strong></span>
        <nav>
            <a href="principal.php">Início</a>
            <a href="produtos.php">Produtos</a>
            <a href="estoque.php">Gestão de Estoque</a>
            <a href="historico.php">Histórico</a>
            <a href="logout.php">Sair</a>
        </nav>
    </div>
    <div class="conteudo">
