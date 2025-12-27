<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎁 Registro - Navidad Mágica</title>
    <link rel="stylesheet" href="/Proyectos_Edu_Priv/01_Navidad/CSS/estilos.css">
    <style>
        /* Estilos específicos del registro (copiados de registro.html) */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #1a472a 0%, #0d2818 100%);
            color: #fff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        /* Contenedor del registro */
        .register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            width: 100%;
        }

        .register-box {
            background: rgba(255,255,255,0.95);
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            max-width: 500px;
            width: 100%;
            backdrop-filter: blur(10px);
            border: 3px solid #2d5016;
            position: relative;
            z-index: 10;
        }

        .register-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .register-header h1 {
            color: #2d5016;
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .register-header p {
            color: #c41e3a;
            font-size: 1.1em;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            color: #333;
            margin-bottom: 8px;
            font-weight: bold;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
            background: #fff;
        }

        .form-group input:focus {
            outline: none;
            border-color: #2d5016;
            box-shadow: 0 0 10px rgba(45,80,22,0.2);
        }

        .register-btn {
            width: 100%;
            background: linear-gradient(90deg, #2d5016 0%, #1a300d 100%);
            color: white;
            padding: 16px;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(45,80,22,0.4);
        }

        .login-link {
            text-align: center;
            color: #666;
            margin-top: 20px;
        }

        .login-link a {
            color: #2d5016;
            text-decoration: none;
            font-weight: bold;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .back-home {
            text-align: center;
            margin-top: 15px;
        }

        .back-home a {
            color: #c41e3a;
            text-decoration: none;
            font-weight: bold;
        }

        .back-home a:hover {
            text-decoration: underline;
        }

        .christmas-decoration {
            text-align: center;
            font-size: 3em;
            margin-bottom: 20px;
        }

        .snowflake {
            position: fixed;
            top: -10px;
            z-index: 1;
            color: #fff !important;
            font-family: 'Segoe UI Emoji', 'Noto Color Emoji', 'Apple Color Emoji', sans-serif;
            font-size: 18px !important; /* tamaño mínimo para evitar cuadros pequeños */
            line-height: 1;
            animation: fall linear infinite;
            pointer-events: none;
            background: transparent !important;
            text-shadow: 0 0 2px rgba(0,0,0,0.6);
        }

        @keyframes fall {
            to {
                transform: translateY(100vh);
            }
        }

        .error {
            background: #ffebee;
            color: #c62828;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border-left: 4px solid #c62828;
        }

        .success {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border-left: 4px solid #2e7d32;
        }

        @media (max-width: 768px) {
            .register-box {
                padding: 40px 25px;
            }
            
            .register-header h1 {
                font-size: 2em;
            }
        }
    </style>
</head>
<body class="auth-page register-mode">
    <!-- Barra estado sesión -->
        <?php if (isset($_SESSION['id_usuario'])): ?>
            <span>Sesión iniciada: <strong><?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></strong></span>
            <a href="../PHP/index.php" style="background:white; color:#c41e3a; padding:6px 10px; border-radius:6px; text-decoration:none;">Mi cuenta</a>
            <a href="../index.php" style="background:#6c757d; color:white; padding:6px 10px; border-radius:6px; text-decoration:none;">🏠 Inicio</a>
        <?php else: ?>
            <!-- enlace 'Volver al inicio' eliminado -->
        <?php endif; ?>

    <!-- Contenido del registro (igual que antes) -->
    <div class="register-container">
        <div class="register-box">
            <div class="christmas-decoration">🎁</div>
            
            <div class="register-header">
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
        // Crear copos de nieve
        function createSnowflake() {
            const snowflake = document.createElement('div');
            snowflake.classList.add('snowflake');
            snowflake.innerHTML = '❄';
            snowflake.style.left = Math.random() * 100 + '%';
            snowflake.style.animationDuration = Math.random() * 3 + 2 + 's';
            snowflake.style.opacity = Math.random();
            snowflake.style.fontSize = Math.random() * 10 + 10 + 'px';
            
            document.body.appendChild(snowflake);
            
            setTimeout(() => {
                snowflake.remove();
            }, 5000);
        }
        
        setInterval(createSnowflake, 300);
    </script>
</body>
</html>