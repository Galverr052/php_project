<?php
session_start();
require './includes/data.php';

$id_libro = $_GET['id_libro'] ?? null;

if(!$id_libro){
    header("Location: index.php");
    exit;
}

$resenas = getResenasLibro($db, $id_libro);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reseñas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .stars {
            display: flex;
            gap: 5px;
            margin-top: 5px;
        }

        .star {
            width: 28px;
            height: 28px;
            fill: #ccc;
            cursor: pointer;
            transition: 0.2s;
        }

        .star.selected {
            fill: #f5c518;
        }
    </style>
</head>
<body>

<div class="container mt-4">

    <h2>Reseñas del libro</h2>

    <!-- FORMULARIO -->
    <?php if(isset($_SESSION['usuario'])): ?>

        <form method="POST" action="guardar_resena.php" class="mb-4">

            <input type="hidden" name="id_libro" value="<?php echo $id_libro; ?>">
            <input type="hidden" name="puntuacion" id="puntuacion" required>

            <label>Puntuación</label>

            <div class="stars">
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <svg class="star" data-value="<?php echo $i; ?>" viewBox="0 0 24 24">
                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                    </svg>
                <?php endfor; ?>
            </div>

            <label class="mt-2">Comentario</label>
            <textarea name="comentario" class="form-control" required></textarea>

            <button class="btn btn-primary mt-3">Enviar reseña</button>
        </form>

    <?php else: ?>
        <p>Debes iniciar sesión para escribir reseñas.</p>
        <a href="login.php" class="btn btn-primary w-100>">Iniciar Sesion</a>
    <?php endif; ?>

    <hr>

    <!-- RESEÑAS -->
    <?php foreach($resenas as $r): ?>
        <div class="border p-3 mb-2">

            <strong><?php echo $r['nombre_usuario']; ?></strong><br>
            ⭐ <?php echo $r['puntuacion']; ?>/5

            <p><?php echo htmlspecialchars($r['comentario']); ?></p>

            <small><?php echo $r['fecha']; ?></small>

            <?php if(isset($_SESSION['usuario']) && $_SESSION['usuario']['is_admin'] == 1): ?>
                <a href="borrar_resena.php?id=<?php echo $r['id_resena']; ?>"
                   class="btn btn-danger btn-sm mt-2">
                   Eliminar
                </a>
            <?php endif; ?>

        </div>
    <?php endforeach; ?>

</div>

<script>
const stars = document.querySelectorAll('.star');
const input = document.getElementById('puntuacion');

let selected = 0;

stars.forEach(star => {

    star.addEventListener('mouseover', () => {
        highlight(star.dataset.value);
    });

    star.addEventListener('mouseout', () => {
        highlight(selected);
    });

    star.addEventListener('click', () => {
        selected = star.dataset.value;
        input.value = selected;
        highlight(selected);
    });

});

function highlight(value) {
    stars.forEach(star => {
        star.classList.remove('selected');

        if (star.dataset.value <= value) {
            star.classList.add('selected');
        }
    });
}
</script>

</body>
</html>