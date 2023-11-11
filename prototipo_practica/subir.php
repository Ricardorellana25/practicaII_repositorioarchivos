<?php
session_start();
include("conbd.php");

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
	//Traer id del alumno
	$rol = $_SESSION['usuario']['rol'];
    $rut = $_SESSION['usuario']['rut'];
    
    $sqlco = "SELECT id_alumno FROM Alumno_1 WHERE perfil = '$rol' AND rut_alumno = '$rut'";
    $stmtco = $conn->prepare($sqlco);
    $stmtco->execute();
    $res = $stmtco->fetch();
    $alumId = $res['id_alumno'];

	// Obtener solo el nombre de usuario sin el dominio
	$email = $_SESSION['usuario']['correo'];
	list($nombreUsuario, $dominio) = explode('@', $email);

	if ($_FILES['archivo']['error'] == 0) { //Valida si no hay errores
		$dir = "files/".$nombreUsuario."/"; //Directorio de carga
		$fechaSubida = date("Y/m/d"); // Obtener la fecha actual
		//Si usuario: alumno, ruta: files/alumno/
		$tamanio = 40000; //Tamaño permitido en kb
		$permitidos = array('pdf', 'xlsx', 'txt'); //Archivos permitido
		$nombreArchivoOriginal = $_FILES['archivo']['name']; // Nombre original del archivo
    	$nombreArchivo = $nombreArchivoOriginal;
   	 	$ruta_carga = $dir.$nombreArchivo;
		//Obtenemos la extensión del archivo
		$arregloArchivo = explode(".", $_FILES['archivo']['name']);
		$extension = strtolower(end($arregloArchivo));

		
		
		if (in_array($extension, $permitidos)) { //Valida si la extensión es permitida
			
			if ($_FILES['archivo']['size'] < ($tamanio * 2048)) { //Valida el tamaño
				
				//Valida si no existe la carpeta y la crea
				if (!file_exists($dir)) {
					mkdir($dir, 0777, true);
					echo $dir;
				}

				//if(!mkdir($dir, 0777, true)) {
					//die('Fallo al crear las carpetas...');
				//}

				// Verificar si el archivo ya existe
				$contador = 1;
				while (file_exists($ruta_carga)) {
					$nombreArchivo = $nombreArchivoOriginal . "_" . $contador . "." . $extension;
					$ruta_carga = $dir . $nombreArchivo;
					$contador++;
				}
				
				if (move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_carga)) {
					
					//Inserción de datos del archivo a base de datos
					$sql = "INSERT INTO archivo (id_archivo, nombre_archivo, fecha_publicacion, id_al) VALUES ('','$nombreArchivo', '$fechaSubida','$alumId')";
					// Preparar la declaración
    				$stmt = $conn->prepare($sql);
					// Ejecutar la consulta
					$stmt->execute();
					
					echo "Archivo cargado exitosamente";
				
				} else {
					echo "Error al cargar archivo";
					
				}
			} else {
				echo "Archivo excede el tamaño permitido";
			}
		} else {
			echo "Archivo no permitido por formato (Formatos aceptados pdf, xlsx)";
		}
	} else {
		echo "No enviaste archivo";
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="subir.css">
    <title>Subida de archivo</title>
</head>
<body>
	<div class="background-box">
    	<h1>Hey, <?php echo $_SESSION['usuario']['nombre']; ?></h1>
    	<p>¿Qué desea hacer ahora?</p>
    	<a href="alumnos.php">Volver</a>
    	<a href="logout.php">Cerrar sesión</a>
	</div>
</body>
</html>