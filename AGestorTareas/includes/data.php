<?php
require 'conexion.php';

function getTareas($db, $id_user = null, $id_tarea = null){

    if ($id_tarea !== null) {
        // Caso editar una tarea 
        $sql = "SELECT id, usuario_id, titulo, descripcion, fecha_entrega, estado
                FROM tareas
                WHERE id = $id_tarea";
    } 
    else if ($id_user !== null) {
        // tareas del usuario
        $sql = "SELECT id, usuario_id, titulo, descripcion, fecha_entrega, estado
                FROM tareas
                WHERE usuario_id = $id_user";
    } 
    else {
        $sql = "SELECT id, usuario_id, titulo, descripcion, fecha_entrega, estado
                FROM tareas";
    }

    $query = mysqli_query($db, $sql);
    $resultado = [];

    if ($query && mysqli_num_rows($query) > 0) {
        while ($fila = mysqli_fetch_assoc($query)) {
            $resultado[] = $fila;
        }
    }

    return $resultado;
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
	$sql = "SELECT id, nombre, email, contraseña FROM usuarios;";
	$usuarios = mysqli_query($db, $sql);

	$resultado = array();
	if($usuarios && mysqli_num_rows($usuarios) >=1){
		while($user = mysqli_fetch_assoc($usuarios)){
			array_push($resultado, $user);
		}
	}
	return $resultado;
}


function insertarTarea($db, $titulo, $descripcion, $fecha_entrega, $estado, $id_user)
{
	$check = false;

	$sqlInsert = "INSERT INTO tareas ( usuario_id, titulo, descripcion, fecha_entrega, estado)
		VALUES($id_user, '$titulo', '$descripcion', '$fecha_entrega', '$estado')";
	$query = mysqli_query($db, $sqlInsert);

	if($query){
		$check = true;
	}
	return $check;
}

function guardarCambiosTarea($db, $id_tarea, $titulo,  $descripcion,  $fecha_entrega, $estado, $id_user){
	$check = false;

	$sqlInsert = "UPDATE tareas SET
	titulo = '$titulo',
	descripcion = '$descripcion',
	fecha_entrega = '$fecha_entrega',
	estado = '$estado'
	WHERE id = $id_tarea AND usuario_id = $id_user";

	$query = mysqli_query($db, $sqlInsert);

	if($query){
		$check = true;
	}
	return $check;
}

function eliminarTarea($db, $id_tarea){
	$check = false;
	$sqlInsert = "DELETE FROM tareas WHERE id= '$id_tarea'";

	$query = mysqli_query($db, $sqlInsert);

	if($query){
		$check = true;
	}
	return $check;
}

?>
