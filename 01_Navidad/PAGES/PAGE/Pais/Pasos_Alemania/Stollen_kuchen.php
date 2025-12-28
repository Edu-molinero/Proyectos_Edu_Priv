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
                    <a class="nav-link active" href="/Proyectos_Edu_Priv/01_Navidad/index.php"
                        aria-current="page">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" aria-current="page">Información</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Proyectos_Edu_Priv/01_Navidad/PAGES/PAGE/recetas.php"
                        aria-current="page">Recetas</a>
                </li>
            </ul>
            <div class="d-flex">
                <?php if (isset($_SESSION['id_usuario'])): ?>
                <div class="d-flex align-items-center">
                    <span class="text-white me-2">Sesión iniciada:
                        <strong><?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></strong></span>
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
            <h1 class="display-4">Stollen Kuchen</h1>
            <p class="lead">El Stollen es un tradicional pan dulce navideño originario de Alemania.</p>
            <hr class="my-4">
            <p>Ahora te mostraremos los pasos para prepararlo.</p>
        </div>
    </div>

    <!-- Cards -->
    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-10 mb-3">
                <div class="card">
                    <img src="../../../../IMG/stollen_kuchen.jpg" class="card-img-top" alt="Receta1">
                    <div class="card-body">
                        <!-- Ingredientes -->
                        <h5>Ingredientes: </h5>
                        <p><b>-</b> 430 gr. De harina</p>
                        <p><b>-</b> 100-150 gr. De azúcar</p>
                        <p><b>-</b> 200 gr. De queso crema</p>
                        <p><b>-</b> 3 huevos</p>
                        <p><b>-</b> 80 gr. De manteca pomada</p>
                        <p><b>-</b> 21 gr. De levadura fresca</p>
                        <p><b>-</b> 6 gr. De sal</p>
                        <p><b>-</b> 1 cdta. De esencia de vainilla</p>
                        <p><b>-</b> 1/2 cdta. De nuez moscada</p>
                        <p><b>-</b> Ralladura de naranja</p>
                        <p><b>-</b> 400 gr. De pasas de uva</p>
                        <p><b>-</b> 100 gr. De arándanos</p>
                        <p><b>-</b> Para decorar: glasé</p>

                        <!-- Preparación -->
                        <h5>Preparación:</h5>
                        <p><b>1.</b> Comenzamos colocando en un bol los huevos, añadimos el queso crema, la manteca
                            pomada, 100 gr de azúcar o 150 gr.
                            Si lo quieren más dulce, 6 gr. De sal, la ralladura de naranja, la esencia de vainilla, la
                            canela y la nuez moscada.
                            Previo a lo antedicho maceramos las frutas con Ron unas 4 horas o toda la noche.
                        </p>
                        <p><b>2.</b> Integramos todos los ingredientes con la batidora con las varillas de amasado, no
                            hay que amasar.
                            Batimos unos 4 a 5 minutos tiene que quedar como una crema. Luego agregamos la harina
                            tamizada, la levadura fresca y la pizca
                            de sal e integramos nuevamente con todos los ingredientes y dejamos en reposo 30 minutos.
                        </p>
                        <p><b>3.</b> Luego agregamos las frutas escurridas sin el Ron y volvemos a batir. Y una vez todo
                            integrado en un molde rectangular untamos con manteca y un poquito de harina y colocamos la
                            masa,
                            esparcimos bien con ayuda de una espátula, tapamos y dejamos leudar unas 3 horas
                            aproximadamente.
                            Pasado el tiempo llevamos a horno precalentado 180 a 190° unos 30 minutos o hasta ver que
                            está dorado.
                            Retiramos del horno dejamos 10 minutos en el molde y desmoldamos hasta que se enfríe por
                            completo.
                        </p>
                        <p><b>4.</b> En una ollita calentamos mermelada de Damasco agregamos una cucharada de agua y
                            luego
                            pincelamos el stollen. En un bol ponemos 150 gr. De azúcar glass y una cucharada de jugo de
                            limón y
                            una cucharada de agua mezclamos bien hasta lograr una consistencia cremosa y la esparcimos
                            por toda
                            la parte de arriba del stollen.
                        </p>

                        <a href="../Alemania.php" class="btn btn-danger">Volver atrás</a>
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
            <li class="nav-item"><a href="../Proyectos_Edu_Priv/01_Navidad/index.php"
                    class="nav-link px-2 py-0 text-body-secondary footer-link">Inicio</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 py-0 text-body-secondary footer-link">Información
                    general</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 py-0 text-body-secondary footer-link">Sobre
                    nosotros</a></li>
        </ul>

        <p class="text-center text-body-secondary mb-0 footer-texto bg-danger">© 2025 Navidad. Todos los derechos
            reservados.|
            <a rel="license" href="https://creativecommons.org/licenses/by-nc/4.0/"
                class="text-decoration-none text-body-secondary">
                Licencia Creative Commons
            </a>
        </p>
    </footer>

</body>

</html>