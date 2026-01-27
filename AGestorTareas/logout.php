<?php
session_start();

// Vaciar variables de sesión
$_SESSION = [];

// Destruir la sesión
session_destroy();

// Volver al login
header("Location: login.php");
exit();
