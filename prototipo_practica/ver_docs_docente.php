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

//Traer id del docente
$rol = $_SESSION['usuario']['rol'];
$rut = $_SESSION['usuario']['rut'];
$sqld = "SELECT id_d FROM docente WHERE perfil = '$rol' AND rut_d = '$rut'";
$stmtd = $conn->prepare($sqld);
$stmtd->execute();
$res = $stmtd->fetch();
$docenteId = $res['id_d'];

$sql = "SELECT a.id_archivo, a.nombre_archivo, a.fecha_publicacion, a.id_al, al.nombre_al, al.apellido_al, al.correo_al
        FROM archivo a
        INNER JOIN asignacion_guia ag ON a.id_al = ag.id_al
        INNER JOIN Alumno_1 al ON a.id_al = al.id_alumno
        WHERE ag.id_d = :docenteId";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':docenteId', $docenteId, PDO::PARAM_INT);
$stmt->execute();
$archivos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$correoAl = $archivos['al.correo_al'];
list($nombreAlumno, $dominio) = explode('@', $correoAl);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archivos de Alumnos Asignados</title>
    <!-- Estilos CSS -->
    <style>
        table {
            border-collapse: collapse;
            width: 70%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Ajusta el ancho de las columnas */
        th:nth-child(1),
        td:nth-child(1) {
            width: 30%;
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 30%;
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 40%;
        }
        /* Estilos del botón */
        .back-button {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Archivos de Alumnos Asignados</h1>
    <table>
        <thead>
            <tr>
                <th scope="col">Alumno</th>
                <th scope="col">Nombre archivo</th>
                <th scope="col">Fecha publicación</th>
                <th scope="col">Ver archivo</th>
                <th scope="col">Realizar comentarios</th>
            </tr>
        </thead>
        <?php foreach ($archivos as $fila) {
            $correoAl = $fila['correo_al'];
            list($nombreAlumno, $dominio) = explode('@', $correoAl);
        ?>
        <tr>
            <td><?php echo $fila['nombre_al'] . ' ' . $fila['apellido_al']; ?></td>
            <td><?php echo $fila['nombre_archivo']; ?></td>
            <td><?php echo $fila['fecha_publicacion']; ?></td>
            <td><a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/ss-practicas/www/newlog/files/'.urlencode($nombreAlumno).'/'.$fila['nombre_archivo'];?>"><?php echo $fila['nombre_archivo']; ?></a></td>
            <td><a href="realizar_comentarios.php?id_archivo=<?php echo $fila['id_archivo']; ?>"> Realizar comentarios</a></td>

        </tr>
        <?php } ?>
    </table>
    <button class="back-button" onclick="window.location.href='docente.php';">Volver al menú principal</button>
</body>
</html>
