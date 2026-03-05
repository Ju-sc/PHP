-- ============================================
-- AULA 2 — Criação do Banco de Dados e Tabela
-- ============================================

-- Criar o banco de dados do projeto
CREATE DATABASE IF NOT EXISTS projeto
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

-- Selecionar o banco
USE projeto;

-- Criar a tabela de usuários
CREATE TABLE IF NOT EXISTS usuario (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  nome       VARCHAR(100) NOT NULL,
  email      VARCHAR(100) NOT NULL UNIQUE,
  senha      VARCHAR(255) NOT NULL,
  criado_em  DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Inserir um usuário de teste
-- Senha: 123456 (criptografada com password_hash)
INSERT INTO usuario (nome, email, senha) VALUES (
  'Administrador',
  'admin@email.com',
  '$2y$10$Wiyq0IuO9JEW2K5rakVjDu/SUE/ZCkdiw0dWs.4ZNKy7U/hrLvFxa'
);
