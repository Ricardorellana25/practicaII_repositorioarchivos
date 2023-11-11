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
    // Eliminar el docente de la base de datos
    $sqlDelete = "DELETE FROM docente WHERE id_d = :docenteId";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bindValue(':docenteId', $docenteId);
    $stmtDelete->execute();

    header('Location: listar_docentes.php'); // Redirigir a la lista de docentes después de eliminar
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Docente</title>
</head>
<body>
    <h1>Eliminar Docente</h1>
    <p>¿Estás seguro de que deseas eliminar al docente <?php echo $docente['nombre_d']; ?>?</p>
    <form action="eliminar_docente.php?id_d=<?php echo $docenteId; ?>" method="post">
        <input type="submit" value="Eliminar">
    </form>
    <button onclick="location.href='listar_docentes.php'">Cancelar</button>
</body>
</html>
