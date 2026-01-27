<!--
1. Insertar nuevos datos, actualizar y eliminar.
2. Registro y login de usuario: hash de las contraseñas.
3. Relación del usuario con las tareas.
4. Buscador con BD
-->



<?php
require './includes/data.php';
require './includes/header.php';

//Verificar si el usuario está logueado, de lo contrario redirigir a login.php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$tareas_doing = [];
$tareas_toDo = [];
$tareas_done = [];
$resultado_tareas = getTareas($db, $_SESSION['id_user']);
foreach($resultado_tareas as $tarea) {
    if ($tarea['estado'] == 'done') {
        //$tareas_done[] = $tarea;
        array_push($tareas_done, $tarea);
    } else if ($tarea['estado'] == 'doing') {
        //$tareas_doing[] = $tarea;
        array_push($tareas_doing, $tarea);
    } else {
        //$tareas_toDo[] = $tarea;
        array_push($tareas_toDo, $tarea);
    }
}

//RECOGEMOS LA INFORMACIÓN DEL FORMULARIO PARA INSERTAR.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nuevaTarea'])) {
    $titulo = isset($_POST["titulo"]) ? $_POST["titulo"] : false;
    $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : false;
    $fecha_entrega = isset($_POST["fecha_entrega"]) ? $_POST["fecha_entrega"] : false;
    $estado=isset($_POST["estado"]) ? $_POST["estado"] : false;
    $id_user=$_SESSION['id_user'];

    $check_insertar= insertarTarea($db, $titulo, $descripcion, $fecha_entrega, $estado, $id_user);
    if($check_insertar){
        header('Location: index.php');
    }
}

//ELIMINAR TAREA
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_eliminar'])) {
    $tarea_id = $_POST['tarea_id'];
    $id_user = $_SESSION['id_user'];

    $check_eliminar = eliminarTarea($db, $tarea_id, $id_user);

    if ($check_eliminar) {
        header('Location: index.php');
        exit();
    }
}
?>

    <div class="container my-5">
        <div class="d-flex justify-content-end gap-2 m-2">
        <form action="logout.php" method="post">
            <button type="submit" class="btn btn-outline-danger">
                Cerrar sesión
            </button>
        </form>
    </div>

    <div class="d-flex justify-content-end m-2">
        <button type="button" class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#newTareaModal">
            Añadir tarea
            <svg class="text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="2"> <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path> <path d="M9 12h6"></path> <path d="M12 9v6"></path> </svg> 
        </button>
    </div>
    <div class="row">
        <!-- Columna de tareas to_do -->
        <div class="col-md-4">
            <h2 class="text-center bg-danger text-white p-2 rounded">TO DO</h2>
            <div class="card">
                <?php foreach ($tareas_toDo as $tarea): ?>
                    <div class="card border-danger mb-3">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <span>Entrega: <?= $tarea['fecha_entrega']; ?></span>
                            <form action="edit_tarea.php" method="post">
                                <input type="hidden" name="tarea_id" value="<?= $tarea['id']; ?>">
                                <button type="submit" class="btn" name="btn_modificar">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                        <path d="M16 5l3 3" />
                                    </svg>
                                </button>
                            </form>
                            <form action="" method="post"> 
                                <input type="hidden" name="tarea_id" value="<?= $tarea['id']; ?>">
                                <button type="submit" class="btn" name="btn_eliminar">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="2">
                                        <path d="M4 7l16 0"></path>
                                        <path d="M10 11l0 6"></path>
                                        <path d="M14 11l0 6"></path>
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= $tarea['titulo']; ?></h5>
                            <p class="card-text"><?= $tarea['descripcion']; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Columna de tareas doing -->
        <div class="col-md-4">
            <h2 class="text-center bg-warning text-dark p-2 rounded">DOING</h2>
            <div class="card-columns">
                <?php foreach ($tareas_doing as $tarea): ?>
                    <div class="card border-warning mb-3">
                    <div class="card-header d-flex align-items-center justify-content-between">
                            <span>Entrega: <?=$tarea['fecha_entrega']; ?></span>
                            <form action="edit_tarea.php" method="post">
                                <input type="hidden" name="tarea_id" value="<?= $tarea['id']; ?>">
                                <button type="submit" class="btn" name="btn_modificar">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                        <path d="M16 5l3 3" />
                                    </svg>
                                </button>
                                </form>
                            <form action="" method="post"> 
                                <input type="hidden" name="tarea_id" value="<?= $tarea['id']; ?>">
                                <button type="submit" class="btn" name="btn_eliminar">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="2">
                                        <path d="M4 7l16 0"></path>
                                        <path d="M10 11l0 6"></path>
                                        <path d="M14 11l0 6"></path>
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= $tarea['titulo']; ?></h5>
                            <p class="card-text"><?= $tarea['descripcion']; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Columna de tareas done -->
        <div class="col-md-4">
            <h2 class="text-center bg-success text-white p-2 rounded">DONE</h2>
            <div class="card-columns">
                <?php foreach ($tareas_done as $tarea): ?>
                    <div class="card border-success mb-3">
                    <div class="card-header d-flex align-items-center justify-content-between">
                            <span>Entrega: <?= $tarea['fecha_entrega']; ?></span>
                            <form action="edit_tarea.php" method="post">
                                <input type="hidden" name="tarea_id" value="<?= $tarea['id']; ?>">
                                <button type="submit" class="btn" name="btn_modificar">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                        <path d="M16 5l3 3" />
                                    </svg>
                                </button>
                                 </form>
                            <form action="" method="post"> 
                                <input type="hidden" name="tarea_id" value="<?= $tarea['id']; ?>">
                                <button type="submit" class="btn" name="btn_eliminar">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="2">
                                        <path d="M4 7l16 0"></path>
                                        <path d="M10 11l0 6"></path>
                                        <path d="M14 11l0 6"></path>
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= $tarea['titulo']; ?></h5>
                            <p class="card-text"><?= $tarea['descripcion']; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="newTareaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva Tarea</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="newTarea" method="post" action="">
          <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Escribe el título de la tarea" required>
          </div>
          <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Describe la tarea" required></textarea>
          </div>
          <div class="mb-3">
            <label for="fecha_entrega" class="form-label">Fecha de Entrega</label>
            <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega" required>
          </div>
          <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select" id="estado" name="estado" required>
              <option value="" disabled selected>Selecciona el estado</option>
              <option value="to_do">Pendiente</option>
              <option value="doing">En progreso</option>
              <option value="done">Completada</option>
            </select>
          </div>
          <div class="modal-footer">       
        <button type="submit" name="nuevaTarea" class="btn btn-primary">Guardar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
        </form>
      </div>
     
    </div>
  </div>
</div>