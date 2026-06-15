<?php
session_start();

require './includes/data.php';
require './includes/header.php';

$selectedCat = $_GET['categoria'] ?? null;

$categorias = getCategorias($db);
$libros = getLibros($db, $selectedCat);
?>

<div class="container mt-4">

    <!-- BOTÓN REGISTRAR LIBRO (SOLO ADMIN) -->
    <?php if(isset($_SESSION['usuario']) && $_SESSION['usuario']['is_admin'] == 1): ?>
        <div class="mb-3">
            <button type="button" class="btn btn-outline-primary"
                    data-bs-toggle="modal" data-bs-target="#registrarLibroModal">
                Registrar libro
            </button>
        </div>
    <?php endif; ?>

    <!-- FILTRO CATEGORÍAS -->
    <form class="row mb-4" method="GET">
        <div class="col-md-4">
            <select name="categoria" class="form-select">
                <option value="">Seleccione una categoría</option>

                <?php foreach($categorias as $cat): ?>
                    <option value="<?php echo $cat['id_categoria']; ?>"
                        <?php if($selectedCat == $cat['id_categoria']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($cat['nombre']); ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <div class="col-md-2 d-flex">
            <button type="submit" class="btn btn-primary w-50 me-2">Filtrar</button>
            <a href="index.php" class="btn btn-danger w-50">Limpiar</a>
        </div>
    </form>

    <!-- BOTÓN RESERVAS (USUARIO NORMAL) -->
    <?php if(isset($_SESSION['usuario']) && $_SESSION['usuario']['is_admin'] == 0): ?>
        <button type="button" class="btn btn-info mb-3"
                data-bs-toggle="modal" data-bs-target="#reservasModal">
            Ver mis reservas
        </button>
    <?php endif; ?>

    <!-- LISTADO LIBROS -->
    <div class="row">

        <?php if(!empty($libros)): ?>
            <?php foreach($libros as $libro): ?>

                <div class="col-md-4 d-flex align-items-stretch mb-4">
                    <div class="card shadow w-100">

                        <img src="./img/<?php echo htmlspecialchars($libro['imagen']); ?>"
                             class="img-thumbnail w-50 mx-auto mt-3"
                             alt="<?php echo htmlspecialchars($libro['titulo']); ?>">

                        <div class="card-body d-flex flex-column">

                            <h5 class="card-title">
                                <?php echo htmlspecialchars($libro['titulo']); ?>
                            </h5>

                            <p class="card-text">
                                <strong>Autor:</strong>
                                <?php echo htmlspecialchars($libro['autor']); ?><br>

                                <strong>Categoría:</strong>
                                <?php echo htmlspecialchars($libro['categoria']); ?>
                            </p>

                            <div class="mt-auto">

                                <!-- BOTÓN RESEÑAS -->
                                <a href="resenas.php?id_libro=<?php echo $libro['id_libro']; ?>"
                                   class="btn btn-warning w-100 mb-2">
                                    Ver reseñas
                                </a>

                                <?php if(isset($_SESSION['usuario'])): ?>

                                    <?php if($_SESSION['usuario']['is_admin']): ?>

                                        <form method="POST" action="eliminar_libro.php">
                                            <input type="hidden" name="id_libro"
                                                   value="<?php echo $libro['id_libro']; ?>">

                                            <button class="btn btn-danger w-100"
                                                <?php if(!$libro['disponible']) echo 'disabled'; ?>>
                                                Eliminar
                                            </button>
                                        </form>

                                    <?php else: ?>

                                        <a href="reserva.php?id_libro=<?php echo $libro['id_libro']; ?>"
                                           class="btn btn-primary w-100
                                           <?php if(!$libro['disponible']) echo 'disabled'; ?>">
                                            Reservar
                                        </a>

                                    <?php endif; ?>

                                <?php else: ?>

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

<!-- MODAL RESERVAS -->
<?php if(isset($_SESSION['usuario']) && $_SESSION['usuario']['is_admin'] == 0): ?>
<div class="modal fade" id="reservasModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Mis Reservas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <?php
                $userId = $_SESSION['usuario']['id_usuario'];

                $sql = "SELECT r.fecha_reserva, l.titulo
                        FROM reservas r
                        JOIN libros l ON r.id_libro = l.id_libro
                        WHERE r.id_usuario = $userId";

                $res = mysqli_query($db, $sql);
                ?>

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

<!-- MODAL REGISTRAR LIBRO (ADMIN) -->
<?php if(isset($_SESSION['usuario']) && $_SESSION['usuario']['is_admin'] == 1): ?>

<div class="modal fade" id="registrarLibroModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Registrar libro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <form method="POST" action="registrar_libro.php" enctype="multipart/form-data">

          <div class="mb-2">
            <label>Título</label>
            <input type="text" name="titulo" class="form-control" required>
          </div>

          <div class="mb-2">
            <label>Autor</label>
            <input type="text" name="autor" class="form-control" required>
          </div>

          <div class="mb-2">
            <label>Categoría</label>
            <select name="id_categoria" class="form-control" required>
              <?php foreach($categorias as $cat): ?>
                <option value="<?php echo $cat['id_categoria']; ?>">
                  <?php echo $cat['nombre']; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-2">
            <label>Imagen</label>
            <input type="file" name="imagen" class="form-control">
          </div>

          <button class="btn btn-success w-100">Guardar libro</button>

        </form>

      </div>

    </div>
  </div>
</div>

<?php endif; ?>