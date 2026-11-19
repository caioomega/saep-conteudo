<?php
// ==============================================================
// INDEX.PHP - LISTAR (o "R" do CRUD) + BUSCAR
// Mostra todos os clientes numa tabela, com botões Editar/Excluir.
// ==============================================================
include "conexao.php";

// Pega o texto da busca (se a pessoa digitou algo). Vem pela URL (GET).
$busca = trim($_GET['busca'] ?? '');

// Monta o SQL. Se tiver busca, filtra com LIKE.
if ($busca != "") {
    // mysqli_real_escape_string protege contra "SQL Injection"
    // (alguém digitar comando SQL no campo pra estragar o banco)
    $busca_segura = mysqli_real_escape_string($conexao, $busca);
    $sql = "SELECT * FROM clientes
            WHERE nome LIKE '%$busca_segura%' OR cidade LIKE '%$busca_segura%'
            ORDER BY nome";
} else {
    $sql = "SELECT * FROM clientes ORDER BY nome";
}

// Executa o SQL no banco
$resultado = mysqli_query($conexao, $sql);

// Mensagem que vem de outra página (ex.: index.php?msg=salvo)
$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="topo">
        <strong>CRUD Simples</strong>
        <div><a href="index.php">Listar</a> <a href="cadastrar.php">Cadastrar</a></div>
    </div>

    <div class="conteudo">
        <h1>Clientes</h1>

        <!-- Mensagens de sucesso -->
        <?php if ($msg == "salvo") { ?>
            <div class="mensagem sucesso">Cliente cadastrado com sucesso!</div>
        <?php } elseif ($msg == "editado") { ?>
            <div class="mensagem sucesso">Cliente alterado com sucesso!</div>
        <?php } elseif ($msg == "excluido") { ?>
            <div class="mensagem sucesso">Cliente excluído com sucesso!</div>
        <?php } ?>

        <!-- Formulário de busca: method="get" pra busca aparecer na URL -->
        <form method="get" action="index.php" class="busca">
            <div style="flex:1">
                <label for="busca">Buscar por nome ou cidade</label>
                <input type="text" id="busca" name="busca" value="<?php echo htmlspecialchars($busca); ?>">
            </div>
            <button type="submit">Buscar</button>
            <a href="index.php" class="botao" style="margin-top:0">Limpar</a>
        </form>

        <a href="cadastrar.php" class="botao">+ Novo cliente</a>

        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Cidade</th>
                <th>Ações</th>
            </tr>

            <?php
            // Se não achou nenhum cliente
            if (mysqli_num_rows($resultado) == 0) {
                echo "<tr><td colspan='6'>Nenhum cliente encontrado.</td></tr>";
            }

            // Repete pra cada linha que o banco devolveu.
            // $cliente vira um array: $cliente['nome'], $cliente['email']...
            while ($cliente = mysqli_fetch_assoc($resultado)) {
            ?>
                <tr>
                    <td><?php echo $cliente['id']; ?></td>
                    <!-- htmlspecialchars: mostra o texto com segurança -->
                    <td><?php echo htmlspecialchars($cliente['nome']); ?></td>
                    <td><?php echo htmlspecialchars($cliente['email']); ?></td>
                    <td><?php echo htmlspecialchars($cliente['telefone']); ?></td>
                    <td><?php echo htmlspecialchars($cliente['cidade']); ?></td>
                    <td>
                        <!-- Manda o id pela URL pra página saber QUAL cliente -->
                        <a class="botao botao-pequeno" href="editar.php?id=<?php echo $cliente['id']; ?>">Editar</a>
                        <!-- onclick confirm: pergunta antes de excluir (JavaScript) -->
                        <a class="botao botao-pequeno botao-perigo"
                           href="excluir.php?id=<?php echo $cliente['id']; ?>"
                           onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
