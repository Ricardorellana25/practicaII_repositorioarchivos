<?php
session_start();
include("conbd.php"); // Incluye el archivo de conexión a la base de datos

// Verificar si el usuario ya ha iniciado sesión
//if (!isset($_SESSION['usuario'])) {
    // El usuario no ha iniciado sesión, redireccionar al formulario de inicio de sesión
    //header('Location: log.php');
    //exit();
//}

// Obtener los valores del formulario
$username = $_POST['username'];
$domain = $_POST['domain'];
$contrasena = $_POST['password'];

$correo = $username . $domain;

// Consulta SQL // Validacion login
$sql = "SELECT * FROM usuarios WHERE correo = '$correo' AND contrasena = '$contrasena'";

// Preparar la declaración
$stmt = $conn->prepare($sql);

// Ejecutar la consulta
$stmt->execute();

// Obtener los resultados
$result = $stmt->fetch();

//Si encuentra usuario, ingresa
if ($result !== false) {
    if($result['rol'] == 1){
        $_SESSION['usuario']=$result;
        header('Location: alumnos.php');
    }
    elseif($result['rol'] == 2){
        $_SESSION['usuario']=$result;
        header('Location: docente.php');
    }
    elseif($result['rol'] == 3){
        $_SESSION['usuario']=$result;
        header('Location: coordinador.php');
    }
    
} else {
    header('Location: error.html');
}
?>