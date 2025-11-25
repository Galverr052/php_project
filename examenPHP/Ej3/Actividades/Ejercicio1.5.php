<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Comprobar Número</title>
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $numero = $_POST["numero"] ?? "";

    if (is_numeric($numero)) {
        if ($numero > 0) {
            echo "<p>El número $numero es <strong>positivo</strong>.</p>";
        } elseif ($numero < 0) {
            echo "<p>El número $numero es <strong>negativo</strong>.</p>";
        } else {
            echo "<p>El número es <strong>cero</strong>.</p>";
        }
    } else {
        echo "<p>Por favor, introduce un número válido.</p>";
    }

    echo "<br><a href=''>Volver</a>";
} else {
?>

<h2>Introduce un número</h2>
<form method="POST" action="">
    <input type="text" name="numero" required>
    <br><br>
    <input type="submit" value="Enviar">
</form>

<?php
}
?>

</body>
</html>
