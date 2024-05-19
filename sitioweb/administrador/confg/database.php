<?php
$host="localhost";
$bd="sitio";
$usuario="root";
$contrasena="5511";

try {
    $conexion = new PDO("mysql:host=$host;dbname=$bd",$usuario,$contrasena);
} catch (Exception $e) {
    echo $e->getMessage();
}
?>