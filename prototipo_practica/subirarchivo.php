<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    // El usuario no ha iniciado sesión, redireccionar al formulario de inicio de sesión
    header('Location: log.php');
    exit();
}
if ($_SESSION['usuario']['rol'] == 2) {
    header('Location: pagina_no_autorizada.php'); // Redirigir a una página no autorizada
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="subirarchivo.css">
    <title>Subir archivo</title>
</head>
<body>
    <div style="width: 500px;margin: auto;border: 1px solid blue;padding: 30px;">
        <h4>Subir archivo</h4>
        <form method="POST" action="subir.php" enctype="multipart/form-data">
            <table>
                    
                    <tr>
                        <td colspan="2"><input type="file" name="archivo"></td>
                    </tr>
        
                    <tr>
                        <td><input type="submit" value="Subir archivo" name="Subir archivo"></td>
                        <td><a href="ver_docs_al.php">Ver documentos subidos</a></td>
                    </tr>
            </table>
        </form>            
    </div>
</body>
</html>