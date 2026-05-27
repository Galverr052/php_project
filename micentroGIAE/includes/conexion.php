<?php
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "centro_educativo";


$db = mysqli_connect($servidor, $usuario, $contrasena, $base_datos);
if(!$db){
    die("Error en la conexión: " .  mysqli_connect_error());
}
echo"Conexion Exitosa"
?>