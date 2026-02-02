<?php
session_start();
require './includes/data.php'; // Funciones de usuario, getUsers()

// Si ya hay sesión, redirige a index.php
if(isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$mensaje_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST["logout"]) && isset($_POST["username"])) {

    $array_usuarios = getUsers($db); // Devuelve todos los usuarios
    $username = $_POST["username"];
    $password = $_POST["password"];
    $usuario_valido = false;

    foreach ($array_usuarios as $user) {
        // Verificar credenciales
        if ($username == $user['email'] && password_verify($password, $user['password'])) {
            // Guardamos toda la info del usuario en $_SESSION['usuario']
            $_SESSION['usuario'] = [
                'id_usuario' => $user['id_usuario'],
                'nombre_usuario' => $user['nombre_usuario'],
                'email' => $user['email'],
                'is_admin' => $user['is_admin']
            ];

            // Redirigir a la página principal
            header("Location: index.php");
            exit();
        }
    }

    $mensaje_error = "Usuario o contraseña incorrectos.";
}

// Si viene del formulario logout (opcional)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Iniciar Sesión</h1>

        <?php if($mensaje_error): ?>
            <div class="alert alert-danger text-center"><?php echo $mensaje_error; ?></div>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4 shadow-sm">
                    <form action="login.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Email</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Introduce tu email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Introduce tu contraseña" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                    </form>
                    <form action="registro.php" method="POST" class="d-flex justify-content-center m-2">
                        <button type="submit" class="btn btn-warning">Registrarme</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
