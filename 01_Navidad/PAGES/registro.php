<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎁 Registro - Navidad Mágica</title>
    <style>
        /* Estilos omitidos (igual que antes) */
    </style>
</head>
<body>
    <!-- Barra estado sesión -->
    <div style="padding:10px; background:#c41e3a; color:white; display:flex; justify-content:flex-end; gap:10px; align-items:center;">
        <?php if (isset($_SESSION['id_usuario'])): ?>
            <span>✅ Sesión iniciada: <strong><?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></strong></span>
            <a href="../PHP/index.php" style="background:white; color:#c41e3a; padding:6px 10px; border-radius:6px; text-decoration:none;">Mi cuenta</a>
            <a href="../index.php" style="background:#6c757d; color:white; padding:6px 10px; border-radius:6px; text-decoration:none;">🏠 Inicio</a>
        <?php else: ?>
            <a href="../index.php" style="color:white; text-decoration:underline;">⬅️ Volver al inicio</a>
        <?php endif; ?>
    </div>

    <!-- Contenido del registro (igual que antes) -->
    <div class="login-container">
        <div class="login-box">
            <div class="christmas-decoration">🎁</div>
            
            <div class="login-header">
                <h1>¡Regístrate!</h1>
                <p>Crea una cuenta y comparte la magia</p>
            </div>

            <form method="POST" action="../PHP/registro.php">
                <div class="form-group">
                    <label>👤 Nombre de usuario</label>
                    <input type="text" name="nombre_usuario" placeholder="Elige un nombre" required>
                </div>

                <div class="form-group">
                    <label>📧 Correo</label>
                    <input type="email" name="correo" placeholder="Tu correo electrónico" required>
                </div>

                <div class="form-group">
                    <label>🔒 Contraseña</label>
                    <input type="password" name="contrasena" placeholder="Mínimo 6 caracteres" required>
                </div>

                <div class="form-group">
                    <label>🔒 Confirmar Contraseña</label>
                    <input type="password" name="confirmar_contrasena" placeholder="Repite tu contraseña" required>
                </div>

                <button type="submit" class="register-btn">🎁 Registrarse</button>
            </form>

            <div class="login-link">
                ¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a>
            </div>

            <div class="back-home">
                <a href="../index.php">⬅️ Volver al inicio</a>
            </div>
        </div>
    </div>

    <script>
        // Nieve (igual que antes)
    </script>
</body>
</html>