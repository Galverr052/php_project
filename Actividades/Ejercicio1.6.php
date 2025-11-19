<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nota Aleatoria</title>
</head>
<body>

<?php
// Generamos un número aleatorio entre 1 y 10
$nota = rand(1, 10);

echo "<h2>Nota obtenida: $nota</h2>";

if ($nota < 5) {
    echo "<p>Calificación: <strong>Insuficiente</strong></p>";
} elseif ($nota < 6) {
    echo "<p>Calificación: <strong>Suficiente</strong></p>";
} elseif ($nota < 7) {
    echo "<p>Calificación: <strong>Bien</strong></p>";
} elseif ($nota < 9) {
    echo "<p>Calificación: <strong>Notable</strong></p>";
} else {
    echo "<p>Calificación: <strong>Sobresaliente</strong></p>";
}
?>

</body>
</html>
