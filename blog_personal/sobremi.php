<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sobre mí</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <?php include("includes/menu.php"); ?>

    <main class="max-w-5xl mx-auto p-6">
        <h2 class="text-3xl font-bold text-center mb-8">Sobre mí</h2>

        <?php
        // Array de hobbies
        $hobbies = [
            [
                "nombre" => "Musica",
                "descripcion" => "Actividad artística que consiste en aplicar pigmentos sobre una superficie para crear una obra.",
                "frecuencia" => "7 veces/sem",
                "imagen" => "img/musica.jpg"
            ],
            [
                "nombre" => "Fútbol",
                "descripcion" => "Un deporte de equipo donde dos equipos compiten por meter un balón en la portería del rival.",
                "frecuencia" => "3 veces/sem",
                "imagen" => "img/futbol.jpg"
            ],
            [
                "nombre" => "Cocinar",
                "descripcion" => "El arte de preparar y experimentar con alimentos para crear platos deliciosos.",
                "frecuencia" => "7 veces/sem",
                "imagen" => "img/cocina.jpg"
            ],
            [
                "nombre" => "Formula1",
                "descripcion" => "Máxima categoría del automovilismo mundial, una competición de monoplazas de alta tecnología que se disputa en una serie de carreras llamadas Grandes Premios en circuitos alrededor del mundo.",
                "frecuencia" => "3 veces/sem",
                "imagen" => "img/formula1.jpg"
            ],
            [
                "nombre" => "Programación",
                "descripcion" => "Proceso de crear un conjunto de instrucciones, también llamado código, para que una computadora pueda ejecutar una tarea específica.",
                "frecuencia" => "7 veces/sem",
                "imagen" => "img/dev.jpg"
            ]
        ];
        ?>

        <!-- Contenedor de tarjetas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <?php foreach ($hobbies as $hobbie): ?>
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                    <img src="<?= $hobbie['imagen'] ?>" alt="<?= $hobbie['nombre'] ?>" class="w-full h-48 object-cover">
                    <div class="p-4 space-y-2">
                        <h3 class="text-xl font-semibold text-gray-800"><?= $hobbie['nombre'] ?></h3>
                        <p class="text-gray-600 text-sm"><?= $hobbie['descripcion'] ?></p>
                        <span class="inline-block bg-green-100 text-green-700 text-xs font-medium px-3 py-1 rounded-full">
                            <?= $hobbie['frecuencia'] ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include("includes/footer.php"); ?>

</body>
</html>
