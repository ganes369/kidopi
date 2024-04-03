-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS kidope;

-- Use o banco de dados criado
USE kidope;

-- Criação da tabela acessos
CREATE TABLE IF NOT EXISTS acessos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_hora DATETIME NOT NULL,
    pais VARCHAR(255) NOT NULL
);
