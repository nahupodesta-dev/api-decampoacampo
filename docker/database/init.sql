CREATE DATABASE IF NOT EXISTS api_productos;
USE api_productos;

CREATE TABLE IF NOT EXISTS productos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO productos (nombre, descripcion, precio) VALUES
('Producto A', 'Desc del producto A', 1000.00),
('Producto B', 'Desc del producto B', 1500.50),
('Producto C', 'Desc del producto C', 2000.75);