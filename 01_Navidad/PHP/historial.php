<!-- ============================================ -->
<!-- historial.php - Historial de sesiones -->
<!-- ============================================ -->
<?php
// historial.php
require_once 'config.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../PAGES/login.php');
    exit;
}

$stmt = $conn->prepare("
    SELECT fecha_inicio_sesion, ip_address, user_agent 
    FROM sesiones 
    WHERE id_usuario = ? 
    ORDER BY fecha_inicio_sesion DESC 
    LIMIT 20
");
$stmt->execute([$_SESSION['id_usuario']]);
$sesiones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📋 Historial de Sesiones</title>
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
            padding: 20px;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 800px;
            margin: 0 auto;
        }
        h2 {
            color: #c41e3a;
            margin-bottom: 30px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #2d5016;
            color: white;
        }
        tr:hover {
            background: #f5f5f5;
        }
        .back-btn {
            background: #2d5016;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s;
        }
        .back-btn:hover {
            background: #1a300d;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📋 Historial de Sesiones</h2>
        
        <?php if (count($sesiones) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Fecha y Hora</th>
                        <th>IP</th>
                        <th>Navegador</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sesiones as $sesion): ?>
                        <tr>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($sesion['fecha_inicio_sesion'])); ?></td>
                            <td><?php echo htmlspecialchars($sesion['ip_address']); ?></td>
                            <td><?php echo htmlspecialchars(substr($sesion['user_agent'], 0, 50)) . '...'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">No hay sesiones registradas</div>
        <?php endif; ?>
        
        <a href="index.php" class="back-btn">⬅️ Volver al inicio</a>
    </div>
</body>
</html>