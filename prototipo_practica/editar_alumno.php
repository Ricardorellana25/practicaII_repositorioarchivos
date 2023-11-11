<?php
session_start();
include("conbd.php"); // Incluye el archivo de conexión a la base de datos

// Verificar si el usuario ya ha iniciado sesión
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

// Obtener el ID del alumno a editar de la URL
if (isset($_GET['id_alumno'])) {
    $id_alumno = $_GET['id_alumno'];
} else {
    header('Location: listar_alumnos.php'); // Redirigir a la página de listado de alumnos
    exit();
}

// Obtener los datos del alumno a editar de la base de datos
$sql = "SELECT * FROM Alumno_1 WHERE id_alumno = :id_alumno";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_alumno', $id_alumno);
$stmt->execute();
$alumno = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los nuevos datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $rut = $_POST['rut'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $centro_practica = $_POST['centro_practica'];
    $tipo_practica = $_POST['tipo_practica'];

    // Actualizar los datos del alumno en la base de datos
    $sql_update = "UPDATE Alumno_1 SET nombre_al = :nombre, apellido_al = :apellido, rut_alumno = :rut, correo_al = :correo, telefono_al = :telefono, id_cpr = :centro_practica, id_tipopr = :tipo_practica WHERE id_alumno = :id_alumno";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bindParam(':nombre', $nombre);
    $stmt_update->bindParam(':apellido', $apellido);
    $stmt_update->bindParam(':rut', $rut);
    $stmt_update->bindParam(':correo', $correo);
    $stmt_update->bindParam(':telefono', $telefono);
    $stmt_update->bindParam(':centro_practica', $centro_practica);
    $stmt_update->bindParam(':tipo_practica', $tipo_practica);
    $stmt_update->bindParam(':id_alumno', $id_alumno);
    $stmt_update->execute();

    // Redireccionar a la página de listado de alumnos
    header('Location: listar_alumnos.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Alumno</title>
</head>
<body>
    <h1>Editar Alumno</h1>
    <form action="editar_alumno.php?id_alumno=<?php echo $id_alumno; ?>" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $alumno['nombre_al']; ?>" required><br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" value="<?php echo $alumno['apellido_al']; ?>" required><br>

        <label for="rut">Rut:</label>
        <input type="text" name="rut" value="<?php echo $alumno['rut_alumno']; ?>" required><br>

        <label for="correo">Correo:</label>
        <input type="email" name="correo" value="<?php echo $alumno['correo_al']; ?>" required><br>

        <label for="telefono">Telefono:</label>
        <input type="text" name="telefono" value="<?php echo $alumno['telefono_al']; ?>" required><br>

        <label for="centro_practica">Centro de practica:</label>
        <input type="text" name="centro_practica" value="<?php echo $alumno['id_cpr']; ?>" required><br>

        <label for="tipo_practica">Tipo practica:</label>
        <input type="text" name="tipo_practica" value="<?php echo $alumno['id_tipopr']; ?>" required><br>

        <input type="submit" value="Guardar Cambios">
    </form>
    <form action="eliminar_alumno.php?id_alumno=<?php echo $id_alumno; ?>" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar a este alumno? Esta acción no se puede deshacer.')">
        <input type="submit" value="Eliminar Alumno">
    </form>
    <button onclick="location.href='listar_alumnos.php'">Volver al Listado</button>
</body>
</html>
