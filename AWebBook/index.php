<?php
session_start();
require './includes/data.php';
require './includes/header.php'; // cabecera con logo y botones

// Filtro por categoría
$selectedCat = $_GET['categoria'] ?? null;

// Obtener libros y categorías
$categorias = getCategorias($db);
$libros = getLibros($db, $selectedCat);
?>

<div class="container mt-4">
    
    <?php if(isset($_SESSION['usuario']) && $_SESSION['usuario']['is_admin'] == 1): ?>
<div class="mb-3">
    <button type="button" class="btn btn-outline-primary"
            data-bs-toggle="modal" data-bs-target="#registrarLibroModal">
        Registrar libro
    </button>
</div>
<?php endif; ?>

    
   <!-- FILTRO POR CATEGORÍA -->
<form class="row mb-4" method="GET">
    <div class="col-md-4">
        <select name="categoria" class="form-select">
            <option value="">Seleccione una categoría</option>
            <?php foreach($categorias as $cat): ?>
                <option value="<?php echo $cat['id_categoria']; ?>" <?php if($selectedCat==$cat['id_categoria']) echo 'selected'; ?>>
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

<?php if(isset($_SESSION['usuario']) && $_SESSION['usuario']['is_admin']==0): ?>
<button type="button" class="btn btn-info mb-3" data-bs-toggle="modal" data-bs-target="#reservasModal">
    Ver mis reservas
</button>
<?php endif; ?>

    <!-- LISTADO DE LIBROS -->
    <div class="row">
        <?php if(!empty($libros)): ?>
            <?php foreach($libros as $libro): ?>
                <div class="col-md-4 d-flex align-items-stretch mb-4">
                    <div class="card shadow w-100">
                        <img src="./img/<?php echo htmlspecialchars($libro['imagen']); ?>" class="img-thumbnail w-50 mx-auto mt-3" alt="<?php echo htmlspecialchars($libro['titulo']); ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($libro['titulo']); ?></h5>
                            <p class="card-text">
                                <strong>Autor:</strong> <?php echo htmlspecialchars($libro['autor']); ?><br>
                                <strong>Categoría:</strong> <?php echo htmlspecialchars($libro['categoria']); ?>
                            </p>
                            <div class="mt-auto">
                                <?php if(isset($_SESSION['usuario'])): ?>
                                    <?php if($_SESSION['usuario']['is_admin']): ?>
                                        <!-- Admin: eliminar libro si disponible -->
                                        <form method="POST" action="eliminar_libro.php">
                                            <input type="hidden" name="id_libro" value="<?php echo $libro['id_libro']; ?>">
                                            <button class="btn btn-danger w-100" <?php if(!$libro['disponible']) echo 'disabled'; ?>>Eliminar</button>
                                        </form>
                                    <?php else: ?>
                                        <!-- Usuario normal: reservar libro -->
                                        <a href="reserva.php?id_libro=<?php echo $libro['id_libro']; ?>" class="btn btn-primary w-100 <?php if(!$libro['disponible']) echo 'disabled'; ?>">
                                            Reservar
                                        </a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <!-- Usuario no logueado: botón redirige a login -->
                                    <a href="login.php" class="btn btn-primary w-100 <?php if(!$libro['disponible']) echo 'disabled'; ?>">
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

<!-- MODAL RESERVAS para usuarios normales -->
<?php if(isset($_SESSION['usuario']) && $_SESSION['usuario']['is_admin']==0): ?>
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
                $sql = "SELECT r.fecha_reserva, l.titulo FROM reservas r
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
