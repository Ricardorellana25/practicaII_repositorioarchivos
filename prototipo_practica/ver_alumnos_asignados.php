<?php
session_start();
include 'conbd.php';

if (!isset($_SESSION['usuario'])) {
    // El usuario no ha iniciado sesión, redireccionar al formulario de inicio de sesión
    header('Location: log.php');
    exit();
}

// Verificar si el rol del usuario es igual a 1 alumno
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

// Consultar la base de datos para obtener los alumnos asignados al docente

$sql = "SELECT Alumno_1.nombre_al, asignacion_guia.fecha_asign 
        FROM asignacion_guia 
        INNER JOIN Alumno_1 
        ON asignacion_guia.id_al = Alumno_1.id_alumno 
        WHERE asignacion_guia.id_d = $docenteId";
$stmt = $conn->prepare($sql);

$stmt->execute();
// Obtener los resultados en un arreglo
$alumnosAsignados = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos Asignados al Docente</title>
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
    <h1>Alumnos Asignados al Docente</h1>
    <table>
        <tr>
            <th>Alumno</th>
            <th>Fecha de Asignación</th>
        </tr>
        <?php foreach ($alumnosAsignados as $fila) { ?>
        <tr>
            <td><?php echo $fila['nombre_al']; ?></td>
            <td><?php echo $fila['fecha_asign']; ?></td>
        </tr>
        <?php } ?>
    </table>
    <br>
    <button class="back-button" onclick="window.location.href='docente.php';">Volver al menú principal</button>
</body>
</html>
