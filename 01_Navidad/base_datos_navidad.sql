-- Base de datos para página de Navidad
CREATE DATABASE IF NOT EXISTS navidad CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE navidad;

-- Tabla de usuarios
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL UNIQUE,
    correo_electronico VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT TRUE,
    INDEX idx_correo (correo_electronico),
    INDEX idx_usuario (nombre_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de sesiones/inicios de sesión
CREATE TABLE sesiones (
    id_sesion INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    fecha_inicio_sesion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45),
    user_agent VARCHAR(255),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    INDEX idx_usuario_fecha (id_usuario, fecha_inicio_sesion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Procedimiento almacenado para registrar un nuevo usuario
DELIMITER //
CREATE PROCEDURE registrar_usuario(
    IN p_nombre_usuario VARCHAR(50),
    IN p_correo VARCHAR(100),
    IN p_contrasena VARCHAR(255)
)
BEGIN
    INSERT INTO usuarios (nombre_usuario, correo_electronico, contrasena)
    VALUES (p_nombre_usuario, p_correo, p_contrasena);
END //
DELIMITER ;

-- Función para obtener total de inicios de sesión de un usuario
DELIMITER //
CREATE FUNCTION total_sesiones_usuario(p_id_usuario INT)
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE total INT;
    SELECT COUNT(*) INTO total
    FROM sesiones
    WHERE id_usuario = p_id_usuario;
    RETURN total;
END //
DELIMITER ;

-- Vista para consultar usuarios con su último inicio de sesión
CREATE VIEW vista_usuarios_ultima_sesion AS
SELECT 
    u.id_usuario,
    u.nombre_usuario,
    u.correo_electronico,
    u.fecha_registro,
    MAX(s.fecha_inicio_sesion) AS ultima_sesion,
    COUNT(s.id_sesion) AS total_sesiones
FROM usuarios u
LEFT JOIN sesiones s ON u.id_usuario = s.id_usuario
GROUP BY u.id_usuario, u.nombre_usuario, u.correo_electronico, u.fecha_registro;