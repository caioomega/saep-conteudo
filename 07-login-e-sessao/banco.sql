-- ==============================================================
-- BANCO DO EXEMPLO DE LOGIN
-- Usuários de teste (a senha de TODOS é: 123)
--   login: admin   senha: 123
--   login: maria   senha: 123
--   login: joao    senha: 123
-- ==============================================================
DROP DATABASE IF EXISTS login_teste;
CREATE DATABASE login_teste CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE login_teste;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    login VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL   -- 255 porque a senha criptografada é grande
);

-- A senha NÃO é guardada como "123". É guardada CRIPTOGRAFADA (hash).
-- Esse texto esquisito abaixo é o "123" criptografado com password_hash().
-- Pra gerar o hash de outra senha, use o arquivo gerar-hash.php.
INSERT INTO usuarios (nome, login, senha) VALUES
('Administrador', 'admin', '$2y$10$T7hel8a59Zby.PSLFDplh.3R0.ovVkHGQWiDgJDd3dC5p/3eIbSnO'),
('Maria Silva',   'maria', '$2y$10$T7hel8a59Zby.PSLFDplh.3R0.ovVkHGQWiDgJDd3dC5p/3eIbSnO'),
('João Santos',   'joao',  '$2y$10$nWkmR8F1Lexm1YNxAkLh0.juBNslGdiXAUd4F8ok9OIxmK0bmIT6u');
