<?php
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "biblioteca_virtual";


$db = mysqli_connect($servidor, $usuario, $contrasena, $base_datos);
if(!$db){
    die("Error en la conexión: " .  mysqli_connect_error());
}
?>