<?php 
require './includes/modelo.php';

$selectedC = $_GET['curso'] ?? null;

$cursos = getCursos($db);
$alumnos = getAlumnos($db, $selectedC);
?>


<form class="row mb-4" method="GET">
        <div class="col-md-4">
            <select name="curso" class="form-select">
                <option value="">Todos los cursos</option>

                <!-- Recorremos todas las categorías -->
                <?php foreach($cursos as $c): ?>
                    <option value="<?php echo $c['id_curso']; ?>"
                        <?php
                        // Mantiene la categoría seleccionada tras filtrar
                        if($selectedC == $c['id_curso']) echo 'selected';
                        ?>>
                        <?php echo htmlspecialchars($c['nivel']); ?>
                        <?php echo htmlspecialchars($c['abreviatura']); ?>
                    </option>
                <?php endforeach; ?>

            </select>  
            <button type="submit" class="btn btn-primary w-50 me-2">
                refrescar
            </button>
        </div>
          
</form>

<a href="añadir_alumno.php">Añadir alumno</a>
<div class="row">
    <style>
        table { border-collapse: collapse; width: 60%; margin: 20px auto; }
        th, td { border: 1px solid #999; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .destacado { font-weight: bold; color: black; }
      </style>
    <table>
        <tr><th>Nombre</th><th>Email</th><th>Mayor de edad</th><th>curso</h><th>acciones</th></tr>
            <?php foreach($alumnos as $alumno): ?>
             
                <td><?php echo htmlspecialchars($alumno['nombre']); ?></td>
                <td><?php echo htmlspecialchars($alumno['email']); ?></td>
                <td><?php
                if($alumno['isMayorEdad'] == 1){
                    echo "Si";
                } else{
                    echo "No";
                }
                ?></td>
                <td>
                    <?php foreach($cursos as $c): ?>
                    <?php if($alumno['curso'] == $c['id_curso']) //Aqui da error por querer encontrar el nombre del curso
                        echo htmlspecialchars($c['nombre']);?>
                    <?php endforeach; ?></td>
                <td><a href="editar.php">editar</a></td>
             </tr>
            <?php endforeach; ?>
            </table>
    </div>