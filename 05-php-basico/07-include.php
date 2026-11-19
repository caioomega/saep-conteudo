<?php
// ==============================================================
// 07 - INCLUDE (reaproveitar arquivos)
// ==============================================================

// include "arquivo.php";  -> "cola" o conteúdo do outro arquivo aqui.
// Usado pra:
//   - conexao.php  (conectar no banco em todas as páginas)
//   - funcoes.php  (suas funções)
//   - topo.php     (o menu que aparece em todas as páginas)
//   - verifica_login.php (bloquear quem não fez login)
//
// include       -> se o arquivo não existir, dá aviso e continua
// require       -> se o arquivo não existir, PARA tudo (mais seguro
//                  pra conexão)
// include_once / require_once -> não inclui duas vezes o mesmo arquivo

include "parte-menu.php";
?>
<p>Este texto é da página 07-include.php. O menu acima veio do arquivo parte-menu.php.</p>
