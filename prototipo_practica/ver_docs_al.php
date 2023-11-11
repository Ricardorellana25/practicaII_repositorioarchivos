<?php
session_start();
include 'conbd.php';

// Verificar si el usuario ya ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    // El usuario no ha iniciado sesión, redireccionar al formulario de inicio de sesión
    header('Location: log.php');
    exit();
}

// Verificar si el rol del usuario es diferente de alumno (rol = 1)
if ($_SESSION['usuario']['rol'] == 2) {
    header('Location: pagina_no_autorizada.php'); // Redirigir a una página no autorizada
    exit();
}

// Traer id del alumno
$rol = $_SESSION['usuario']['rol'];
$rut = $_SESSION['usuario']['rut'];

$sqlco = "SELECT id_alumno FROM Alumno_1 WHERE perfil = '$rol' AND rut_alumno = '$rut'";
$stmtco = $conn->prepare($sqlco);
$stmtco->execute();
$res = $stmtco->fetch();
$alumId = $res['id_alumno'];

$email = $_SESSION['usuario']['correo'];
list($nombreUsuario, $dominio) = explode('@', $email);

$sql = "SELECT * FROM archivo WHERE id_al = $alumId";
$stmtd = $conn->prepare($sql);
$stmtd->execute();
// Obtener los resultados en un arreglo
$archivos = $stmtd->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archivos Subidos</title>
   
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
    <table>
        <thead>
            <tr>
                <th scope="col">Nombre archivo</th>
                <th scope="col">Fecha publicación</th>
                <th scope="col">Ver archivo</th>
                <th scope="col">Ver comentarios</th>
            </tr>
        </thead>
        <?php foreach ($archivos as $fila) { ?>
        <tr>
            <td><?php echo $fila['nombre_archivo']; ?></td>
            <td><?php echo $fila['fecha_publicacion']; ?></td>
            <td><a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/ss-practicas/www/newlog/files/'.$nombreUsuario.'/'.$fila['nombre_archivo'];?>"><?php echo $fila['nombre_archivo']; ?></a></td>
            <td><a href="ver_comentarios_docente.php?id_archivo=<?php echo $fila['id_archivo']; ?>">Ver comentarios</a></td>
        </tr>
        <?php } ?>
    </table>
    <!-- Botón para volver al index -->
    <button class="back-button" onclick="window.location.href='alumnos.php';">Volver al menú principal</button>
</body>
</html>
