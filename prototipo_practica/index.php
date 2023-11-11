<?php
session_start();

// Verificar si el usuario ha iniciado sesión
//if (!isset($_SESSION['usuario'])) {
    // El usuario no ha iniciado sesión, redireccionar al formulario de inicio de sesión
   // header('Location: log.php');
   // exit();
//}

// El usuario ha iniciado sesión, mostrar la página de inicio
?>
<!DOCTYPE html>
<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de inicio</title>
    <link rel="stylesheet" type="text/css" href="index.css"> 
</head>
<body>
    <h1>Bienvenido</h1>
    <p>Esta es la página de inicio.</p>
    <a href="log.php">Iniciar sesión</a>
    
</body>
</html>