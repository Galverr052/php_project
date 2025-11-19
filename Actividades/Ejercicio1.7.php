<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Texto con encabezados</title>
</head>
<body>

<h2>2 DAM Optativa</h2>
<h3>Unidad 02: Programación en lenguaje PHP</h3>

<form method="POST" action="">
    <label>Texto:</label>
    <input type="text" name="texto" required>
    <br><br>
    <input type="submit" value="Enviar">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $texto = $_POST["texto"];

    // Dibujar el texto usando h1 a h6
    for ($i = 1; $i <= 6; $i++) {
        echo "<h$i>H$i - $texto</h$i>";
    }
}
?>

</body>
</html>
