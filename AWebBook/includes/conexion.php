<?php
$servidor = "127.0.0.1";
//$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "biblioteca_virtual";
$puerto = 3307;

$db = mysqli_connect($servidor, $usuario, $contrasena, $base_datos, $puerto);
//$db = mysqli_connect($servidor, $usuario, $contrasena, $base_datos);

if(!$db){
    die("Error en la conexión: " . mysqli_connect_error());
}
?>
