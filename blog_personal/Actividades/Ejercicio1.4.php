<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Calcular Salario Neto</title>
</head>
<body>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bruto = $_POST['bruto'] ?? 0;
    $retencion = $_POST['retencion'] ?? 0;

    // Convertimos la retención a porcentaje y calculamos el neto
    if (is_numeric($bruto) && is_numeric($retencion)) {
        $neto = $bruto - ($bruto * ($retencion / 100));

        echo "<h2>Resultado</h2>";
        echo "<p>Salario bruto: $bruto €</p>";
        echo "<p>Retención aplicada: $retencion %</p>";
        echo "<p><strong>Salario neto: $neto €</strong></p>";
    } else {
        echo "<p>Por favor, introduce datos válidos.</p>";
    }

    echo "<br><a href=''>Volver</a>";
} else {
?>

<h2>Calculadora de Salario Neto</h2>
<form method="POST" action="">
    <label>Salario bruto mensual (€):</label><br>
    <input type="number" name="bruto" step="0.01" required><br><br>

    <label>Retención (%):</label><br>
    <input type="number" name="retencion" step="0.01" required><br><br>

    <input type="submit" value="Calcular">
</form>

<?php
}
?>

</body>
</html>
