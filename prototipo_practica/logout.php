<?php
session_start();

// Cerrar sesión y eliminar todas las variables de sesión
session_unset();
session_destroy();

// Redireccionar al formulario de inicio de sesión
header('Location: log.php');
exit();
?>