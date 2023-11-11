<?php
//include ("conexionbd.php")
session_start();
if (!isset($_SESSION['usuario'])) {
    // El usuario no ha iniciado sesión, redireccionar al formulario de inicio de sesión
    header('Location: log.php');
    exit();
}

// Verificar si el rol del usuario es igual a 1 o 2 (alumno o docente)
if ($_SESSION['usuario']['rol'] == 1 || $_SESSION['usuario']['rol'] == 2) {
    header('Location: pagina_no_autorizada.php'); // Redirigir a una página no autorizada
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universidad de Los Lagos - C</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <h1>Universidad de los Lagos(Coordinador)</h1>
        <h1>Bienvenido, <?php echo $_SESSION['usuario']['nombre']; ?></h1>
        <p>Esta es la página de inicio.</p>
    </header>
    <div class="container">
        <aside class="sidebar">
            <ul class="sidebar-menu">
              <li><a href="agregar_alumno.php">Agregar Alumno</a></li>
              <li><a href="agregar_docente.php">Agregar Docente</a></li>
              <li><a href="asignar_guia.php">Asignar Docente a Alumno</a></li>
              <li><a href="listar_alumnos.php">Listar Alumnos</a></li> 
              <li><a href="listar_docentes.php">Listar Docentes</a></li> 
              <li><a href="ver_docs_coor.php">Ver Documentos</a></li>
              <li><a href="logout.php">Cerrar sesión</a></li>
            </ul>
        </aside>
          
        <main class="informacion">
            <p>LOREM IPSUM</p>
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
