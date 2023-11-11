<?php
session_start();
include("conbd.php");

if (!isset($_SESSION['usuario'])) {
    header('Location: log.php');
    exit();
}

// Verificar si el rol del usuario es igual a 1 o 2 (alumno o docente)
if ($_SESSION['usuario']['rol'] == 1 || $_SESSION['usuario']['rol'] == 2) {
    header('Location: pagina_no_autorizada.php'); // Redirigir a una página no autorizada
    exit();
}

$sql = "SELECT nombre_cpr FROM centro_practica";
$stmt = $conn->prepare($sql);
$stmt->execute();
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="agregar_alumno.css">
    <title>Agregar Alumno</title>
</head>
<body>
    <div class="background-box">
        <h1>Agregar Alumno</h1>
        <form action="agregar_alumno.php" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required><br>

            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" required><br>

            <label for="rut">Rut:</label>
            <input type="text" name="rut" required><br>

            <label for="correo">Correo:</label>
            <input type="text" name="correo" required pattern="[a-zA-Z0-9._%+-]+@alumnos\.ulagos\.cl$" title="Ingrese una dirección de correo válida con el formato nombre@alumnos.ulagos.cl" value="@alumnos.ulagos.cl"><br>

            <label for="telefono">Telefono:</label>
            <input type="text" name="telefono" required><br>

            <label for="centro_practica">Centro de práctica:</label>
            <select name="centro_practica" required>
                <?php foreach ($resultados as $fila) { ?>
                    <option value="<?php echo $fila['nombre_cpr']; ?>"><?php echo $fila['nombre_cpr']; ?></option>
            <?php } ?>  
            </select>

            <label for="tipo_practica">Tipo práctica:</label>
            <select name="tipo_practica" required>
                <option value="1">Primera</option>
                <option value="2">Segunda</option>
            </select>

            <label for="fecha_creacion">Fecha de creación de usuario:</label>
            <input type="date" name="fecha_creacion" required><br>

            <input type="submit" value="Agregar Alumno">
        </form>
    
        <div id="mensaje">
        <!-- Aquí se mostrará el mensaje de éxito o error -->
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                // Obtener los datos del formulario
                    $nombre = $_POST['nombre'];
                    $apellido = $_POST['apellido'];
                    $rut = $_POST['rut'];
                    $correo = $_POST['correo'];
                    $telefono = $_POST['telefono'];
                    $centro_practica = $_POST['centro_practica'];
                    $tipo_practica = $_POST['tipo_practica'];
                    $fecha_creacion = $_POST['fecha_creacion'];
                    $contrasena = 'a'. $rut;

                // Traer id del centro de práctica
                    $sql_cpr = "SELECT id_cpr FROM centro_practica WHERE nombre_cpr = '$centro_practica'";
                    $stmt = $conn->prepare($sql_cpr);
                    $stmt->execute();

                    $id_cpr = $stmt->fetch();
                    $idcpr = $id_cpr['id_cpr'];

                    // Realizar la inserción en la tabla Alumno
                    $sql_alumno = "INSERT INTO Alumno_1 (rut_alumno, id_alumno, nombre_al, apellido_al, correo_al, telefono_al, perfil, id_cpr, id_tipopr) VALUES 
                    ('$rut','','$nombre','$apellido','$correo','$telefono','1','$idcpr','$tipo_practica')";

                    // Preparar la declaración
                    $stmt = $conn->prepare($sql_alumno);

                    // Ejecutar la consulta
                    $stmt->execute();

                    // Realizar la inserción en la tabla Usuarios
                    $sql_usuario = "INSERT INTO usuarios (id_usuario, rut, nombre, alias, correo, rol, fecha_creacion, contrasena) VALUES 
                    ('','$rut','$nombre','$nombre','$correo','1','$fecha_creacion', '$contrasena')";

                    // Preparar la declaración
                    $stmt = $conn->prepare($sql_usuario);

                    // Ejecutar la consulta
                    $stmt->execute();

                    echo '<p style="color: green;">Alumno agregado exitosamente.</p>';
                } catch (PDOException $e) {
                    echo '<p style="color: red;">Hubo un error al agregar el alumno.</p>';
                }
            }
         ?>
        </div>
        <button onclick="location.href='coordinador.php'">Volver al Menú</button>
        <button onclick="location.href='listar_alumnos.php'">Ver Todos los Alumnos</button>
    </div>        

</body>
</html>
