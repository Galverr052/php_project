<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <?php include("includes/menu.php"); ?>

    <main class="max-w-4xl mx-auto p-6">
        <h2 class="text-2xl font-semibold mb-6 text-center">MI GALERIA</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php
            $dir = "img/";
            $imagenes = scandir($dir);
            $ext_permitidas = ['jpg', 'jpeg', 'png', 'gif'];

            foreach ($imagenes as $img) {
                $extension = pathinfo($img, PATHINFO_EXTENSION);
                if (in_array(strtolower($extension), $ext_permitidas)) {
                    echo "<div class='border rounded-lg overflow-hidden shadow-sm'>
                            <img src='$dir$img' alt='$img' class='w-full h-40 object-cover'>
                          </div>";
                }
            }
            $dir = "uploads/";
            $imagenes = scandir($dir);
            $ext_permitidas = ['jpg', 'jpeg', 'png', 'gif'];

            foreach ($imagenes as $img) {
                $extension = pathinfo($img, PATHINFO_EXTENSION);
                if (in_array(strtolower($extension), $ext_permitidas)) {
                    echo "<div class='border rounded-lg overflow-hidden shadow-sm'>
                            <img src='$dir$img' alt='$img' class='w-full h-40 object-cover'>
                          </div>";
                }
            }
            ?>
        </div>
    </main>

    <?php include("includes/footer.php"); ?>

</body>
</html>
