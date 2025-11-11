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
            ["nombre" => "Ejercicio 1", "descripcion" => "Página HTML básica", "enlace" => "#"],
            ["nombre" => "Ejercicio 2", "descripcion" => "Formulario de contacto", "enlace" => "#"],
            ["nombre" => "Ejercicio 3", "descripcion" => "Lectura de archivos con PHP", "enlace" => "#"]
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
