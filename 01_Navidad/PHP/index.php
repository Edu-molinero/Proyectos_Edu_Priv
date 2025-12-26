<!-- ============================================ -->
<!-- index.php - Dashboard principal después del login -->
<!-- ============================================ -->
<?php
require_once 'config.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../PAGES/login.php');
    exit;
}

// Obtener información del usuario
$stmt = $conn->prepare("SELECT nombre_usuario, correo_electronico FROM usuarios WHERE id_usuario = ?");
$stmt->execute([$_SESSION['id_usuario']]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Obtener total de sesiones
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM sesiones WHERE id_usuario = ?");
$stmt->execute([$_SESSION['id_usuario']]);
$sesiones = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎄 Dashboard - Navidad</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: "❄️";
            position: absolute;
            font-size: 30px;
            animation: snow 10s linear infinite;
        }
        @keyframes snow {
            0% { top: -10%; left: 10%; }
            100% { top: 110%; left: 80%; }
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 500px;
            width: 90%;
            text-align: center;
        }
        h1 {
            color: #c41e3a;
            margin-bottom: 10px;
            font-size: 2.5em;
        }
        .welcome {
            color: #2d5016;
            font-size: 1.2em;
            margin: 20px 0;
        }
        .info {
            background: #f0f8ff;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: left;
        }
        .info p {
            margin: 10px 0;
            color: #333;
        }
        .btn {
            background: #2d5016;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            margin: 10px 5px;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #1a300d;
        }
        .btn-danger {
            background: #c41e3a;
        }
        .btn-danger:hover {
            background: #a01729;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎄 ¡Feliz Navidad! 🎄</h1>
        <p class="welcome">Bienvenido/a, <strong><?php echo htmlspecialchars($usuario['nombre_usuario']); ?></strong></p>
        
        <div class="info">
            <p><strong>📧 Correo:</strong> <?php echo htmlspecialchars($usuario['correo_electronico']); ?></p>
            <p><strong>🔐 Sesiones totales:</strong> <?php echo $sesiones['total']; ?></p>
        </div>

        <a href="historial.php" class="btn">📋 Ver Historial de Sesiones</a>
        <a href="admin.php" class="btn">🎅 Panel de Administración</a>
        <a href="../index.php" class="btn btn-secondary">🏠 Volver al inicio</a>
        <br>
        <a href="logout.php" class="btn btn-danger">🚪 Cerrar Sesión</a>
    </div>
</body>
</html>