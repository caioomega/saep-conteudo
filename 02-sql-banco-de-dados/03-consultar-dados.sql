-- ==============================================================
-- 03 - CONSULTAR DADOS (SELECT)  -> é o "R" (Read) do CRUD
-- Rode uma consulta por vez pra ver o resultado de cada uma
-- (selecione só a linha e execute, ou rode tudo e role a tela).
-- ==============================================================
USE escola_teste;

-- Tudo (* = todas as colunas)
SELECT * FROM alunos;

-- Só algumas colunas
SELECT nome, email FROM alunos;

-- Filtrar com WHERE
SELECT * FROM alunos WHERE id = 2;
SELECT * FROM alunos WHERE mensalidade > 300;
SELECT * FROM alunos WHERE curso_id = 1 AND mensalidade >= 350;
SELECT * FROM alunos WHERE curso_id = 2 OR curso_id = 3;

-- BUSCAR POR PARTE DO TEXTO (usado em campo de "pesquisar")
-- % significa "qualquer coisa". '%an%' = tem "an" em qualquer lugar.
SELECT * FROM alunos WHERE nome LIKE '%an%';
SELECT * FROM alunos WHERE nome LIKE 'B%';   -- começa com B

-- ORDENAR
SELECT * FROM alunos ORDER BY nome ASC;      -- A -> Z
SELECT * FROM alunos ORDER BY nome DESC;     -- Z -> A
SELECT * FROM alunos ORDER BY mensalidade DESC, nome ASC;

-- LIMITAR quantidade
SELECT * FROM alunos ORDER BY id DESC LIMIT 2;  -- os 2 últimos

-- CONTAR, SOMAR, MÉDIA, MAIOR, MENOR
SELECT COUNT(*) AS total_alunos FROM alunos;
SELECT SUM(mensalidade) AS soma FROM alunos;
SELECT AVG(mensalidade) AS media FROM alunos;
SELECT MAX(mensalidade) AS maior, MIN(mensalidade) AS menor FROM alunos;

-- AGRUPAR (quantos alunos em cada curso)
SELECT curso_id, COUNT(*) AS quantidade FROM alunos GROUP BY curso_id;

-- ==============================================================
-- JOIN: juntar duas tabelas
-- Mostra o nome do aluno E o nome do curso dele (que está na
-- outra tabela). "a" e "c" são apelidos pra escrever menos.
-- ==============================================================
SELECT a.nome AS aluno, c.nome AS curso
FROM alunos a
INNER JOIN cursos c ON a.curso_id = c.id
ORDER BY a.nome;

-- Mesma coisa, sem apelido (mais fácil de entender no começo):
SELECT alunos.nome, cursos.nome
FROM alunos
INNER JOIN cursos ON alunos.curso_id = cursos.id;

-- LEFT JOIN: mostra TODOS os cursos, mesmo os que não têm aluno
SELECT cursos.nome, COUNT(alunos.id) AS qtd_alunos
FROM cursos
LEFT JOIN alunos ON alunos.curso_id = cursos.id
GROUP BY cursos.id, cursos.nome;

-- DATAS
SELECT nome, DATE_FORMAT(data_nascimento, '%d/%m/%Y') AS nascimento FROM alunos;
SELECT * FROM alunos WHERE data_nascimento >= '2008-01-01';
SELECT CURDATE();  -- data de hoje
SELECT NOW();      -- data e hora de agora
