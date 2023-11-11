<?php
//include ("conexionbd.php")
session_start();
if (!isset($_SESSION['usuario'])) {
    // El usuario no ha iniciado sesión, redireccionar al formulario de inicio de sesión
    header('Location: log.php');
    exit();
}
// Verificar si el rol del usuario es diferente de docente (rol = 2)
if ($_SESSION['usuario']['rol'] == 1) {
    header('Location: pagina_no_autorizada.php'); // Redirigir a una página no autorizada
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universidad de Los Lagos - D</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <h1>Universidad de los Lagos(Docente)</h1>
        <h1>Bienvenido, <?php echo $_SESSION['usuario']['nombre']; ?></h1>
        <p>Esta es la página de inicio.</p>
    </header>
    <div class="container">
        <aside class="sidebar">
            <ul class="sidebar-menu">
              <li><a href="ver_alumnos_asignados.php">Ver alumnos asignados</a></li>
              <li><a href="ver_docs_docente.php">Ver Documentos</a></li>
              <li><a href="logout.php">Cerrar sesión</a></li>
            </ul>
        </aside>
        
        <main>
            <!-- Contenido principal aquí -->
        </main>
    </div>
    <footer>
        <div class="container">
            <div class="footer-left">
                <p>Información adicional</p>
            </div>
            <div class="footer-right">
                <img src="https://elecciones.ulagos.cl/static/media/logo.87d5c665.svg" alt="Universidad de Los Lagos" class="footer-logo">
                <p>Universidad de Los Lagos</p>
            </div>
        </div>
    </footer>
</body>
</html>
