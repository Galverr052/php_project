<?php
    echo "<h1 style='text-align:center;'>Pagina principal de 2DAM</h1>";
$alumnos = [
    ["nombre" => "Ana", "edad" => 17, "curso" => "2DAM", "promedio" => 9.1],
    ["nombre" => "Luis", "edad" => 18, "curso" => "4°ESO", "promedio" => 4.5],
    ["nombre" => "Marta", "edad" => 17, "curso" => "1DAW", "promedio" => 8.3],
    ["nombre" => "Manuel", "edad" => 18, "curso" => "2DAM", "promedio" => 6.7],
    ["nombre" => "Paula", "edad" => 16, "curso" => "1DAW", "promedio" => 7.2]
];

$aprobados = 0;
$suspendidos = 0;

echo "<style>
        table { border-collapse: collapse; width: 60%; margin: 20px auto; }
        th, td { border: 1px solid #999; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .destacado { font-weight: bold; color: black; }
      </style>";

echo "<table>";
echo "<tr><th>Nombre</th><th>Edad</th><th>Curso</th><th>Promedio</th></tr>";

foreach ($alumnos as $alumno) {
    $clase = ($alumno["promedio"] >= 8) ? "destacado" : "";
    echo "<tr class='$clase'>";
    echo "<td>{$alumno['nombre']}</td>";
    echo "<td>{$alumno['edad']}</td>";
    echo "<td>{$alumno['curso']}</td>";
    echo "<td>{$alumno['promedio']}</td>";
    echo "</tr>";

    if ($alumno["promedio"] >= 5) {
        $aprobados++;
    } else {
        $suspendidos++;
    }
}

echo "</table>";

echo "<h3 style='text-align:center;'>Resumen de las notas</h3>";
echo "<p style='text-align:center;'>Total Aprobados: <strong>$aprobados</strong></p>";
echo "<p style='text-align:center;'>Total de alumnos suspendidos: <strong>$suspendidos</strong></p>";
?>
