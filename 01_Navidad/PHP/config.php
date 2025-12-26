<?php
// config.php - Configuración de la base de datos
session_start();

// CAMBIA ESTOS VALORES POR LOS DE TU SERVIDOR
define('DB_HOST', 'localhost');
define('DB_USER', 'root');  // Cambia esto por tu usuario de MySQL
define('DB_PASS', '');      // Cambia esto por tu contraseña de MySQL (vacío si no tienes)
define('DB_NAME', 'navidad');

try {
    $conn = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage() . "<br><br>
         <strong>Verifica:</strong><br>
         1. Que MySQL esté corriendo<br>
         2. Que el usuario y contraseña sean correctos<br>
         3. Que la base de datos 'navidad_db' exista<br>
         4. Si usas XAMPP, el usuario suele ser 'root' sin contraseña");
}

// Funciones auxiliares
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

function getUserAgent() {
    return $_SERVER['HTTP_USER_AGENT'] ?? 'Desconocido';
}
?>