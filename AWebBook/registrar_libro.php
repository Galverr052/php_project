<?php
session_start();
require './includes/conexion.php';

if(!isset($_SESSION['usuario']) || $_SESSION['usuario']['is_admin'] != 1){
    header("Location: index.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $id_categoria = intval($_POST['id_categoria']);

    // imagen
    $imagen = "default.png";

    if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0){
        $imagen = $_FILES['imagen']['name'];
        move_uploaded_file($_FILES['imagen']['tmp_name'], "./img/$imagen");
    }

    $sql = "INSERT INTO libros (titulo, autor, id_categoria, disponible, imagen)
            VALUES ('$titulo', '$autor', $id_categoria, 1, '$imagen')";

    mysqli_query($db, $sql);

    header("Location: index.php");
    exit;
}