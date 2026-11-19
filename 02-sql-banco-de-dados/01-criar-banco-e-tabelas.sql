-- ==============================================================
-- 01 - CRIAR BANCO E TABELAS
-- Tudo que começa com -- é COMENTÁRIO (o banco ignora).
-- Rode este arquivo inteiro no phpMyAdmin, aba "SQL".
-- ==============================================================

-- Apaga o banco se ele já existir (pra você poder rodar de novo
-- quantas vezes quiser sem dar erro). CUIDADO: apaga os dados!
DROP DATABASE IF EXISTS escola_teste;

-- Cria o banco. O "CHARACTER SET utf8mb4" faz os acentos
-- (ç, ã, é) funcionarem direitinho.
CREATE DATABASE escola_teste CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Diz: "a partir de agora, use este banco".
USE escola_teste;

-- --------------------------------------------------------------
-- Tabela "cursos" (tabela PAI - é criada primeiro)
-- --------------------------------------------------------------
CREATE TABLE cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,   -- número único, preenchido sozinho
    nome VARCHAR(100) NOT NULL,          -- texto até 100 letras, obrigatório
    carga_horaria INT NOT NULL           -- número inteiro, obrigatório
);

-- --------------------------------------------------------------
-- Tabela "alunos" (tabela FILHA - aponta para cursos)
-- --------------------------------------------------------------
CREATE TABLE alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,  -- UNIQUE = não pode repetir
    data_nascimento DATE,                -- formato '2008-05-20'
    mensalidade DECIMAL(10,2) DEFAULT 0, -- dinheiro: 350.00
    ativo BOOLEAN DEFAULT TRUE,          -- verdadeiro/falso
    curso_id INT NOT NULL,               -- vai guardar o id de um curso
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- data/hora automática

    -- Liga alunos.curso_id com cursos.id
    -- (um aluno pertence a UM curso; um curso tem VÁRIOS alunos)
    FOREIGN KEY (curso_id) REFERENCES cursos(id)
);

-- Para ver se deu certo:
SHOW TABLES;
DESCRIBE alunos;
