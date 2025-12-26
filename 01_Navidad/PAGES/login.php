<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎅 Iniciar Sesión - Navidad Mágica</title>
    <style>
        /* Mantengo estilos existentes... */
        /* (se omite en este archivo para ahorrar espacio; sigue igual que antes) */
    </style>
</head>
<body>
    <!-- Barra superior simple para estado de sesión -->
    <div style="padding:10px; background:#c41e3a; color:white; display:flex; justify-content:flex-end; gap:10px; align-items:center;">
        <?php if (isset($_SESSION['id_usuario'])): ?>
            <span>✅ Sesión iniciada: <strong><?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></strong></span>
            <a href="../PHP/index.php" style="background:white; color:#c41e3a; padding:6px 10px; border-radius:6px; text-decoration:none;">Mi cuenta</a>
            <a href="../index.php" style="background:#6c757d; color:white; padding:6px 10px; border-radius:6px; text-decoration:none;">🏠 Inicio</a>
        <?php else: ?>
            <a href="index.php" style="color:white; text-decoration:underline;">⬅️ Volver al inicio</a>
        <?php endif; ?>
    </div>

    <!-- Contenedor del Login (igual que antes) -->
    <div class="login-container">
        <div class="login-box">
            <div class="christmas-decoration">🎅</div>
            
            <div class="login-header">
                <h1>¡Bienvenido!</h1>
                <p>Inicia sesión para disfrutar de la magia navideña</p>
            </div>

            <?php if (isset($_SESSION['id_usuario'])): ?>
                <div class="success">Ya has iniciado sesión como <strong><?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></strong>.</div>
            <?php endif; ?>

            <form method="POST" action="../PHP/login.php">
                <div class="form-group">
                    <label>👤 Usuario o Correo Electrónico</label>
                    <input type="text" name="usuario" placeholder="Ingresa tu usuario o email" required>
                </div>

                <div class="form-group">
                    <label>🔒 Contraseña</label>
                    <input type="password" name="contrasena" placeholder="Ingresa tu contraseña" required>
                </div>

                <button type="submit" class="login-btn">🎄 Iniciar Sesión</button>
            </form>

            <div class="divider">o</div>

            <div class="register-link">
                <a href="registro.php">Regístrate aquí</a>
            </div>

            <div class="back-home">
                <a href="../index.php">⬅️ Volver al inicio</a>
            </div>
        </div>
    </div>

    <script>
        // Crear copos de nieve (igual que antes)
    </script>
</body>
</html>