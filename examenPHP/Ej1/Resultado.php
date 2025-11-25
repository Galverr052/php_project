<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: Formulario.php");
    exit;
}

$color           = $_POST['color'] ?? '';
$number          = trim($_POST['number'] ?? '');
$directorio        = $_POST['imagenes'] ?? [''];


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>

<body class="bg-<?= htmlspecialchars($color)?>-500 p-8">

    <div class="max-w-2xl mx-auto shadow-md rounded-xl p-6">
        <h1 class="text-3xl font-bold mb-4 text-black">
            Mostrando <?= htmlspecialchars($number) ?> imagenes desde el directorio: 
        </h1>
         <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php
            $dir = "img1/";
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
        <div class="mt-6">
            <a href="Formulario.php" 
               class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                Volver al formulario
            </a>
        </div>

    </div>

</body>
</html>