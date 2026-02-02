<?php
require 'conexion.php';

function getLibros($db, $id_categoria = null) {
    $sql = "SELECT l.*, c.nombre AS categoria 
            FROM libros l 
            LEFT JOIN categorias c ON l.id_categoria = c.id_categoria";
    
    if ($id_categoria) {
        $sql .= " WHERE l.id_categoria = " . intval($id_categoria);
    }

    $result = mysqli_query($db, $sql);
    $libros = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while($libro = mysqli_fetch_assoc($result)) {
            $libros[] = $libro;
        }
    }
    return $libros;
}

function getCategorias($db) {
    $sql = "SELECT * FROM categorias";
    $result = mysqli_query($db, $sql);
    $categorias = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while($cat = mysqli_fetch_assoc($result)) {
            $categorias[] = $cat;
        }
    }
    return $categorias;
}


function guardarNuevoUsuario($nombre, $email, $password, $db){
	//CIFRARC CONTRASEÑA
	//Cost=>4, cifra 4 veces la contraseña
	$password_segura=password_hash($password, PASSWORD_BCRYPT,['cost'=>4]);
	//Comprobamos que la contraseña dada por el usuario corresponda con la cifrada.
	password_verify($password,$password_segura);//lo usamos para hacer el login.

	$sqlInsert= "INSERT INTO usuarios (nombre, email, contraseña) VALUES ('$nombre','$email', '$password_segura')";

	$query = mysqli_query($db, $sqlInsert);

	if($query){
		$_SESSION['registro'] =  true;
	}else{
		$_SESSION['registro'] =  false;
	}
	return $_SESSION['registro'];
}

function getUsers($db){
	$sql = "SELECT id_usuario, nombre_usuario, email, password, is_admin FROM usuarios;";
	$usuarios = mysqli_query($db, $sql);

	$resultado = array();
	if($usuarios && mysqli_num_rows($usuarios) >=1){
		while($user = mysqli_fetch_assoc($usuarios)){
			array_push($resultado, $user);
		}
	}
	return $resultado;
}
?>
