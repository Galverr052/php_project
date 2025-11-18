<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario en PHP</title>
</head>
<body>

    <h2>Formulario</h2>

    <form method="post">
        Nombre: <input type="text" name="nombre" required><br><br>
        Edad: <input type="number" name="edad" required><br><br>
        <input type="submit" value="Enviar">
    </form>

    <hr>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST["nombre"];
        $edad = intval($_POST["edad"]);

        echo "<h3>Hola, $nombre.</h3>";

        if ($edad >= 18) {
            echo "<p>Eres mayor de edad.</p>";
        } else {
            echo "<p>No eres mayor de edad.</p>";
        }
    }
    ?>

</body>
</html>
