CREATE DATABASE IF NOT EXISTS oficina_roda_viva;
USE oficina_roda_viva;

CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    senha VARCHAR(255)
);

CREATE TABLE cliente (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    telefone VARCHAR(20),
    email VARCHAR(100)
);

CREATE TABLE mecanico (
    id_mecanico INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    matricula VARCHAR(20) UNIQUE,
    especialidade VARCHAR(60)
);

CREATE TABLE agendamento (
    id_agendamento INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT,
    id_mecanico INT,
    data_hora DATETIME,
    placa VARCHAR(8),
    FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente),
    FOREIGN KEY (id_mecanico) REFERENCES mecanico(id_mecanico)
);

-- Senha de todos os usuários abaixo é: password
INSERT INTO usuario (nome, email, senha) VALUES 
('Atendente Ana', 'ana@oficina.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Atendente Bruno', 'bruno@oficina.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Gerente Carlos', 'carlos@oficina.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT INTO cliente (nome, telefone, email) VALUES 
('João Silva', '47999991111', 'joao@email.com'),
('Maria Oliveira', '47999992222', 'maria@email.com'),
('Pedro Santos', '47999993333', 'pedro@email.com');

INSERT INTO mecanico (nome, matricula, especialidade) VALUES 
('Carlos Souza', 'MEC001', 'Motor'),
('Roberto Lima', 'MEC002', 'Freios'),
('Marcos Dias', 'MEC003', 'Parte Elétrica');

INSERT INTO agendamento (id_cliente, id_mecanico, data_hora, placa) VALUES 
(1, 1, '2026-11-25 09:00:00', 'ABC1234'),
(2, 2, '2026-11-25 10:30:00', 'DEF5678'),
(3, 3, '2026-11-26 14:00:00', 'GHI9012');