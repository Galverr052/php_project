<?php
require './includes/data.php';
require './includes/header.php';

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Obtener tarea a editar
$tarea_editar = [];

if (isset($_POST['tarea_id'])) {
    $id_tarea = $_POST['tarea_id'];
    $tarea_editar = getTareas($db, null, $id_tarea);

    // Si no existe la tarea
    if (empty($tarea_editar)) {
        header('Location: index.php');
        exit();
    }

    // Seguridad: comprobar que la tarea es del usuario
    if ($tarea_editar[0]['usuario_id'] != $_SESSION['id_user']) {
        header('Location: index.php');
        exit();
    }

} else {
    header('Location: index.php');
    exit();
}

// Guardar cambios
if (isset($_POST['guardarCambios'])) {

    $id_tarea = $_POST['id_tarea'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha_entrega = $_POST['fecha_entrega'];
    $estado = $_POST['estado'];
    $id_user = $_SESSION['id_user'];

    $check = guardarCambiosTarea(
        $db,
        $id_tarea,
        $titulo,
        $descripcion,
        $fecha_entrega,
        $estado,
        $id_user
    );

    if ($check) {
        header('Location: index.php');
        exit();
    }
}
?>

<body>
    <div class="d-flex justify-content-end m-2">
        <form action="index.php" method="post"> 
            <button type="submit" class="btn btn-secondary">Cancelar</button>
        </form>
    </div>

    <form method="post" class="p-3 border rounded shadow bg-white">
        <input type="hidden" name="id_tarea" value="<?= $tarea_editar[0]['id']; ?>">

        <!-- Título -->
        <div class="mb-3">
            <label class="form-label fw-bold">Título</label>
            <input type="text" class="form-control form-control-lg"
                   name="titulo"
                   value="<?= $tarea_editar[0]['titulo']; ?>"
                   required>
        </div>

        <!-- Descripción -->
        <div class="mb-3">
            <label class="form-label fw-bold">Descripción</label>
            <textarea class="form-control form-control-lg"
                      name="descripcion"
                      rows="4"
                      required><?= $tarea_editar[0]['descripcion']; ?></textarea>
        </div>

        <!-- Fecha -->
        <div class="mb-3">
            <label class="form-label fw-bold">Fecha de Entrega</label>
            <input type="date"
                   class="form-control form-control-lg"
                   name="fecha_entrega"
                   value="<?= $tarea_editar[0]['fecha_entrega']; ?>"
                   required>
        </div>

        <!-- Estado -->
        <div class="mb-3">
            <label class="form-label fw-bold">Estado</label>
            <select class="form-select form-select-lg" name="estado" required>
                <option value="to_do" <?= $tarea_editar[0]['estado']=='to_do'?'selected':''; ?>>Pendiente</option>
                <option value="doing" <?= $tarea_editar[0]['estado']=='doing'?'selected':''; ?>>En progreso</option>
                <option value="done" <?= $tarea_editar[0]['estado']=='done'?'selected':''; ?>>Completada</option>
            </select>
        </div>

        <button type="submit" name="guardarCambios" class="btn btn-primary">
            Guardar Cambios
        </button>
    </form>
</body>
