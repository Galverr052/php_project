<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Formulario Edad</title>
</head>
<body>

<?php
// Si ya enviaron el formulario:
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"] ?? "";
    $edad = $_POST["edad"] ?? "";

    echo "<h2>Hola, $nombre.</h2>";

    if (is_numeric($edad)) {
        if ($edad >= 18) {
            echo "<p>Eres mayor de edad.</p>";
        } else {
            echo "<p>Eres menor de edad.</p>";
        }
    } else {
        echo "<p>La edad introducida no es válida.</p>";
    }

    echo "<br><a href='edad.php'>Volver</a>";
} else {
    // Mostrar el formulario
    ?>

    <form method="POST" action="">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Edad:</label><br>
        <input type="number" name="edad" required><br><br>

        <input type="submit" value="Enviar">
    </form>

<?php
}
?>

</body>
</html>
