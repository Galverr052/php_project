<?php
// 1️⃣ Definimos el array asociativo con los alumnos y sus asignaturas
$alumnos = [
    "Laura_Martinez" => ["PSP", "PROYECTO", "ACCESO A DATOS"],
    "Carlos_Gomez" => ["OPTATIVA", "PSP", "PROGRAMACIÓN MULTIMEDIA"],
    "Ana_Sanchez" => ["PROGRAMACIÓN MULTIMEDIA", "PROYECTO", "ACCESO A DATOS", "OPTATIVA"],
    "David_Rodriguez" => ["PSP", "ACCESO A DATOS", "OPTATIVA"],
    "Maria_Lopez" => ["PROYECTO", "PROGRAMACIÓN MULTIMEDIA", "PSP"],
    // ✅ Aquí pones tu nombre y tus asignaturas
    "Tu_Nombre" => ["PSP", "OPTATIVA", "PROYECTO"]
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe de Asignaturas</title>
    <style>
        .alumno {
            border: 1px solid #333; /* borde del bloque */
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <h1>Informe de Asignaturas de 2DAM</h1>

    <?php
    // 2️⃣ Recorremos el array de alumnos
    foreach ($alumnos as $nombre => $asignaturas) {
        echo "<div class='alumno'>"; // bloque separado para cada alumno
        echo "<h2>Alumno: $nombre</h2>";
        echo "<ul>"; 
        foreach ($asignaturas as $asignatura) {
            echo "<li>$asignatura</li>";
        }
        echo "</ul>";
        echo "</div>";
    }
    ?>
</body>
</html>
