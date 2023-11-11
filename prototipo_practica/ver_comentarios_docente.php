<?php
session_start();
include 'conbd.php';

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

$idArchivo = $_GET['id_archivo'];

$sqlComentarios = "SELECT c.comentario, c.fecha_comentario, d.nombre_d
                  FROM comentario c
                  INNER JOIN docente d ON c.id_d = d.id_d
                  WHERE c.id_archivo = :idArchivo";
$stmtComentarios = $conn->prepare($sqlComentarios);
$stmtComentarios->bindParam(':idArchivo', $idArchivo, PDO::PARAM_INT);
$stmtComentarios->execute();
$comentarios = $stmtComentarios->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <title>Comentarios del Docente</title>
</head>
<body>
    <h1>Comentarios del Docente</h1>
    <table>
        <thead>
            <tr>
                <th scope="col">Docente</th>
                <th scope="col">Comentario</th>
                <th scope="col">Fecha</th>
            </tr>
        </thead>
        <?php foreach ($comentarios as $comentario) { ?>
        <tr>
            <td><?php echo $comentario['nombre_d']; ?></td>
            <td><?php echo $comentario['comentario']; ?></td>
            <td><?php echo $comentario['fecha_comentario']; ?></td>
        </tr>
        <?php } ?>
    </table>
    <button onclick="window.location.href='ver_docs_al.php';">Volver a la lista de archivos</button>
</body>
</html>
