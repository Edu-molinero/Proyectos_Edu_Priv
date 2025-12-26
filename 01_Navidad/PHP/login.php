<?php
// login.php
require_once 'config.php';

// Si ya está logueado, redirigir al dashboard
if (isset($_SESSION['id_usuario'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = trim($_POST['usuario']);
    $contrasena = $_POST['contrasena'];

    if (empty($usuario) || empty($contrasena)) {
        $error = 'Por favor completa todos los campos';
    } else {
        try {
            $stmt = $conn->prepare("SELECT id_usuario, nombre_usuario, contrasena FROM usuarios WHERE nombre_usuario = ? OR correo_electronico = ?");
            $stmt->execute([$usuario, $usuario]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($contrasena, $user['contrasena'])) {
                $_SESSION['id_usuario'] = $user['id_usuario'];
                $_SESSION['nombre_usuario'] = $user['nombre_usuario'];
                
                // Registrar inicio de sesión
                try {
                    $stmt = $conn->prepare("INSERT INTO sesiones (id_usuario, ip_address, user_agent) VALUES (?, ?, ?)");
                    $stmt->execute([$user['id_usuario'], getUserIP(), getUserAgent()]);
                } catch(PDOException $e) {
                    // Si falla el registro de sesión, continuar de todas formas
                }
                
                header('Location: ../index.php');
                exit;
            } else {
                $error = 'Usuario o contraseña incorrectos';
            }
        } catch(PDOException $e) {
            $error = 'Error en el sistema: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎅 Iniciar Sesión - Navidad Mágica</title>
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

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            width: 100%;
        }

        .login-box {
            background: rgba(255,255,255,0.95);
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            max-width: 450px;
            width: 100%;
            backdrop-filter: blur(10px);
            border: 3px solid #c41e3a;
            position: relative;
            z-index: 10;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header h1 {
            color: #c41e3a;
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .login-header p {
            color: #2d5016;
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
            border-color: #c41e3a;
            box-shadow: 0 0 10px rgba(196,30,58,0.2);
        }

        .login-btn {
            width: 100%;
            background: linear-gradient(90deg, #c41e3a 0%, #8b1428 100%);
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

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(196,30,58,0.4);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .divider {
            text-align: center;
            margin: 25px 0;
            color: #666;
            position: relative;
        }

        .divider::before,
        .divider::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 40%;
            height: 1px;
            background: #ddd;
        }

        .divider::before {
            left: 0;
        }

        .divider::after {
            right: 0;
        }

        .register-link {
            text-align: center;
            color: #666;
            margin-top: 20px;
        }

        .register-link a {
            color: #c41e3a;
            text-decoration: none;
            font-weight: bold;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .back-home {
            text-align: center;
            margin-top: 15px;
        }

        .back-home a {
            color: #2d5016;
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
            animation: swing 3s ease-in-out infinite;
        }

        @keyframes swing {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(5deg); }
            75% { transform: rotate(-5deg); }
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
            .login-box {
                padding: 40px 25px;
            }
            
            .login-header h1 {
                font-size: 2em;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="christmas-decoration">🎅</div>
            
            <div class="login-header">
                <h1>¡Bienvenido!</h1>
                <p>Inicia sesión para disfrutar de la magia navideña</p>
            </div>

            <?php if ($error): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="login.php">
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
                ¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a>
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