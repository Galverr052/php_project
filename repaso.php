<?php

// Conexión a la base de datos
try {
    $db = new PDO("mysql:host=localhost;dbname=app_tareas", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error conexión DB: " . $e->getMessage());
}

session_start();

/* -------------------------
   SESIONES Y LOGIN
------------------------- */
function getUsers($db) {
    $stmt = $db->query("SELECT * FROM usuarios");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function checkUser($username, $password, $db) {
    $stmt = $db->prepare("SELECT * FROM usuarios WHERE username=?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = $user['is_admin']; // si hay admin
        return true;
    }
    return false;
}

function logout() {
    session_destroy();
    header("Location: index.php");
    exit();
}

/* -------------------------
   REGISTRO DE USUARIOS
------------------------- */
function guardarNuevoUsuario($db, $username, $password) {
    $pass_hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $db->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
    return $stmt->execute([$username, $pass_hashed]);
}

/* -------------------------
   GESTIÓN DE TAREAS
------------------------- */
// Obtener tareas (todas o de un usuario)
function getTareas($db, $user_id=null) {
    if ($user_id) {
        $stmt = $db->prepare("SELECT * FROM tareas WHERE user_id=?");
        $stmt->execute([$user_id]);
    } else {
        $stmt = $db->query("SELECT * FROM tareas");
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Insertar nueva tarea
function insertarTarea($db, $titulo, $descripcion, $fecha_entrega, $estado, $id_user) {
    $stmt = $db->prepare("INSERT INTO tareas (titulo, descripcion, fecha_entrega, estado, user_id) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$titulo, $descripcion, $fecha_entrega, $estado, $id_user]);
}

// Eliminar tarea
function eliminarTarea($db, $id_tarea) {
    $stmt = $db->prepare("DELETE FROM tareas WHERE id=?");
    return $stmt->execute([$id_tarea]);
}

// Guardar cambios tarea
function guardarCambiosTarea($db, $id_tarea, $titulo, $descripcion, $fecha_entrega, $estado, $id_user) {
    $stmt = $db->prepare("UPDATE tareas SET titulo=?, descripcion=?, fecha_entrega=?, estado=?, user_id=? WHERE id=?");
    return $stmt->execute([$titulo, $descripcion, $fecha_entrega, $estado, $id_user, $id_tarea]);
}

/* -------------------------
   LIBROS (UNIDAD 3)
------------------------- */
// Obtener libros (filtrado opcional por categoría)
function getLibros($db, $categoria=null) {
    if ($categoria) {
        $stmt = $db->prepare("SELECT * FROM libros WHERE categoria=?");
        $stmt->execute([$categoria]);
    } else {
        $stmt = $db->query("SELECT * FROM libros");
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Insertar nuevo libro
function registrarLibro($db, $titulo, $autor, $categoria) {
    $stmt = $db->prepare("INSERT INTO libros (titulo, autor, categoria) VALUES (?, ?, ?)");
    return $stmt->execute([$titulo, $autor, $categoria]);
}

// Eliminar libro (solo si no está reservado)
function eliminarLibro($db, $libro_id) {
    $stmt = $db->prepare("SELECT reservado FROM libros WHERE id=?");
    $stmt->execute([$libro_id]);
    $libro = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($libro && !$libro['reservado']) {
        $stmt = $db->prepare("DELETE FROM libros WHERE id=?");
        return $stmt->execute([$libro_id]);
    }
    return false;
}

// Reservar libro
function reservarLibro($db, $user_id, $libro_id, $fecha=null) {
    $stmt = $db->prepare("INSERT INTO reservas (user_id, libro_id, fecha) VALUES (?, ?, ?)");
    if ($stmt->execute([$user_id, $libro_id, $fecha])) {
        $stmt2 = $db->prepare("UPDATE libros SET reservado=1 WHERE id=?");
        $stmt2->execute([$libro_id]);
        return true;
    }
    return false;
}

// Listado de reservas (usuario o admin)
function getReservas($db, $user_id=null) {
    if ($user_id) {
        $stmt = $db->prepare("SELECT r.fecha, l.titulo FROM reservas r JOIN libros l ON r.libro_id = l.id WHERE r.user_id=?");
        $stmt->execute([$user_id]);
    } else {
        $stmt = $db->query("SELECT r.fecha, l.titulo, u.username, u.email FROM reservas r JOIN libros l ON r.libro_id=l.id JOIN usuarios u ON r.user_id=u.id");
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* -------------------------
   USO DE FUNCIONES EJEMPLO
------------------------- */
if (isset($_SESSION['username'])) {
    // Mostrar tareas del usuario logueado
    $tareas = getTareas($db, $_SESSION['user_id']);
    echo "<h3>Tus tareas:</h3>";
    foreach ($tareas as $t) {
        echo $t['titulo'] . " - " . $t['estado'] . "<br>";
    }
}
?>
