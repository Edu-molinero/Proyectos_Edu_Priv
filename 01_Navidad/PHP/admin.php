<?php
// admin.php - Panel de administración para gestionar usuarios
require_once 'config.php';

// Verificar que el usuario esté logueado
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../PAGES/login.php');
    exit;
}

// Verificar si el usuario es administrador (puedes crear una columna 'es_admin' en la BD)
// Por ahora vamos a comprobar si el usuario es exactamente 'Edu' y si su contraseña coincide con '123123'
$stmt = $conn->prepare("SELECT nombre_usuario, contrasena FROM usuarios WHERE id_usuario = ?");
$stmt->execute([$_SESSION['id_usuario']]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

// Permiso especial para eliminar usuarios: solo 'Edu' con contraseña '123123'
$is_full_admin = false;
if ($admin && $admin['nombre_usuario'] === 'Edu') {
    // Comprobar que la contraseña almacenada corresponde a '123123'
    if (password_verify('123123', $admin['contrasena'])) {
        $is_full_admin = true;
    }
} 

// Procesar acciones
$mensaje = '';
$tipo_mensaje = '';

// ELIMINAR USUARIO
if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
    $id_eliminar = $_GET['eliminar'];

    // Solo usuarios con permiso especial pueden eliminar
    if (!$is_full_admin) {
        $mensaje = 'No tienes permisos para eliminar usuarios';
        $tipo_mensaje = 'error';
    } else {
        // Evitar que el admin se elimine a sí mismo
        if ($id_eliminar != $_SESSION['id_usuario']) {
            try {
                $stmt = $conn->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
                $stmt->execute([$id_eliminar]);
                $mensaje = 'Usuario eliminado correctamente';
                $tipo_mensaje = 'success';
            } catch(PDOException $e) {
                $mensaje = 'Error al eliminar usuario: ' . $e->getMessage();
                $tipo_mensaje = 'error';
            }
        } else {
            $mensaje = 'No puedes eliminarte a ti mismo';
            $tipo_mensaje = 'error';
        }
    }
} 

// ACTIVAR/DESACTIVAR USUARIO
if (isset($_GET['toggle']) && is_numeric($_GET['toggle'])) {
    $id_toggle = $_GET['toggle'];
    
    if ($id_toggle != $_SESSION['id_usuario']) {
        try {
            $stmt = $conn->prepare("UPDATE usuarios SET activo = NOT activo WHERE id_usuario = ?");
            $stmt->execute([$id_toggle]);
            $mensaje = 'Estado del usuario actualizado';
            $tipo_mensaje = 'success';
        } catch(PDOException $e) {
            $mensaje = 'Error al actualizar: ' . $e->getMessage();
            $tipo_mensaje = 'error';
        }
    }
}

// BUSCAR USUARIOS
$busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
$filtro_activo = isset($_GET['filtro']) ? $_GET['filtro'] : 'todos';

// Construir consulta con filtros
$query = "SELECT u.id_usuario, u.nombre_usuario, u.correo_electronico, u.fecha_registro, u.activo,
          COUNT(s.id_sesion) as total_sesiones,
          MAX(s.fecha_inicio_sesion) as ultima_sesion
          FROM usuarios u
          LEFT JOIN sesiones s ON u.id_usuario = s.id_usuario
          WHERE 1=1";

$params = [];

if (!empty($busqueda)) {
    $query .= " AND (u.nombre_usuario LIKE ? OR u.correo_electronico LIKE ?)";
    $params[] = "%$busqueda%";
    $params[] = "%$busqueda%";
}

if ($filtro_activo === 'activos') {
    $query .= " AND u.activo = 1";
} elseif ($filtro_activo === 'inactivos') {
    $query .= " AND u.activo = 0";
}

$query .= " GROUP BY u.id_usuario ORDER BY u.fecha_registro DESC";

$stmt = $conn->prepare($query);
$stmt->execute($params);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener estadísticas
$stmt = $conn->query("SELECT COUNT(*) as total FROM usuarios");
$total_usuarios = $stmt->fetch()['total'];

$stmt = $conn->query("SELECT COUNT(*) as total FROM usuarios WHERE activo = 1");
$usuarios_activos = $stmt->fetch()['total'];

$stmt = $conn->query("SELECT COUNT(*) as total FROM sesiones");
$total_sesiones = $stmt->fetch()['total'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎅 Panel de Administración - Navidad</title>
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
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            background: rgba(255,255,255,0.95);
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .header h1 {
            color: #c41e3a;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header p {
            color: #666;
            font-size: 1.1em;
        }

        .nav-admin {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .nav-admin a {
            background: #2d5016;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .nav-admin a:hover {
            background: #1a300d;
            transform: translateY(-2px);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: rgba(255,255,255,0.95);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            text-align: center;
        }

        .stat-card h3 {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .stat-card .number {
            color: #c41e3a;
            font-size: 2.5em;
            font-weight: bold;
        }

        .stat-card .icon {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .filters {
            background: rgba(255,255,255,0.95);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .filters form {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: end;
        }

        .form-group {
            flex: 1;
            min-width: 200px;
        }

        .form-group label {
            display: block;
            color: #333;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 14px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }

        .btn {
            padding: 10px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #c41e3a;
            color: white;
        }

        .btn-primary:hover {
            background: #a01729;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .table-container {
            background: rgba(255,255,255,0.95);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            color: #333;
        }

        th {
            background: #c41e3a;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: bold;
            position: sticky;
            top: 0;
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background: #f5f5f5;
        }

        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-success {
            background: #28a745;
            color: white;
        }

        .badge-danger {
            background: #dc3545;
            color: white;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        .btn-warning {
            background: #ffc107;
            color: #333;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-info {
            background: #17a2b8;
            color: white;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-size: 1.2em;
        }

        @media (max-width: 768px) {
            .filters form {
                flex-direction: column;
            }
            
            .form-group {
                width: 100%;
            }
            
            table {
                font-size: 12px;
            }
            
            th, td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🎅 Panel de Administración</h1>
            <p>Bienvenido, <strong><?php echo htmlspecialchars($admin['nombre_usuario']); ?></strong></p>
            
            <div class="nav-admin">
                <a href="index.php">🏠 Volver al inicio</a>
                <a href="historial.php">📋 Mi historial</a>
                <a href="logout.php">🚪 Cerrar sesión</a>
            </div>
        </div>

        <?php if ($mensaje): ?>
            <div class="alert alert-<?php echo $tipo_mensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <!-- Estadísticas -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon">👥</div>
                <h3>Total Usuarios</h3>
                <div class="number"><?php echo $total_usuarios; ?></div>
            </div>
            <div class="stat-card">
                <div class="icon">✅</div>
                <h3>Usuarios Activos</h3>
                <div class="number"><?php echo $usuarios_activos; ?></div>
            </div>
            <div class="stat-card">
                <div class="icon">🔐</div>
                <h3>Total Sesiones</h3>
                <div class="number"><?php echo $total_sesiones; ?></div>
            </div>
        </div>

        <!-- Filtros de búsqueda -->
        <div class="filters">
            <form method="GET" action="admin.php">
                <div class="form-group">
                    <label>🔍 Buscar usuario</label>
                    <input type="text" name="buscar" placeholder="Nombre o correo..." 
                           value="<?php echo htmlspecialchars($busqueda); ?>">
                </div>
                
                <div class="form-group">
                    <label>📊 Estado</label>
                    <select name="filtro">
                        <option value="todos" <?php echo $filtro_activo === 'todos' ? 'selected' : ''; ?>>Todos</option>
                        <option value="activos" <?php echo $filtro_activo === 'activos' ? 'selected' : ''; ?>>Activos</option>
                        <option value="inactivos" <?php echo $filtro_activo === 'inactivos' ? 'selected' : ''; ?>>Inactivos</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary">Buscar</button>
                <a href="admin.php" class="btn btn-secondary">Limpiar</a>
            </form>
        </div>

        <!-- Tabla de usuarios -->
        <div class="table-container">
            <h2 style="color: #c41e3a; margin-bottom: 20px;">📋 Lista de Usuarios</h2>
            
            <?php if (count($usuarios) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Correo</th>
                            <th>Fecha Registro</th>
                            <th>Estado</th>
                            <th>Sesiones</th>
                            <th>Última Sesión</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $user): ?>
                            <tr>
                                <td><?php echo $user['id_usuario']; ?></td>
                                <td><strong><?php echo htmlspecialchars($user['nombre_usuario']); ?></strong></td>
                                <td><?php echo htmlspecialchars($user['correo_electronico']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($user['fecha_registro'])); ?></td>
                                <td>
                                    <?php if ($user['activo']): ?>
                                        <span class="badge badge-success">✓ Activo</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">✗ Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $user['total_sesiones']; ?></td>
                                <td>
                                    <?php 
                                    if ($user['ultima_sesion']) {
                                        echo date('d/m/Y H:i', strtotime($user['ultima_sesion']));
                                    } else {
                                        echo 'Nunca';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <div class="actions">
                                        <?php if ($user['id_usuario'] != $_SESSION['id_usuario']): ?>
                                            <a href="admin.php?toggle=<?php echo $user['id_usuario']; ?>" 
                                               class="btn btn-sm btn-warning"
                                               onclick="return confirm('¿Cambiar estado del usuario?')">
                                                <?php echo $user['activo'] ? '🔒' : '🔓'; ?>
                                            </a>
                                            <?php if ($is_full_admin): ?>
                                                <a href="admin.php?eliminar=<?php echo $user['id_usuario']; ?>" 
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('¿Estás seguro de eliminar este usuario? Esta acción no se puede deshacer.')">
                                                    🗑️
                                                </a>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="badge" style="background: #6c757d; color: white;">Tú</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-data">
                    🔍 No se encontraron usuarios con los filtros aplicados
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>