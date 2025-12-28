<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/Proyectos_Edu_Priv/01_Navidad/CSS/estilos.css">
    <title>Recetas - Navidad</title>
</head>

<body>

    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-sm navbar-dark bg-danger">
        <a class="navbar-brand" href="#">- 01 - Navidad</a>
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
            aria-label="Toggle navigation"></button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="/Proyectos_Edu_Priv/01_Navidad/index.php" aria-current="page">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" aria-current="page">Información</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Proyectos_Edu_Priv/01_Navidad/PAGES/PAGE/recetas.php" aria-current="page">Recetas</a>
                </li>
            </ul>
            <div class="d-flex">
                <?php if (isset($_SESSION['id_usuario'])): ?>
                    <div class="d-flex align-items-center">
                        <span class="text-white me-2">Sesión iniciada: <strong><?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></strong></span>
                        <a href="../../PHP/index.php" class="btn btn-light btn-sm ms-2">Mi cuenta</a>
                    </div>
                <?php else: ?>
                    <a href="../login.php" class="btn login-btn-custom">🎅 Iniciar Sesión</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Contenido de la página -->
    <div class="container mt-3">
        <div class="jumbotron">
            <h1 class="display-4">Glühwein</h1>
            <p class="lead">Es un vino caliente o vino especiado y es una preparación alcohólica que se compone principalmente de vino, azúcar, naranja y especias.</p>
            <hr class="my-4">
            <p>Ahora te mostraremos los pasos para prepararlo.</p>
        </div>
    </div>

    <!-- Cards -->
    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-8 mb-3">
                <div class="card">
                    <img src="../../../../IMG/gluhwein.jpg" class="card-img-top" alt="Receta2">
                    <div class="card-body">
                        <!-- Ingredientes -->
                        <h5 class="card-title">Ingredientes:</h5>
                        <!-- Preparación -->
                        <a href="#" class="btn btn-danger">Pasos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5y+5hb7ieS2d3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <!-- Fin contenido de la página -->

    <!-- Footer -->
        <footer class="py-1 mt-3 footer-principal bg-danger">
            <ul class="nav justify-content-center border-bottom pb-1 mb-1">
                <li class="nav-item"><a href="../Proyectos_Edu_Priv/01_Navidad/index.php" class="nav-link px-2 py-0 text-body-secondary footer-link">Inicio</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 py-0 text-body-secondary footer-link">Información general</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 py-0 text-body-secondary footer-link">Sobre nosotros</a></li>
            </ul>

            <p class="text-center text-body-secondary mb-0 footer-texto bg-danger">© 2025 Navidad. Todos los derechos reservados.|
                <a rel="license" href="https://creativecommons.org/licenses/by-nc/4.0/"
                    class="text-decoration-none text-body-secondary">
                    Licencia Creative Commons
                </a>
            </p>
        </footer>

</body>

</html>