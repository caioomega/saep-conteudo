-- ==============================================================
-- SCRIPT DO BANCO - SISTEMA DE CONTROLE DE ESTOQUE
-- Cria o banco, as 3 tabelas e coloca 3 registros em cada uma.
-- Rode no phpMyAdmin (aba SQL): Ctrl+A, Ctrl+C aqui, Ctrl+V lá, Executar.
--
-- Usuários pra testar (senha de todos: 123):
--   admin  |  maria  |  joao
-- ==============================================================

DROP DATABASE IF EXISTS saep_estoque;
CREATE DATABASE saep_estoque CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE saep_estoque;

-- --------------------------------------------------------------
-- USUÁRIOS: quem pode entrar no sistema
-- --------------------------------------------------------------
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    login VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL          -- senha criptografada (password_hash)
);

-- --------------------------------------------------------------
-- PRODUTOS: o que tem no estoque
-- --------------------------------------------------------------
CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    categoria VARCHAR(50),
    marca VARCHAR(50),
    preco DECIMAL(10,2) NOT NULL DEFAULT 0,
    quantidade INT NOT NULL DEFAULT 0,       -- quanto tem agora
    estoque_minimo INT NOT NULL DEFAULT 0    -- abaixo disso = ALERTA
);

-- --------------------------------------------------------------
-- MOVIMENTAÇÕES: histórico de entradas e saídas
-- (tabela "filha": tem as chaves estrangeiras)
-- --------------------------------------------------------------
CREATE TABLE movimentacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    usuario_id INT NOT NULL,
    tipo ENUM('entrada', 'saida') NOT NULL,
    quantidade INT NOT NULL,
    data_movimentacao DATE NOT NULL,
    observacao VARCHAR(255),
    -- ON DELETE CASCADE: se apagar o produto, apaga o histórico dele junto
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- --------------------------------------------------------------
-- DADOS INICIAIS (mínimo de 3 em cada tabela)
-- --------------------------------------------------------------
INSERT INTO usuarios (nome, login, senha) VALUES
('Administrador', 'admin', '$2y$10$T7hel8a59Zby.PSLFDplh.3R0.ovVkHGQWiDgJDd3dC5p/3eIbSnO'),
('Maria Silva',   'maria', '$2y$10$T7hel8a59Zby.PSLFDplh.3R0.ovVkHGQWiDgJDd3dC5p/3eIbSnO'),
('João Santos',   'joao',  '$2y$10$nWkmR8F1Lexm1YNxAkLh0.juBNslGdiXAUd4F8ok9OIxmK0bmIT6u');

INSERT INTO produtos (nome, descricao, categoria, marca, preco, quantidade, estoque_minimo) VALUES
('Martelo de Unha 16 oz', 'Cabo tubular, perfil reto', 'Ferramenta manual', 'Tramontina', 39.90, 8, 3),
('Furadeira de Impacto',  'Mandril 13 mm, 127 V',      'Ferramenta elétrica', 'Bosch',   289.00, 2, 3),
('Alicate Universal 8"',  'Isolado 1000 V',            'Ferramenta manual', 'Gedore',     54.50, 15, 5);

INSERT INTO movimentacoes (produto_id, usuario_id, tipo, quantidade, data_movimentacao, observacao) VALUES
(1, 1, 'entrada', 10, '2026-11-10', 'Compra do fornecedor'),
(1, 2, 'saida',    2, '2026-11-12', 'Venda balcão'),
(2, 3, 'saida',    1, '2026-11-14', 'Venda balcão');
