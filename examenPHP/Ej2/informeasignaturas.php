<?php
    echo "<h1 style='text-align:center;'>Pagina principal de 2DAM</h1>";
$alumnos = [
    ["Nombre" => "Laura_Martinez", "Asignaturas" => "PSP", "PROYECTO", "ACCESO A DATOS"],
    ["Nombre" => "Carlos_Gomez", "Asignaturas" => "OPTATIVA", "PSP", "PROGRAMACIÓN MULTIMEDIA"],
    ["Nombre" => "Ana_Sanchez", "Asignaturas" =>"PROGRAMACIÓN MULTIMEDIA", "PROYECTO", "ACCESO A DATOS", "OPTATIVA"],
    ["Nombre" => "David_Rodriguez", "Asignaturas" =>"PSP", "ACCESO A DATOS", "OPTATIVA"],
    ["Nombre" => "Maria_Lopez", "Asignaturas" =>"PROGRAMACIÓN MULTIMEDIA", "PROYECTO", "ACCESO A DATOS", "OPTATIVA"],
    ["Nombre" => "German_Alvarenga", "Asignaturas" =>"PROYECTO", "PROGRAMACIÓN MULTIMEDIA", "PSP"],
];

 foreach ($alumnos as $a): ?>
        <tr class="border-b hover:bg-gray-50">
            <td class="p-3">Alumno: <?= $a['Nombre'] ?></td>
            <td class="p-3"><?= $a['Asignatura'] ?></td>
        </tr>
<?php endforeach; ?>