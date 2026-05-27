<?php
/*
====================================================
 ARCHIVO: header.php
 FUNCIÓN:
 Cabecera común reutilizable de la aplicación
====================================================

Este archivo se incluye en otras páginas usando:
require 'header.php';

Se encarga de:
- Iniciar la sesión de forma segura
- Mostrar botón de login o logout según el estado
- Mostrar el logo y el título de la web
- Cargar Bootstrap
*/

// Iniciamos la sesión SOLO si no existe ya
// Evita errores de "session already started"
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Configuración básica del documento -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS (estilos y diseño responsive) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">

    <!-- Bootstrap JS + Popper (modales, dropdowns, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
            integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
            crossorigin="anonymous"></script>

    <!-- Título del navegador -->
    <title>Biblioteca Virtual</title>

    <!-- Estilos personalizados -->
    <style>
        .logo {
            width: 5rem;
            height: 5rem;
        }
    </style>

</head>

<body>

    <!-- Contenedor principal de la cabecera -->
    <div class="bg-warning-subtle">

        <!--
        BOTÓN DE SESIÓN DINÁMICO
        - Si el usuario está logueado → Cerrar sesión
        - Si NO está logueado → Iniciar sesión
        -->
        <form class="d-flex justify-content-end p-2"
              action="logout.php"
              method="post">

            <?php if (isset($_SESSION['usuario'])): ?>
                <!-- Usuario con sesión iniciada -->
                <button type="submit" class="btn btn-dark">
                    Cerrar sesión
                </button>
            <?php else: ?>
                <!-- Usuario sin sesión -->
                <a href="login.php" class="btn btn-dark">
                    Iniciar sesión
                </a>
            <?php endif; ?>

        </form>

        <!-- Cabecera visual con logo y título -->
        <header class="cabecera d-flex align-items-center justify-content-center p-4">

            <!-- Logo de la biblioteca -->
            <img src="./img/logo-biblio.png"
                 class="img-fluid logo me-2"
                 alt="Logo IES">

            <!-- Título principal -->
            <h1 class="titulo">
                Bienvenido a la Biblioteca Virtual
            </h1>

        </header>

    </div>
