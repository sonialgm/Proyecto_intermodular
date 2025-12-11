-- Crear base de datos
CREATE DATABASE IF NOT EXISTS proyecto3;
USE proyecto3;

-- Crear tabla de usuarios/conversaciones
CREATE TABLE IF NOT EXISTS login (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR (50),
    password VARCHAR (255)
);

-- Insertar datos de ejemplo
INSERT INTO login (username,password) VALUES
('prueba','12345');


-- Tabla de administradores
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

