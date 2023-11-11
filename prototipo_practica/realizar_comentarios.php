<?php
session_start();
include 'conbd.php';

if (!isset($_SESSION['usuario'])) {
    // El usuario no ha iniciado sesión, redireccionar al formulario de inicio de sesión
    header('Location: log.php');
    exit();
}

// Verificar si el rol del usuario es diferente de docente (rol = 2)
if ($_SESSION['usuario']['rol'] == 1) {
    header('Location: pagina_no_autorizada.php'); // Redirigir a una página no autorizada
    exit();
}

// Verificar si se ha proporcionado un ID de archivo válido
if (!isset($_GET['id_archivo']) || empty($_GET['id_archivo'])) {
    header('Location: ver_docs_docente.php'); // Redirigir de vuelta a la lista de archivos
    exit();
}

$idArchivo = $_GET['id_archivo'];

//Traer id del docente
$rol = $_SESSION['usuario']['rol'];
$rut = $_SESSION['usuario']['rut'];
$sqld = "SELECT id_d FROM docente WHERE perfil = '$rol' AND rut_d = '$rut'";
$stmtd = $conn->prepare($sqld);
$stmtd->execute();
$res = $stmtd->fetch();
$docenteId = $res['id_d'];

// Verificar si el archivo pertenece a un alumno asignado al docente
$sqlVerif = "SELECT COUNT(*) AS count FROM archivo a
             INNER JOIN asignacion_guia ag ON a.id_al = ag.id_al
             WHERE ag.id_d = :docenteId AND a.id_archivo = :idArchivo";
$stmtVerif = $conn->prepare($sqlVerif);
$stmtVerif->bindParam(':docenteId', $docenteId, PDO::PARAM_INT);
$stmtVerif->bindParam(':idArchivo', $idArchivo, PDO::PARAM_INT);
$stmtVerif->execute();
$resultVerif = $stmtVerif->fetch(PDO::FETCH_ASSOC);

if ($resultVerif['count'] === '0') {
    header('Location: ver_docs_docente.php'); // Redirigir de vuelta a la lista de archivos
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comentario = $_POST['comentario'];
    
    // Insertar el comentario en la base de datos
    $sql = "INSERT INTO comentario (comentario, id_d, id_archivo, fecha_comentario) VALUES (:comentario, :docenteId, :idArchivo, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':comentario', $comentario, PDO::PARAM_STR);
    $stmt->bindParam(':docenteId', $docenteId, PDO::PARAM_INT);
    $stmt->bindParam(':idArchivo', $idArchivo, PDO::PARAM_INT);
    $stmt->execute();
    
    // Redirigir a la página de archivos
    header('Location: ver_docs_docente.php');
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Comentarios</title>
</head>
<body>
    <h1>Realizar Comentarios</h1>
    <form action="realizar_comentarios.php?id_archivo=<?php echo $idArchivo; ?>" method="post">
        <label for="comentario">Comentario:</label>
        <textarea id="comentario" name="comentario" rows="4" cols="50" required></textarea><br><br>
        <input type="submit" value="Guardar Comentario">
    </form>
    <button onclick="window.location.href='ver_docs_docente.php';">Volver a la lista de archivos</button>
</body>
</html>
