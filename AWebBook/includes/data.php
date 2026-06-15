<?php
// Incluimos el archivo de conexión a la base de datos
require 'conexion.php';

/*
--------------------------------------------------
 FUNCIÓN: getLibros
 Obtiene todos los libros o filtra por categoría
--------------------------------------------------
 $db → conexión MySQL
 $id_categoria → opcional, filtra libros por categoría
*/
function getLibros($db, $id_categoria = null) {

    // Consulta base: libros + nombre de la categoría
    $sql = "SELECT l.*, c.nombre AS categoria 
            FROM libros l 
            LEFT JOIN categorias c ON l.id_categoria = c.id_categoria";
    
    // Si se recibe una categoría, añadimos filtro WHERE
    if ($id_categoria) {
        // intval para evitar inyección SQL
        $sql .= " WHERE l.id_categoria = " . intval($id_categoria);
    }

    // Ejecutamos la consulta
    $result = mysqli_query($db, $sql);

    // Array donde guardaremos los libros
    $libros = [];

    // Si hay resultados, los recorremos
    if ($result && mysqli_num_rows($result) > 0) {
        while($libro = mysqli_fetch_assoc($result)) {
            // Añadimos cada libro al array
            $libros[] = $libro;
        }
    }

    // Devolvemos el array de libros
    return $libros;
}

/*
--------------------------------------------------
 FUNCIÓN: getCategorias
 Obtiene todas las categorías
--------------------------------------------------
*/
function getCategorias($db) {

    // Consulta para obtener todas las categorías
    $sql = "SELECT * FROM categorias";
    $result = mysqli_query($db, $sql);

    // Array donde guardamos las categorías
    $categorias = [];

    // Si hay resultados, los recorremos
    if ($result && mysqli_num_rows($result) > 0) {
        while($cat = mysqli_fetch_assoc($result)) {
            $categorias[] = $cat;
        }
    }

    // Devolvemos las categorías
    return $categorias;
}

/*
--------------------------------------------------
 FUNCIÓN: guardarNuevoUsuario
 Registra un nuevo usuario en la base de datos
--------------------------------------------------
 $nombre, $email, $password → datos del formulario
*/
function guardarNuevoUsuario($nombre, $email, $password, $db){

	// CIFRAR CONTRASEÑA
	// PASSWORD_BCRYPT → algoritmo seguro
	// cost => 4 → nivel de complejidad del cifrado
	$password_segura = password_hash(
        $password,
        PASSWORD_BCRYPT,
        ['cost'=>4]
    );

	// password_verify se usa normalmente en el LOGIN,
    // aquí no es necesario, pero sirve para comprobar
	password_verify($password, $password_segura);

	// Consulta INSERT para guardar el usuario
	$sqlInsert = "INSERT INTO usuarios (nombre_usuario, email, password, is_admin) 
              VALUES ('$nombre','$email', '$password_segura', 0)";

	// Ejecutamos la consulta
	$query = mysqli_query($db, $sqlInsert);

	// Guardamos el resultado del registro en sesión
	if($query){
		$_SESSION['registro'] = true;
	}else{
		$_SESSION['registro'] = false;
	}

	// Devolvemos true o false
	return $_SESSION['registro'];
}

/*
--------------------------------------------------
 FUNCIÓN: getUsers
 Obtiene todos los usuarios (para login o admin)
--------------------------------------------------
*/
function getUsers($db){

	// Consulta para obtener usuarios
	$sql = "SELECT id_usuario, nombre_usuario, email, password, is_admin 
            FROM usuarios;";

	$usuarios = mysqli_query($db, $sql);

	// Array resultado
	$resultado = array();

	// Si hay usuarios, los guardamos en el array
	if($usuarios && mysqli_num_rows($usuarios) >=1){
		while($user = mysqli_fetch_assoc($usuarios)){
			array_push($resultado, $user);
		}
	}

	// Devolvemos todos los usuarios
	return $resultado;
}

function crearResena($db, $id_usuario, $id_libro, $puntuacion, $comentario){

    $puntuacion = intval($puntuacion);
    $comentario = mysqli_real_escape_string($db, $comentario);

    if($puntuacion < 0 || $puntuacion > 5){
        return false;
    }

    $sql = "INSERT INTO resenas (id_usuario, id_libro, puntuacion, comentario)
            VALUES ($id_usuario, $id_libro, $puntuacion, '$comentario')";

    return mysqli_query($db, $sql);
}

function getResenasLibro($db, $id_libro){

    $sql = "SELECT r.*, u.nombre_usuario
            FROM resenas r
            JOIN usuarios u ON r.id_usuario = u.id_usuario
            WHERE r.id_libro = $id_libro
            ORDER BY r.fecha DESC";

    $res = mysqli_query($db, $sql);

    $resenas = [];

    if($res && mysqli_num_rows($res) > 0){
        while($row = mysqli_fetch_assoc($res)){
            $resenas[] = $row;
        }
    }

    return $resenas;
}
?>
