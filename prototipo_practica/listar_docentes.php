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

// Consulta SQL para obtener la lista de docentes
$sql = "SELECT * FROM docente";
$stmt = $conn->prepare($sql);
$stmt->execute();
$docentes = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Listado de Docentes</title>
</head>
<body>
    <h1>Listado de Docentes</h1>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>RUT</th>
            <th>Correo</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($docentes as $docente) { ?>
        <tr>
            <td><?php echo $docente['nombre_d']; ?></td>
            <td><?php echo $docente['apellido_d']; ?></td>
            <td><?php echo $docente['rut_d']; ?></td>
            <td><?php echo $docente['correo_d']; ?></td>
            <td>
                <a href="editar_docente.php?id_d=<?php echo $docente['id_d']; ?>">Editar</a>
                <a href="eliminar_docente.php?id_d=<?php echo $docente['id_d']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar a este docente?')">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>
    <button onclick="location.href='agregar_docente.php'">Agregar Nuevo Docente</a>
    <button onclick="location.href='coordinador.php'">Volver al Menú</button>
</body>
</html>
