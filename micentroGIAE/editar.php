<?php 
require './includes/modelo.php';

$alumno_editar = [];

if (isset($_POST['tarea_id'])) {
    $id_tarea = $_POST['tarea_id'];
    $tarea_editar = getAlumnos($db, $id_tarea);

    if (empty($alumno_editar)) {
        header('Location: index.php');
        exit();
    }


    if ($alumno_editar[0]['usuario_id']) {
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}

?>