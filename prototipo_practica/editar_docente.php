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

if (isset($_GET['id_d'])) {
    $docenteId = $_GET['id_d'];

    // Consulta SQL para obtener la información del docente
    $sql = "SELECT * FROM docente WHERE id_d = :docenteId";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':docenteId', $docenteId);
    $stmt->execute();
    $docente = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$docente) {
        header('Location: listar_docentes.php'); // Redirigir si el docente no existe
        exit();
    }
} else {
    header('Location: listar_docentes.php'); // Redirigir si no se proporciona un id
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar los datos del formulario y actualizar el docente en la base de datos
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];

    $sqlUpdate = "UPDATE docente SET nombre_d = :nombre, apellido_d = :apellido, correo_d = :correo, telefono_d = :telefono WHERE id_d = :docenteId";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bindValue(':nombre', $nombre);
    $stmtUpdate->bindValue(':apellido', $apellido);
    $stmtUpdate->bindValue(':correo', $correo);
    $stmtUpdate->bindValue(':telefono', $telefono);
    $stmtUpdate->bindValue(':docenteId', $docenteId);
    $stmtUpdate->execute();

    header('Location: listar_docentes.php'); // Redirigir a la lista de docentes después de actualizar
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Docente</title>
</head>
<body>
    <h1>Editar Docente</h1>
    <form action="editar_docente.php?id_d=<?php echo $docenteId; ?>" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $docente['nombre_d']; ?>" required><br><br>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" value="<?php echo $docente['apellido_d']; ?>" required><br><br>

        <label for="correo">Correo:</label>
        <input type="email" name="correo" value="<?php echo $docente['correo_d']; ?>" required><br>

        <label for="telefono">Telefono:</label>
        <input type="text" name="telefono" value="<?php echo $docente['telefono_d']; ?>" required><br>

        <input type="submit" value="Actualizar">
    </form>
    <button onclick="location.href='listar_docentes.php'">Cancelar</button>
</body>
</html>
