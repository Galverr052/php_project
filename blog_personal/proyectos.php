<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Proyectos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <?php include("includes/menu.php"); ?>

    <main class="max-w-3xl mx-auto p-6">
        <h2 class="text-2xl font-semibold mb-4 text-center">Mis Proyectos</h2>

        <?php
        $proyectos = [
            ["nombre" => "Ejercicio 1", "descripcion" => "Una página web que muestre la fecha actual en castellano.", "enlace" => "\php_project\blog_personal\Actividades\Ejercicio1.1.php"],
            ["nombre" => "Ejercicio 2", "descripcion" => "Tabla de 10 por 10 con los números del 1 al 100 ", "enlace" => "\php_project\blog_personal\Actividades\Ejercicio1.2.php"],
            ["nombre" => "Ejercicio 3", "descripcion" => "Formulario que recibe nombre y edad y muestra si el usuario es mayor o menor de edad.", "enlace" => "\php_project\blog_personal\Actividades\Ejercicio1.3.php"],
            ["nombre" => "Ejercicio 4", "descripcion" => "Formulario que calcula el salario neto a partir del salario bruto y el porcentaje de retención.", "enlace" => "\php_project\blog_personal\Actividades\Ejercicio1.4.php"],
            ["nombre" => "Ejercicio 5", "descripcion" => "Formulario que indica si un número introducido es positivo, negativo o cero.", "enlace" => "\php_project\blog_personal\Actividades\Ejercicio1.5.php"],
            ["nombre" => "Ejercicio 6", "descripcion" => "Script que genera una nota aleatoria entre 1 y 10 y muestra la calificación correspondiente.", "enlace" => "\php_project\blog_personal\Actividades\Ejercicio1.6.php"],
            ["nombre" => "Ejercicio 7", "descripcion" => "Formulario que muestra un texto en etiquetas HTML h1 a h6 usando un bucle for.", "enlace" => "\php_project\blog_personal\Actividades\Ejercicio1.7.php"]
        ];
        ?>

        <table class="w-full border-collapse bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="p-3 text-left">Nombre</th>
                    <th class="p-3 text-left">Descripción</th>
                    <th class="p-3 text-left">Enlace</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($proyectos as $p): ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3"><?= $p['nombre'] ?></td>
                        <td class="p-3"><?= $p['descripcion'] ?></td>
                        <td class="p-3"><a href="<?= $p['enlace'] ?>" class="text-blue-500 hover:underline">Ver</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <?php include("includes/footer.php"); ?>

</body>
</html>
