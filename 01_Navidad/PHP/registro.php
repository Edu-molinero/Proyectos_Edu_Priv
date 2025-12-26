<?php
// registro.php
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = trim($_POST['nombre_usuario']);
    $correo = trim($_POST['correo']);
    $contrasena = $_POST['contrasena'];
    $confirmar = $_POST['confirmar_contrasena'];

    // Validaciones
    if (empty($nombre_usuario) || empty($correo) || empty($contrasena)) {
        $error = 'Todos los campos son obligatorios';
    } elseif ($contrasena !== $confirmar) {
        $error = 'Las contraseñas no coinciden';
    } elseif (strlen($contrasena) < 6) {
        $error = 'La contraseña debe tener al menos 6 caracteres';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error = 'El correo electrónico no es válido';
    } else {
        try {
            // Hash de la contraseña
            $hash = password_hash($contrasena, PASSWORD_DEFAULT);
            
            // Insertar directamente en lugar de usar el procedimiento almacenado
            $stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, correo_electronico, contrasena) VALUES (?, ?, ?)");
            $stmt->execute([$nombre_usuario, $correo, $hash]);
            
            // Obtener el ID del usuario recién creado
            $id_nuevo_usuario = $conn->lastInsertId();
            
            // Iniciar sesión automáticamente
            $_SESSION['id_usuario'] = $id_nuevo_usuario;
            $_SESSION['nombre_usuario'] = $nombre_usuario;
            
            // Registrar la primera sesión
            try {
                $stmt = $conn->prepare("INSERT INTO sesiones (id_usuario, ip_address, user_agent) VALUES (?, ?, ?)");
                $stmt->execute([$id_nuevo_usuario, getUserIP(), getUserAgent()]);
            } catch(PDOException $e) {
                // Si falla el registro de sesión, continuar
            }
            
            $success = '¡Usuario registrado exitosamente! Redirigiendo...';
            header('refresh:1;url=../index.php');
        } catch(PDOException $e) {
            if ($e->getCode() == 23000) {
                $error = 'El usuario o correo ya existe';
            } else {
                $error = 'Error al registrar: ' . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎄 Registro - Navidad Mágica</title>
    <style>
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
            color: #fff;
            font-size: 1em;
            animation: fall linear infinite;
            pointer-events: none;
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
<body>
    <div class="register-container">
        <div class="register-box">
            <div class="christmas-decoration">🎄</div>
            
            <div class="register-header">
                <h1>¡Únete a la Magia!</h1>
                <p>Crea tu cuenta y disfruta de la Navidad</p>
            </div>

            <?php if ($error): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form method="POST" action="registro.php">
                <div class="form-group">
                    <label>👤 Nombre de Usuario</label>
                    <input type="text" name="nombre_usuario" placeholder="Elige un nombre de usuario" required>
                </div>

                <div class="form-group">
                    <label>📧 Correo Electrónico</label>
                    <input type="email" name="correo" placeholder="tu@email.com" required>
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
                ¿Ya tienes cuenta? <a href="../PAGES/login.php">Inicia sesión aquí</a>
            </div>

            <div class="back-home">
                <a href="../index.php">⬅️ Volver al inicio</a>
            </div>
        </div>
    </div>

    <script>
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