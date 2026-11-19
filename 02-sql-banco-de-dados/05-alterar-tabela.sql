-- ==============================================================
-- 05 - MEXER NA ESTRUTURA DE UMA TABELA QUE JÁ EXISTE
-- (esqueceu uma coluna? não precisa apagar tudo!)
-- ==============================================================
USE escola_teste;

-- Adicionar coluna
ALTER TABLE alunos ADD telefone VARCHAR(20);

-- Mudar o tipo/tamanho de uma coluna
ALTER TABLE alunos MODIFY telefone VARCHAR(30);

-- Renomear coluna
ALTER TABLE alunos CHANGE telefone celular VARCHAR(30);

-- Remover coluna
ALTER TABLE alunos DROP COLUMN celular;

-- Adicionar chave estrangeira depois
-- ALTER TABLE alunos ADD FOREIGN KEY (curso_id) REFERENCES cursos(id);

-- Apagar TODOS os dados da tabela mas manter a tabela (zera o id também)
-- TRUNCATE TABLE alunos;

-- Apagar a tabela inteira
-- DROP TABLE alunos;

-- Apagar o banco inteiro
-- DROP DATABASE escola_teste;

DESCRIBE alunos;
