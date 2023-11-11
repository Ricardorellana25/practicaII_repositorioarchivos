<?php
session_start();
//include ("conexionbd.php")

if (!isset($_SESSION['usuario'])) {
    // El usuario no ha iniciado sesión, redireccionar al formulario de inicio de sesión
    header('Location: log.php');
    exit();
}
// Verificar si el rol del usuario es diferente de alumno (rol = 1)
if ($_SESSION['usuario']['rol'] == 2) {
    header('Location: pagina_no_autorizada.php'); // Redirigir a una página no autorizada
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universidad de Los Lagos - A</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <h1 class="universidad">Universidad de los Lagos(Alumno)</h1>
        <h1 class="nombre_bienvenido">Bienvenido, <?php echo $_SESSION['usuario']['nombre']; ?></h1>
    </header>
    
    <div class="container">
        <aside class="sidebar">
            <ul class="sidebar-menu">
              <li><a href="subirarchivo.php">Subir archivo</a></li>
              <li><a href="ver_docs_al.php">Ver Documentos</a></li>
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

