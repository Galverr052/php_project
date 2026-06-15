<?php
session_start();
require './includes/data.php';

if(!isset($_SESSION['usuario'])){
    header("Location: index.php");
    exit;
}

$id_usuario = $_SESSION['usuario']['id_usuario'];
$id_libro = $_POST['id_libro'];
$puntuacion = $_POST['puntuacion'];
$comentario = $_POST['comentario'];

crearResena($db, $id_usuario, $id_libro, $puntuacion, $comentario);

header("Location: resenas.php?id_libro=$id_libro");