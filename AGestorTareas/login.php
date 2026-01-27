<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Inicio de Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<?php
session_start();
require './includes/data.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST["logout"])&& isset($_POST["username"])) {

    $array_usuarios = getUsers($db);
    //session_start();

    $username = $_POST["username"];
    $password = $_POST["password"];

    $notFound = false;
    foreach ($array_usuarios as $user) {
        // Verificar credenciales
        if ($username == $user['email'] && password_verify($password, $user['contraseña'])) {
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            $_SESSION['id_user'] = $user['id'];

            // Redirigir a la página de alumnos matriculados
            header("Location: index.php");
            exit();
        }
    }
    if (!$notFound) {
        // Mostrar mensaje de error
        echo "<div class='alert alert-danger mt-4 text-center' role='alert'>Usuario o contraseña incorrectos</div>";
    }
} else  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"])) {

    $username = "";
    $password = "";

    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;

    session_destroy();
}
?>

<body>
    <div class="container mt-5">

        <h1 class="text-center mb-4">Iniciar Sesión</h1>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4 shadow-sm">
                    <form action="login.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Nombre de Usuario</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Introduce tu nombre de usuario" required>
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