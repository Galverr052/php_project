<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: formulario.php");
    exit;
}


$nombre         = trim($_POST['nombre'] ?? '');
$apellido       = trim($_POST['apellido'] ?? '');
$email          = trim($_POST['email'] ?? '');
$pais           = $_POST['pais'] ?? '';
$intereses      = $_POST['intereses'] ?? [];
$curso          = $_POST['curso'] ?? '';
$preferencias   = $_POST['preferencias'] ?? [];


$errores = [];

if ($nombre === "")            $errores[] = "El nombre no puede estar vacío.";
if ($apellido === "")          $errores[] = "El apellido no puede estar vacío.";

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El email no es válido.";
}

if ($pais === "")              $errores[] = "Debe seleccionar un país.";
if (count($intereses) == 0)    $errores[] = "Debe seleccionar al menos un interés.";
if ($curso === "")             $errores[] = "Debe seleccionar un curso.";
if (count($preferencias) == 0) $errores[] = "Debe seleccionar al menos una preferencia.";

if (!empty($errores)) {

    $_SESSION['nombre']       = $nombre;
    $_SESSION['apellido']     = $apellido;
    $_SESSION['email']        = $email;
    $_SESSION['pais']         = $pais;
    $_SESSION['intereses']    = $intereses;
    $_SESSION['curso']        = $curso;
    $_SESSION['preferencias'] = $preferencias;
    $_SESSION['errores']      = $errores;

    header("Location: formulario.php");
    exit;
}

$_SESSION['nombre']       = $nombre;
$_SESSION['apellido']     = $apellido;
$_SESSION['email']        = $email;
$_SESSION['pais']         = $pais;
$_SESSION['intereses']    = $intereses;
$_SESSION['curso']        = $curso;
$_SESSION['preferencias'] = $preferencias;


$totalIntereses = count($intereses);
$totalPreferencias = count($preferencias);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100 p-8">

    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-xl p-6">
        
        <h1 class="text-3xl font-bold mb-4 text-blue-700">
            ¡Bienvenido, <?= htmlspecialchars($nombre) ?>!
        </h1>

        <h2 class="text-xl font-semibold mb-3">Resumen de tus datos</h2>

        <ul class="list-disc pl-6 space-y-1">
            <li><strong>Nombre:</strong> <?= htmlspecialchars($nombre) ?></li>
            <li><strong>Apellido:</strong> <?= htmlspecialchars($apellido) ?></li>
            <li><strong>Email:</strong> <?= htmlspecialchars($email) ?></li>
            <li><strong>País:</strong> <?= htmlspecialchars($pais) ?></li>
            <li><strong>Curso:</strong> <?= htmlspecialchars($curso) ?></li>
            <li>
                <strong>Intereses:</strong> 
                <?= implode(", ", array_map("htmlspecialchars", $intereses)) ?>
                (<?= $totalIntereses ?> seleccionados)
            </li>
            <li>
                <strong>Preferencias:</strong> 
                <?= implode(", ", array_map("htmlspecialchars", $preferencias)) ?>
                (<?= $totalPreferencias ?> seleccionadas)
            </li>
        </ul>

        <div class="mt-6">
            <a href="formuariosesion.php" 
               class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                Volver al formulario
            </a>
        </div>

    </div>

</body>
</html>
