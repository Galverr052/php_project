<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tabla de números del 1 al 10</title>
    <style>
        table {
            border-collapse: collapse; /* Colapsa los bordes de la tabla y las celdas */
        }
        td {
            border: 1px solid black; /* Aplica un borde de 1px a cada celda */
            padding: 8px; /* Opcional: añade un poco de espacio interior a las celdas */
            text-align: center;
        }
    </style>
</head>
<body>

<?php
    echo "<table>"; // Inicia la tabla
    
    // Bucle para generar 10 filas (<tr>)
    for ($i = 1; $i <= 10; $i++) {
        echo "<tr>";
        
        // Bucle para generar 10 celdas (<td>) en cada fila
        for ($j = 1; $j <= 10; $j++) {
            $numero = ($i - 1) * 10 + $j; // Calcula el número secuencial
            echo "<td>" . $numero . "</td>";
        }
        
        echo "</tr>";
    }
    
    echo "</table>"; // Cierra la tabla
?>

</body>
</html>