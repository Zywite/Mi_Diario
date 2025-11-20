-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS mi_diario_lectura
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE mi_diario_lectura;

-- Crear la tabla de usuarios
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(32) NOT NULL, -- MD5 genera un hash de 32 caracteres
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Crear la tabla de libros
CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    autor VARCHAR(255) NOT NULL,
    genero VARCHAR(100) NOT NULL,
    imagen VARCHAR(255),
    calificacion INT CHECK (calificacion BETWEEN 1 AND 5),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Crear la tabla de contactos (mensajes)
CREATE TABLE IF NOT EXISTS contactos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    mensaje TEXT NOT NULL,
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar algunos datos de ejemplo en la tabla de libros
INSERT INTO books (titulo, autor, genero, imagen, calificacion) VALUES
('Harry Potter y La Piedra Filosofal', 'J.K. Rowling', 'Ficción', 'hp1.jpg', 5),
('1984', 'George Orwell', 'Ficción Distópica', '1984.jpg', 5),
('Cien años de soledad', 'Gabriel García Márquez', 'Realismo Mágico', 'cien.jpg', 5),
('El Señor de los Anillos', 'J.R.R. Tolkien', 'Fantasía', 'lotr.jpg', 5);
