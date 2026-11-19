-- ==============================================================
-- 02 - INSERIR DADOS (INSERT)  -> é o "C" (Create) do CRUD
-- Rode DEPOIS do 01.
-- ==============================================================
USE escola_teste;

-- Forma: INSERT INTO tabela (coluna1, coluna2) VALUES (valor1, valor2);
-- Não precisa mandar o id: o AUTO_INCREMENT preenche sozinho.
-- Texto e data vão entre 'aspas simples'. Número vai sem aspas.

INSERT INTO cursos (nome, carga_horaria) VALUES ('Desenvolvimento de Sistemas', 1200);

-- Pode inserir várias linhas de uma vez, separando por vírgula:
INSERT INTO cursos (nome, carga_horaria) VALUES
('Redes de Computadores', 1000),
('Eletrotécnica', 1200);

-- Agora os alunos. O curso_id tem que ser um id que EXISTE em cursos
-- (1, 2 ou 3), senão dá erro de chave estrangeira.
INSERT INTO alunos (nome, email, data_nascimento, mensalidade, curso_id) VALUES
('Ana Souza',     'ana@email.com',    '2008-03-15', 350.00, 1),
('Bruno Lima',    'bruno@email.com',  '2007-11-02', 350.00, 1),
('Carla Mendes',  'carla@email.com',  '2008-07-21', 300.00, 2),
('Diego Alves',   'diego@email.com',  '2006-01-30', 280.50, 3);

-- A prova costuma pedir "no mínimo 3 registros em cada tabela".
-- Aqui tem 3 cursos e 4 alunos. :)

SELECT * FROM cursos;
SELECT * FROM alunos;
