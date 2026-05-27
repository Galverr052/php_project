<?php
require 'conexion.php';

function getAlumnos($db, $id_curso = null) {

    $sql = "SELECT a.*, a.nombre, a.email, a.isMayorEdad AS curso 
            FROM alumno a 
            LEFT JOIN curso c ON a.id_curso = c.id_curso";
    
    if ($id_curso) {
        $sql .= " WHERE a.id_curso = " . intval($id_curso);
    }

    $result = mysqli_query($db, $sql);

    $alumnos = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while($alumno = mysqli_fetch_assoc($result)) {
            $alumnos[] = $alumno;
        }
    }
    return $alumnos;
}

function getCursos($db) {

    // Consulta para obtener todos los cursos
    $sql = "SELECT * FROM curso";
    $result = mysqli_query($db, $sql);

    // Array donde guardamos los cursos
    $cursos = [];

    // Si hay resultados, los recorremos
    if ($result && mysqli_num_rows($result) > 0) {
        while($c = mysqli_fetch_assoc($result)) {
            $cursos[] = $c;
        }
    }

    // Devolvemos las cursos
    return $cursos;
}

function insertarAlumno($db, $id_alumno, $nombre, $email, $isMayorEdad,$id_curso)
{
	$check = false;

	$sqlInsert = "INSERT INTO alumno (id_alumno, nombre, email, isMayorEdad, id_curso)
		VALUES($id_alumno, '$nombre', '$email', '$isMayorEdad', '$id_curso')";
	$query = mysqli_query($db, $sqlInsert);

	if($query){
		$check = true;
	}
	return $check;
}
function guardarCambio($db, $id_alumno, $nombre, $email, $isMayorEdad,$id_curso){
	$check = false;

	$sqlInsert = "UPDATE alumno SET
	id_alumno = '$id_alumno',
	nombre, = '$nombre',
	email = '$email',
	isMayorEdad = '$isMayorEdad',
    id_curso = '$id_curso',
	WHERE id = $id_alumno";

	$query = mysqli_query($db, $sqlInsert);

	if($query){
		$check = true;
	}
	return $check;
}
?>