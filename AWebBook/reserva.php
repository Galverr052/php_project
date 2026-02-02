<?php
session_start();
require './includes/data.php';

// Verificar que el usuario esté logueado y NO sea admin
if(!isset($_SESSION['usuario']) || $_SESSION['usuario']['is_admin'] == 1){
    header("Location: index.php");
    exit;
}

// Obtener ID del libro
$id_libro = $_GET['id_libro'] ?? null;
if(!$id_libro){
    header("Location: index.php");
    exit;
}

// Obtener datos del libro
$sql = "SELECT * FROM libros WHERE id_libro = ".intval($id_libro);
$res = mysqli_query($db, $sql);
$libro = mysqli_fetch_assoc($res);

if(!$libro){
    header("Location: index.php");
    exit;
}

// Procesar reserva
if(isset($_POST['reservar'])){
    $fecha = $_POST['fecha'] ?? null;
    $userId = $_SESSION['usuario']['id_usuario'];

    // Insertar reserva
    $sqlInsert = "INSERT INTO reservas (id_usuario, id_libro, fecha_reserva) 
                  VALUES ($userId, $id_libro, ".($fecha ? "'$fecha'" : "NULL").")";
    mysqli_query($db, $sqlInsert);

    // Actualizar disponibilidad del libro
    $sqlUpdate = "UPDATE libros SET disponible = 0 WHERE id_libro = $id_libro";
    mysqli_query($db, $sqlUpdate);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva de Libro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Reserva de: <?php echo htmlspecialchars($libro['titulo']); ?></h2>
    <p><strong>Autor:</strong> <?php echo htmlspecialchars($libro['autor']); ?></p>
    <p><strong>Categoría:</strong> <?php echo htmlspecialchars($libro['id_categoria']); ?></p>

    <form method="POST">
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha de reserva (opcional)</label>
            <input type="date" name="fecha" id="fecha" class="form-control">
        </div>
        <button type="submit" name="reservar" class="btn btn-success">Confirmar Reserva</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
