<?php
session_start();
include 'conbd.php';

if (!isset($_SESSION['usuario'])) {
    // El usuario no ha iniciado sesión, redireccionar al formulario de inicio de sesión
    header('Location: log.php');
    exit();
}

// Verificar si el rol del usuario es diferente de coordinador (rol = 3)
if ($_SESSION['usuario']['rol'] == 1 || $_SESSION['usuario']['rol'] == 2) {
    header('Location: pagina_no_autorizada.php'); // Redirigir a una página no autorizada
    exit();
}

$sql = "SELECT a.id_archivo, a.nombre_archivo, a.fecha_publicacion, al.nombre_al, al.apellido_al, al.correo_al
        FROM archivo a
        INNER JOIN Alumno_1 al ON a.id_al = al.id_alumno";
$stmt = $conn->prepare($sql);
$stmt->execute();
$archivos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Archivos Subidos por Alumnos</title>
    <!-- Estilos CSS -->
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Archivos Subidos por Alumnos</h1>
    <table>
        <thead>
            <tr>
                <th scope="col">Alumno</th>
                <th scope="col">Nombre archivo</th>
                <th scope="col">Fecha publicación</th>
                <th scope="col">Ver archivo</th>
            </tr>
        </thead>
        <?php foreach ($archivos as $archivo) {
            $correoAl = $archivo['correo_al'];
            list($nombreAlumno, $dominio) = explode('@', $correoAl);
        ?>  
        <tr>
            <td><?php echo $archivo['nombre_al'] . ' ' . $archivo['apellido_al']; ?></td>
            <td><?php echo $archivo['nombre_archivo']; ?></td>
            <td><?php echo $archivo['fecha_publicacion']; ?></td>
            <td><a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/ss-practicas/www/newlog/files/'.urlencode($nombreAlumno).'/'.$archivo['nombre_archivo'];?>">Ver archivo</a></td>
        </tr>
        <?php } ?>
    </table>
    <!-- Botón para volver al menú principal del coordinador -->
    <button onclick="window.location.href='coordinador.php';">Volver al menú principal</button>
</body>
</html>
