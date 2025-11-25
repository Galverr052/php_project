<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Formulario</title>
</head>

<body class="bg-gray-100 p-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Configuración de la visualización de imagenes</h1>
    <br>
    <div class="max-w-3xl mx-auto bg-white shadow-md p-6 rounded-xl">
        <form action="Resultado.php" method="post" class="space-y-6">

            <!-- Color -->
            <div>
                <label class="block font-semibold mb-1">Color de fondo:</label><br>
                <?php $pais = $_SESSION['color'] ?? ''; ?>

                <select name="color" class="w-full border rounded p-2">
                    <option value="" disabled>Seleccione color de fondo...</option>
                    <option value="red" <?= $pais=="red"?"selected":"" ?>>Rojo</option>
                    <option value="blue" <?= $pais=="blue"?"selected":"" ?>>Azul</option>
                    <option value="green" <?= $pais=="red"?"selected":"" ?>>Verde</option>
                </select>
            </div>
            <br>
            <!-- Numero de imagenes -->
            <div>
                <label class="block font-semibold mb-1">Número de imágenes a mostrar:</label><br>
                <input type="number" 
                       name="number"
                       class="w-fit border rounded p-2"
                       value="<?= $_SESSION['number'] ?? '' ?>">
            </div>
            <br>
            <!-- Directorios (checkbox) -->
            <div>
                <label class="block font-semibold mb-1">Elige el directorio de imágenes:</label>
                <?php $pref = $_SESSION['imagenes'] ?? []; ?><br>
                <label><input type="checkbox" name="imagenes[]" value="img1" <?= in_array("img1",$pref)?"checked":"" ?>> img1</label><br>
                <label><input type="checkbox" name="imagenes[]" value="img2" <?= in_array("img2",$pref)?"checked":"" ?>> img2</label><br>
            </div>
            <br>
            <!-- Boton -->
            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded">
                    Mostar imágenes
                </button>
            </div>
        </form>
    </div>
</body>
</html>
