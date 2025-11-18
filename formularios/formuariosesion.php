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
    <h1 class="text-3xl font-bold mb-6 text-center">Formulario con Sesión</h1>

    <div class="max-w-3xl mx-auto bg-white shadow-md p-6 rounded-xl">
        <form action="procesar.php" method="post" class="space-y-6">

            <!-- Nombre -->
            <div>
                <label class="block font-semibold mb-1">Nombre</label>
                <input type="text" 
                       name="nombre"
                       class="w-full border rounded p-2"
                       value="<?= $_SESSION['nombre'] ?? '' ?>">
            </div>

            <!-- Apellido -->
            <div>
                <label class="block font-semibold mb-1">Apellido</label>
                <input type="text" 
                       name="apellido"
                       class="w-full border rounded p-2"
                       value="<?= $_SESSION['apellido'] ?? '' ?>">
            </div>

            <!-- Email -->
            <div>
                <label class="block font-semibold mb-1">Email</label>
                <input type="email" 
                       name="email"
                       class="w-full border rounded p-2"
                       value="<?= $_SESSION['email'] ?? '' ?>">
            </div>

            <!-- País -->
            <div>
                <label class="block font-semibold mb-1">País</label>
                <?php $pais = $_SESSION['pais'] ?? ''; ?>

                <select name="pais" class="w-full border rounded p-2">
                    <option value="" disabled>Seleccione...</option>
                    <option value="españa" <?= $pais=="españa"?"selected":"" ?>>España</option>
                    <option value="portugal" <?= $pais=="portugal"?"selected":"" ?>>Portugal</option>
                    <option value="francia" <?= $pais=="francia"?"selected":"" ?>>Francia</option>
                </select>
            </div>

            <!-- Intereses -->
            <div>
                <label class="block font-semibold mb-1">Intereses</label>
                <?php $intereses = $_SESSION['intereses'] ?? []; ?>

                <select 
                    name="intereses[]" 
                    multiple 
                    class="w-full border rounded p-2 h-32"
                >
                    <option value="futbol" <?= in_array("futbol",$intereses)?"selected":"" ?>>Fútbol</option>
                    <option value="pintura" <?= in_array("pintura",$intereses)?"selected":"" ?>>Pintura</option>
                    <option value="cocinar" <?= in_array("cocinar",$intereses)?"selected":"" ?>>Cocinar</option>
                    <option value="musica" <?= in_array("musica",$intereses)?"selected":"" ?>>Música</option>
                </select>
            </div>

            <!-- Curso (radio) -->
            <div>
                <label class="block font-semibold mb-1">Curso</label>
                <?php $curso = $_SESSION['curso'] ?? ''; ?>

                <label><input type="radio" name="curso" value="1DAM" <?= $curso=="1DAM"?"checked":"" ?>> 1º DAM</label><br>
                <label><input type="radio" name="curso" value="2DAM" <?= $curso=="2DAM"?"checked":"" ?>> 2º DAM</label>
            </div>

            <!-- Preferencias (checkbox) -->
            <div>
                <label class="block font-semibold mb-1">Preferencias</label>
                <?php $pref = $_SESSION['preferencias'] ?? []; ?>

                <label><input type="checkbox" name="preferencias[]" value="Noticias" <?= in_array("Noticias",$pref)?"checked":"" ?>> Noticias</label><br>
                <label><input type="checkbox" name="preferencias[]" value="Promociones" <?= in_array("Promociones",$pref)?"checked":"" ?>> Promociones</label><br>
                <label><input type="checkbox" name="preferencias[]" value="Actualizaciones" <?= in_array("Actualizaciones",$pref)?"checked":"" ?>> Actualizaciones</label><br>
                <label><input type="checkbox" name="preferencias[]" value="Eventos" <?= in_array("Eventos",$pref)?"checked":"" ?>> Eventos</label>
            </div>

            <!-- Botones -->
            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded">
                    Enviar
                </button>
                <button type="reset" class="bg-gray-400 text-white py-2 px-4 rounded">
                    Limpiar
                </button>
            </div>

        </form>
    </div>
</body>
</html>
