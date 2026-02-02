<?php
session_start();
require './includes/conexion.php'; // conexión a la BD

// Solo admin puede acceder
if(!isset($_SESSION['usuario']) || $_SESSION['usuario']['is_admin'] != 1){
    header("Location: index.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Recoger datos del formulario
    $titulo = $_POST['titulo'] ?? '';
    $autor = $_POST['autor'] ?? '';
    $id_categoria = $_POST['id_categoria'] ?? '';

    // Validación mínima
    if(empty($titulo) || empty($autor) || empty($id_categoria)){
        echo "<div class='alert alert-danger'>Todos los campos son obligatorios.</div>";
        exit;
    }

    // Manejar imagen
    if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0){
        $nombreImagen = $_FILES['imagen']['name'];
        $tmpImagen = $_FILES['imagen']['tmp_name'];
        // Guardar en carpeta img/
        move_uploaded_file($tmpImagen, "./img/$nombreImagen");
    } else {
        $nombreImagen = 'default.png'; // imagen por defecto si no suben nada
    }

    // Insertar libro en la tabla libros
    $sql = "INSERT INTO libros (titulo, autor, id_categoria, disponible, imagen) 
            VALUES ('$titulo', '$autor', $id_categoria, 1, '$nombreImagen')";
    $res = mysqli_query($db, $sql);

    if($res){
        header("Location: index.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error al registrar el libro.</div>";
    }
}
?>
