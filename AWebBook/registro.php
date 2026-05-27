<?php
/*
====================================================
 ARCHIVO: registro.php
 FUNCIÓN:
 Registro de nuevos usuarios en la aplicación
====================================================

Este archivo:
- Muestra el formulario de registro
- Valida los datos del usuario
- Inserta el usuario en la base de datos
- Redirige al login si el registro es correcto
*/
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Configuración básica del documento -->
    <meta charset="UTF-8">

    <!-- Diseño responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Título de la página -->
    <title>Registro de usuarios</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<?php
/*
--------------------------------------------------
 PROCESO DE REGISTRO
--------------------------------------------------
 Solo se ejecuta si el usuario ha enviado el formulario
 mediante el botón "Registrarme"
*/
if (isset($_POST["registro"])) {

    // Incluimos el archivo data.php donde está la conexión
    // a la base de datos y las funciones necesarias
    require './includes/data.php';

    /*
    --------------------------------------------------
     RECOGIDA DE DATOS DEL FORMULARIO
    --------------------------------------------------
    Usamos operador ternario para evitar errores
    */
    $nombre   = isset($_POST["username"]) ? $_POST["username"] : false;
    $email    = isset($_POST["email"]) ? $_POST["email"] : false;
    $password = isset($_POST["password"]) ? $_POST["password"] : false;

    /*
    --------------------------------------------------
     VALIDACIÓN DE DATOS
    --------------------------------------------------
    Creamos un array para guardar errores
    */
    $errores = [];

    // Validar nombre:
    // - No vacío
    // - No numérico
    // - No contiene números
    if (!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)) {
        $nombre_validate = true;
    } else {
        $nombre_validate = false;
        $errores["nombre"] = "El nombre no es correcto";
    }

    // Validar email con filtro de PHP
    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_validate = true;
    } else {
        $email_validate = false;
        $errores["email"] = "El email no es correcto";
    }

    // Validar contraseña (no vacía)
    if (!empty($password)) {
        $password_validate = true;
    } else {
        $password_validate = false;
        $errores["password"] = "La contraseña no puede estar vacía";
    }

    /*
    --------------------------------------------------
     INSERCIÓN EN BASE DE DATOS
    --------------------------------------------------
    Solo se insertan los datos si no hay errores
    */
    if (count($errores) == 0) {

        // Llamamos a la función que guarda el usuario
        // (la contraseña se cifra dentro de la función)
        $check_registro = guardarNuevoUsuario($nombre, $email, $password, $db);

        // Si el registro es correcto, redirigimos al login
        if ($check_registro) {
            header("Location: login.php");
            exit();
        }

    } else {
        // Mensaje de error si la validación falla
        echo "<div class='alert alert-danger' role='alert'>
                Datos de registro incorrectos.
              </div>";
    }
}
?>

<body>

    <!--
    --------------------------------------------------
     FORMULARIO DE REGISTRO
    --------------------------------------------------
    -->
    <div class="container mt-5">

        <h1 class="text-center mb-4">Registro</h1>

        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card p-4 shadow-sm">

                    <!-- Formulario de registro -->
                    <form action="" method="POST">

                        <!-- Nombre de usuario -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Nombre de Usuario</label>
                            <input type="text"
                                   class="form-control"
                                   id="username"
                                   name="username"
                                   placeholder="Introduce tu nombre de usuario"
                                   required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text"
                                   class="form-control"
                                   id="email"
                                   name="email"
                                   placeholder="Introduce tu correo electrónico"
                                   required>
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password"
                                   class="form-control"
                                   id="password"
                                   name="password"
                                   placeholder="Introduce tu contraseña"
                                   required>
                        </div>

                        <!-- Botón de registro -->
                        <button name="registro"
                                type="submit"
                                class="btn btn-primary w-100">
                            Registrarme
                        </button>

                    </form>

                    <!-- Botón para ir al login -->
                    <form action="login.php" method="POST" class="d-flex justify-content-center m-2">
                        <button type="submit" class="btn btn-warning">
                            Iniciar sesión
                        </button>
                    </form>

                </div>

            </div>
        </div>

    </div>

</body>
</html>
