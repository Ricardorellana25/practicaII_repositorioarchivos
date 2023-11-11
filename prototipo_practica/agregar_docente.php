<?php 
    session_start();
    include("conbd.php");

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
    
    <link rel="stylesheet" type="text/css" href="agregar_docente.css">
    <title>Agregar Docente</title>
</head>
<body>
    <div class="background-box">
        <h1>Agregar Docente</h1>
        <form action="agregar_docente.php" method="post">
        
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required><br><br>
        
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required><br><br>
        
            <label for="rut">Rut:</label>
            <input type="text" name="rut" required><br>

            <label for="correo">Correo:</label>
            <input type="email" name="correo" required><br>

            <label for="telefono">Telefono:</label>
            <input type="text" name="telefono" required><br>
        
            <label for="fecha_creacion">Fecha de creacion de usuario:</label>
            <input type="date" name="fecha_creacion" required><br>
        
            <input type="submit" value="Agregar Docente">
        </form>

        <div id="mensaje">
        <?php
        // Verificar si se ha enviado el formulario
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                 try {
                    // Obtener los datos del formulario
                    $nombre = $_POST['nombre'];
                    $apellido = $_POST['apellido'];
                    $rut = $_POST['rut'];
                    $correo = $_POST['correo'];
                    $telefono = $_POST['telefono'];
                    $fecha_creacion = $_POST['fecha_creacion'];
                    $contrasena = 'd'. $rut;

                    // Realizar la inserción en la tabla Docente
                    $sql_docente = "INSERT INTO docente (rut_d, id_d, nombre_d, apellido_d, correo_d, telefono_d, perfil) VALUES 
                    ('$rut','','$nombre','$apellido','$correo','$telefono','2')";

                    // Preparar la declaración
                    $stmt = $conn->prepare($sql_docente);

                    // Ejecutar la consulta
                    $stmt->execute();

                    // Realizar la inserción en la tabla Usuarios
                    $sql_usuario = "INSERT INTO usuarios (id_usuario, rut, nombre, alias, correo, rol, fecha_creacion, contrasena) VALUES 
                    ('','$rut','$nombre','$nombre','$correo','2','$fecha_creacion', '$contrasena')";

                    // Preparar la declaración
                    $stmt = $conn->prepare($sql_usuario);

                    // Ejecutar la consulta
                    $stmt->execute();

                    echo '<p style="color: green;">Docente agregado exitosamente.</p>';
                } catch (PDOException $e) {
                    echo '<p style="color: red;">Hubo un error al agregar al docente.</p>';
                }
            }
        ?>
        </div>
        <button onclick="location.href='coordinador.php'">Volver al Menú</button>
        <button onclick="location.href='listar_docentes.php'">Ver Todos los Docentes</button>
    </div>
</body>
</html>


