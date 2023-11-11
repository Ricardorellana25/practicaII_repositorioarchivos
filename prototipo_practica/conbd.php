<?php
$host = 'localhost';
$database = 'ssPracticas';
$username = 'ss-practicas';
$password = 'ssPr4ct1c4s!';

try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "";
} catch(PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}

?>