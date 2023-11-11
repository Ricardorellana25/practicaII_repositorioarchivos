<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    // El usuario no ha iniciado sesión, redireccionar al formulario de inicio de sesión
    header('Location: log.php');
    exit();
}

$rol = $_SESSION['usuario']['rol'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="pagina_no_autorizada.css">
    <title>Acceso No Autorizado</title>
</head>
<body>
    <h1>Acceso No Autorizado</h1>
    <?php
    switch ($rol) {
        case 1:
            echo "<p>Lo siento, los alumnos no tienen acceso a esta página.</p>";
            echo '<p><a href="alumnos.php">Volver al Menú del Alumno</a></p>';
            break;
        case 2:
            echo "<p>Lo siento, los docentes no tienen acceso a esta página.</p>";
            echo '<p><a href="docente.php">Volver al Menú del Docente</a></p>';
            break;
        case 3:
            echo "<p>Lo siento, los coordinadores no tienen acceso a esta página.</p>";
            echo '<p><a href="coordinador.php">Volver al Menú del Coordinador</a></p>';
            break;
        default:
            echo "<p>Lo siento, no tienes permiso para acceder a esta página.</p>";
            echo '<p><a href="index.php">Volver al Menú Principal</a></p>';
    }
    ?>
</body>
</html>
