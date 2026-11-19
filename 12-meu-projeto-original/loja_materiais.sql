CREATE DATABASE IF NOT EXISTS loja_materiais CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE loja_materiais;

CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    marca VARCHAR(100) NOT NULL,
    modelo VARCHAR(100) NOT NULL,
    categoria VARCHAR(80) NOT NULL,
    material VARCHAR(100) DEFAULT '',
    tamanho VARCHAR(80) DEFAULT '',
    peso VARCHAR(50) DEFAULT '',
    tensao VARCHAR(50) DEFAULT '',
    caracteristicas TEXT,
    estoque INT NOT NULL DEFAULT 0,
    estoque_minimo INT NOT NULL DEFAULT 0,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE movimentacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    tipo ENUM('entrada', 'saida') NOT NULL,
    quantidade INT NOT NULL,
    observacao VARCHAR(255) DEFAULT '',
    data_movimentacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
);

INSERT INTO produtos (nome, marca, modelo, categoria, material, tamanho, peso, tensao, caracteristicas, estoque, estoque_minimo) VALUES
('Martelo de Unha 16 oz', 'MASTER', 'Perfil Reto', 'Martelo', 'Cabo tubular', '16 oz', '450 g', '', 'Cabo tubular e perfil reto.', 8, 3),
('Furadeira de Impacto', 'Bosch', 'GSB 13 RE', 'Furadeira', 'Plástico e metal', '', '1,7 kg', '127 V', 'Mandril de 13 mm e função impacto.', 2, 3);
