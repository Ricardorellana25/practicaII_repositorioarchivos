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

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id_alumno = $_GET['id'];

    // Consulta SQL para obtener la información del alumno
    $sql = "SELECT * FROM Alumno_1 WHERE id_alumno = :id_alumno";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_alumno', $id_alumno);
    $stmt->execute();
    $alumno = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$alumno) {
        header('Location: listar_alumnos.php');
        exit();
    }
} else {
    header('Location: listar_alumnos.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];

    if ($accion === 'eliminar') {
        // Consulta SQL para eliminar al alumno
        $sql = "DELETE FROM Alumno_1 WHERE id_alumno = :id_alumno";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_alumno', $id_alumno);

        if ($stmt->execute()) {
            header('Location: listar_alumnos.php');
            exit();
        } else {
            echo "Error al eliminar el alumno.";
        }
    } else if ($accion === 'cancelar') {
        header('Location: listar_alumnos.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Alumno</title>
</head>
<body>
    <h1>Eliminar Alumno</h1>
    <p>¿Estás seguro de que deseas eliminar a este alumno?</p>
    <p>Nombre: <?php echo $alumno['nombre_al']; ?></p>
    <p>Apellido: <?php echo $alumno['apellido_al']; ?></p>
    <p>RUT: <?php echo $alumno['rut_alumno']; ?></p>
    <p>Correo: <?php echo $alumno['correo_al']; ?></p>
    <form action="eliminar_alumno.php?id=<?php echo $alumno['id_alumno']; ?>" method="POST">
        <input type="hidden" name="accion" value="eliminar">
        <button type="submit">Eliminar</button>
        <button type="button" onclick="location.href='listar_alumnos.php'">Cancelar</button>
    </form>
</body>
</html>
