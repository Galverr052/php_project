<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registro de usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<?php

//REGISTRO DEL USUARIO
if (isset($_POST["registro"])) {

    //Si le da a registrar incluimos nuestro data.
    require './includes/data.php';
    //Recoger los valores del formulario de registro
    $nombre = isset($_POST["username"]) ? $_POST["username"] : false;
    $email = isset($_POST["email"]) ? $_POST["email"] : false;
    $password = isset($_POST["password"]) ? $_POST["password"] : false;

   
    //Validar los datos antes de almacenarlos en la base de datos
     //Para almacenar los errores del formulario
     $errores = [];

     //Validar los datos antes de almacenarlos en la base de datos
     if (!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)) {
         $nombre_validate = true;
     } else {
         $nombre_validate = false;
         $errores["nombre"] = "El nombre no es correcto";
     }
 
     if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
         $email_validate = true;
     } else {
         $email_validate = false;
         $errores["email"] = "El email no es correcto";
     }
 
     if (!empty($password)) {
         $password_validate = true;
     } else {
         $password_validate = false;
         $errores["password"] = "La contraseña no puede estar vacía.";
     }
 

    if (count($errores) == 0) {
        //INSERTAR USUARIO EN LA TABLA DE USUARIOS DE LA BBDD
        
        $check_registro = guardarNuevoUsuario($nombre, $email, $password, $db);       
        if ($check_registro){
            header("Location: login.php");
        }
        
    } else {
        echo "<div class='alert alert-danger' role='alert'>Datos de registro incorrecto.</div>";
    }
    
}
?>

<body>
    <div class="container mt-5">

        <h1 class="text-center mb-4">Registro</h1>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4 shadow-sm">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Nombre de Usuario</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Introduce tu nombre de usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Introduce tu correo electrónico" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Introduce tu contraseña" required>
                        </div>
                        <button name="registro" type="submit" class="btn btn-primary w-100">Registrarme</button>

                    </form>
                    <form action="login.php" method="POST" class="d-flex justify-content-center m-2">
                        <button type="submit" class="btn btn-warning">Iniciar sesión</button>
                    </form>
                </div>

            </div>
        </div>


    </div>


</body>

</html>