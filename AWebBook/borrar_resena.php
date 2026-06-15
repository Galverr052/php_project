<?php
session_start();
require './includes/data.php';

if(!isset($_SESSION['usuario']) || $_SESSION['usuario']['is_admin'] != 1){
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

mysqli_query($db, "DELETE FROM resenas WHERE id_resena = $id");

header("Location: index.php");