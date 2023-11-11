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

// Consulta SQL para obtener la lista de alumnos
$sql = "SELECT * FROM Alumno_1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <title>Listado de Alumnos</title>
</head>
<body>
    <h1>Listado de Alumnos</h1>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>RUT</th>
            <th>Correo</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($alumnos as $alumno) { ?>
        <tr>
            <td><?php echo $alumno['nombre_al']; ?></td>
            <td><?php echo $alumno['apellido_al']; ?></td>
            <td><?php echo $alumno['rut_alumno']; ?></td>
            <td><?php echo $alumno['correo_al']; ?></td>
            <td>
                <a href="editar_alumno.php?id_alumno=<?php echo $alumno['id_alumno']; ?>">Editar</a>
                <a href="eliminar_alumno.php?id=<?php echo $alumno['id_alumno']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar a este alumno?')">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>
    <button onclick="location.href='agregar_alumno.php'">Agregar Nuevo Alumno</a>
    <button onclick="location.href='coordinador.php'">Volver al Menú</button>
</body>
</html>
