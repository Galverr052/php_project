<?php
// Iniciamos la sesión para poder usar $_SESSION
session_start();

// Incluimos el archivo de datos (funciones de BD)
require './includes/data.php';

// Incluimos la cabecera común (logo, botones login/logout)
require './includes/header.php';

/*
--------------------------------------------------
 FILTRO POR CATEGORÍA
--------------------------------------------------
 Recogemos la categoría seleccionada por GET.
 Si no existe, se asigna null.
*/
$selectedCat = $_GET['categoria'] ?? null;

/*
--------------------------------------------------
 OBTENER DATOS DE LA BASE DE DATOS
--------------------------------------------------
 - Categorías: para el select
 - Libros: todos o filtrados por categoría
*/
$categorias = getCategorias($db);
$libros = getLibros($db, $selectedCat);
?>

<div class="container mt-4">

    <!--
    --------------------------------------------------
     BOTÓN REGISTRAR LIBRO (SOLO ADMIN)
    --------------------------------------------------
    Se muestra únicamente si:
    - Existe sesión de usuario
    - El usuario es administrador (is_admin = 1)
    -->
    <?php if(isset($_SESSION['usuario']) && $_SESSION['usuario']['is_admin'] == 1): ?>
        <div class="mb-3">
            <button type="button" class="btn btn-outline-primary"
                    data-bs-toggle="modal" data-bs-target="#registrarLibroModal">
                Registrar libro
            </button>
        </div>
    <?php endif; ?>

    <!--
    --------------------------------------------------
     FORMULARIO DE FILTRO POR CATEGORÍA
    --------------------------------------------------
    - Se envía por GET
    - Permite filtrar libros sin perder estado
    -->
    <form class="row mb-4" method="GET">
        <div class="col-md-4">
            <select name="categoria" class="form-select">
                <option value="">Seleccione una categoría</option>

                <!-- Recorremos todas las categorías -->
                <?php foreach($categorias as $cat): ?>
                    <option value="<?php echo $cat['id_categoria']; ?>"
                        <?php
                        // Mantiene la categoría seleccionada tras filtrar
                        if($selectedCat == $cat['id_categoria']) echo 'selected';
                        ?>>
                        <?php echo htmlspecialchars($cat['nombre']); ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <div class="col-md-2 d-flex">
            <button type="submit" class="btn btn-primary w-50 me-2">
                Filtrar
            </button>
            <!-- Limpia el filtro -->
            <a href="index.php" class="btn btn-danger w-50">
                Limpiar
            </a>
        </div>
    </form>

    <!--
    --------------------------------------------------
     BOTÓN VER MIS RESERVAS (USUARIO NORMAL)
    --------------------------------------------------
    Solo se muestra si:
    - El usuario está logueado
    - NO es administrador
    -->
    <?php if(isset($_SESSION['usuario']) && $_SESSION['usuario']['is_admin'] == 0): ?>
        <button type="button" class="btn btn-info mb-3"
                data-bs-toggle="modal" data-bs-target="#reservasModal">
            Ver mis reservas
        </button>
    <?php endif; ?>

    <!--
    --------------------------------------------------
     LISTADO DE LIBROS
    --------------------------------------------------
    Mostramos todos los libros obtenidos de la BD
    -->
    <div class="row">

        <?php if(!empty($libros)): ?>
            <?php foreach($libros as $libro): ?>

                <div class="col-md-4 d-flex align-items-stretch mb-4">
                    <div class="card shadow w-100">

                        <!-- Imagen del libro -->
                        <img src="./img/<?php echo htmlspecialchars($libro['imagen']); ?>"
                             class="img-thumbnail w-50 mx-auto mt-3"
                             alt="<?php echo htmlspecialchars($libro['titulo']); ?>">

                        <div class="card-body d-flex flex-column">

                            <!-- Título -->
                            <h5 class="card-title">
                                <?php echo htmlspecialchars($libro['titulo']); ?>
                            </h5>

                            <!-- Información -->
                            <p class="card-text">
                                <strong>Autor:</strong>
                                <?php echo htmlspecialchars($libro['autor']); ?><br>

                                <strong>Categoría:</strong>
                                <?php echo htmlspecialchars($libro['categoria']); ?>
                            </p>

                            <div class="mt-auto">

                                <!--
                                ------------------------------------------
                                 BOTONES SEGÚN TIPO DE USUARIO
                                ------------------------------------------
                                -->

                                <?php if(isset($_SESSION['usuario'])): ?>

                                    <?php if($_SESSION['usuario']['is_admin']): ?>
                                        <!--
                                        ADMIN:
                                        - Puede eliminar libros
                                        - Solo si están disponibles
                                        -->
                                        <form method="POST" action="eliminar_libro.php">
                                            <input type="hidden" name="id_libro"
                                                   value="<?php echo $libro['id_libro']; ?>">
                                            <button class="btn btn-danger w-100"
                                                <?php
                                                // Deshabilita si el libro no está disponible
                                                if(!$libro['disponible']) echo 'disabled';
                                                ?>>
                                                Eliminar
                                            </button>
                                        </form>

                                    <?php else: ?>
                                        <!--
                                        USUARIO NORMAL:
                                        - Puede reservar libros disponibles
                                        -->
                                        <a href="reserva.php?id_libro=<?php echo $libro['id_libro']; ?>"
                                           class="btn btn-primary w-100
                                           <?php if(!$libro['disponible']) echo 'disabled'; ?>">
                                            Reservar
                                        </a>
                                    <?php endif; ?>

                                <?php else: ?>
                                    <!--
                                    USUARIO NO LOGUEADO:
                                    - Ve libros
                                    - No puede reservar
                                    - Se redirige a login
                                    -->
                                    <a href="login.php"
                                       class="btn btn-primary w-100
                                       <?php if(!$libro['disponible']) echo 'disabled'; ?>">
                                        Reservar
                                    </a>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay libros disponibles.</p>
        <?php endif; ?>

    </div>
</div>

<!--
--------------------------------------------------
 MODAL "MIS RESERVAS" (USUARIO NORMAL)
--------------------------------------------------
-->
<?php if(isset($_SESSION['usuario']) && $_SESSION['usuario']['is_admin'] == 0): ?>
<div class="modal fade" id="reservasModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Mis Reservas</h5>
                <button type="button" class="btn-close"
                        data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <?php
                // Obtenemos el ID del usuario logueado
                $userId = $_SESSION['usuario']['id_usuario'];

                // Consulta para obtener reservas del usuario
                $sql = "SELECT r.fecha_reserva, l.titulo
                        FROM reservas r
                        JOIN libros l ON r.id_libro = l.id_libro
                        WHERE r.id_usuario = $userId";

                $res = mysqli_query($db, $sql);
                ?>

                <!-- Tabla de reservas -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Libro</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php while($row = mysqli_fetch_assoc($res)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                                <td><?php echo htmlspecialchars($row['fecha_reserva']); ?></td>
                            </tr>
                        <?php endwhile; ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<?php endif; ?>
