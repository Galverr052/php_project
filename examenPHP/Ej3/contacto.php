<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contacto</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <?php include("includes/menu.php"); ?>

    <main class="max-w-md mx-auto p-6">
        <h2 class="text-2xl font-semibold mb-6 text-center">Sube una Imagen</h2>

        <form action="" method="post" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6 space-y-4">
            <div>
                <label for="archivo" class="block text-sm font-medium mb-2">Selecciona una imagen</label>
                <input type="file" name="archivo" id="archivo" accept="image/*" required
                       class="w-full border p-2 rounded">
            </div>
            <button type="submit" name="subir"
                    class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                Subir Imagen
            </button>
        </form>

        <div class="mt-6">
            <?php
            if (isset($_POST['subir'])) {
                $dir_subida = "uploads/";
                $archivo = $dir_subida . basename($_FILES["archivo"]["name"]);
                $tipo = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
                $permitidos = ["jpg", "jpeg", "png", "gif"];

                if (in_array($tipo, $permitidos)) {
                    if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo)) {
                        echo "<p class='text-green-600 font-semibold mt-4'> ✓Imagen subida correctamente: 
                              <a href='$archivo' class='text-blue-500 underline'>Ver imagen</a></p>";
                    } else {
                        echo "<p class='text-red-600 mt-4'> Error al subir la imagen.</p>";
                    }
                } else {
                    echo "<p class='text-red-600 mt-4'> Solo se permiten archivos JPG, PNG o GIF.</p>";
                }
            }
            ?>
        </div>
    </main>

    <?php include("includes/footer.php"); ?>

</body>
</html>
