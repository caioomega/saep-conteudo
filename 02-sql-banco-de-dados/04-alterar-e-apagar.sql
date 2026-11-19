-- ==============================================================
-- 04 - ALTERAR (UPDATE) e APAGAR (DELETE)
--      -> são o "U" (Update) e o "D" (Delete) do CRUD
-- ==============================================================
USE escola_teste;

-- !!! SEMPRE COLOQUE WHERE !!!
-- UPDATE alunos SET mensalidade = 0;   <- isso zera de TODO MUNDO

-- Alterar uma coluna de um aluno
UPDATE alunos SET mensalidade = 400.00 WHERE id = 1;

-- Alterar várias colunas de uma vez (separa com vírgula)
UPDATE alunos SET nome = 'Ana Souza Silva', email = 'ana.silva@email.com' WHERE id = 1;

-- Somar/subtrair do valor que já existe (MUITO usado em estoque!)
UPDATE alunos SET mensalidade = mensalidade + 50 WHERE id = 2;
UPDATE alunos SET mensalidade = mensalidade - 10 WHERE id = 2;

SELECT * FROM alunos;

-- Apagar um aluno
DELETE FROM alunos WHERE id = 4;

-- Tentar apagar um curso que tem alunos DÁ ERRO por causa da chave
-- estrangeira (o banco te protege de deixar aluno "órfão"):
-- DELETE FROM cursos WHERE id = 1;   -> erro 1451
-- Soluções: apagar os alunos dele antes, ou criar a FK com
-- ON DELETE CASCADE (aí apaga os alunos junto automaticamente):
--   FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE CASCADE

SELECT * FROM alunos;
