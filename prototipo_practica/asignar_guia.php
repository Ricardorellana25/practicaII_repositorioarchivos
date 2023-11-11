<?php
include("conbd.php");
session_start();
header("Content-Type: text/html; charset=UTF-8");



if (!isset($_SESSION['usuario'])) {
    
    header('Location: log.php');
    exit();
}


if ($_SESSION['usuario']['rol'] == 1 || $_SESSION['usuario']['rol'] == 2) {
    header('Location: pagina_no_autorizada.php'); 
    exit();
}


$sql = "SELECT * FROM Alumno_1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$alumnos  = $stmt->fetchAll(PDO::FETCH_ASSOC);


$sql_d = "SELECT * FROM docente";
$stmtd = $conn->prepare($sql_d);
$stmtd->execute();
$docentes = $stmtd->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Docente guía a Alumno</title>
    <link rel="stylesheet" type="text/css" href="asignar_guia.css">
</head>
<body>
    <div class="background-box">
        <h1>Asignar Docente guía a Alumno</h1>
        <form action="asignar_guia.php" method="POST">
           <label for="alumno">Alumno:</label>
           <select id="alumno" name="alumno" required>
             <?php foreach ($alumnos as $fila) { ?>
                    <option value="<?php echo $fila['id_alumno']; ?>"><?php echo $fila['nombre_al']; ?></option>
               <?php } ?>
            <!-- Agregar más opciones -->
             </select><br><br>

            <label for="docente">Docente guía:</label>
             <select id="docente" name="docente" required>
            <?php foreach ($docentes as $filad) { ?>
                 <option value="<?php echo $filad['id_d']; ?>"><?php echo $filad['nombre_d']; ?></option>
               <?php } ?>
            <!-- Agregar más opciones -->
            </select><br><br>

            <label for="fecha_asignacion">Fecha de asignación:</label>
            <input type="date" name="fecha_asignacion" required><br>
            <input type="submit" value="Asignar">
        </form>
        <button onclick="location.href='coordinador.php'">Volver al Menú</button>
    </div>
</body>
</html>

<?php 
// Verificar si se ha enviado el formulario

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar los datos del formulario y guardar la asignación en la base de datos
    $alumnoId = $_POST['alumno'];
    $docenteId = $_POST['docente'];
    $fecha_asignacion = $_POST['fecha_asignacion'];
    
    $rol = $_SESSION['usuario']['rol'];
    $rut = $_SESSION['usuario']['rut'];
    //Traer id del coordinador
    $sqlco = "SELECT id_coor FROM coordinador_pr WHERE perfil = '$rol' AND rut_coor = '$rut'";
    $stmtco = $conn->prepare($sqlco);
    $stmtco->execute();
    $res = $stmtco->fetch();
    $coorId = $res['id_coor'];
   
    
    // Guardar la asignación en la base de datos
    $sqla = "INSERT INTO asignacion_guia (id_asign, fecha_asign, id_al, id_d, id_coor) VALUES ('','$fecha_asignacion','$alumnoId','$docenteId','$coorId')";

    // Preparar la declaración
    $stmta = $conn->prepare($sqla);

    // Ejecutar la consulta
    $stmta->execute();
    
    // Redireccionar a una página de éxito o mostrar un mensaje de éxito
    // header('Location: asignacion_exito.php');
    // exit();
}



?>