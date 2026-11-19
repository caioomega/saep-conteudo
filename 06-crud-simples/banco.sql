-- ==============================================================
-- BANCO DO CRUD SIMPLES
-- Rode no phpMyAdmin (aba SQL) ANTES de abrir as páginas.
-- ==============================================================
DROP DATABASE IF EXISTS crud_simples;
CREATE DATABASE crud_simples CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE crud_simples;

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefone VARCHAR(20),
    cidade VARCHAR(60)
);

INSERT INTO clientes (nome, email, telefone, cidade) VALUES
('Ana Souza',    'ana@email.com',   '(11) 99999-1111', 'São Paulo'),
('Bruno Lima',   'bruno@email.com', '(11) 98888-2222', 'Campinas'),
('Carla Mendes', 'carla@email.com', '(19) 97777-3333', 'Sorocaba');
