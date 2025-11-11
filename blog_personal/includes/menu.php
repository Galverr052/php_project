<?php
$menu = [
    "Inicio" => "inicio.php",
    "Sobre mí" => "sobremi.php",
    "Proyectos" => "proyectos.php",
    "Contacto" => "contacto.php"
];
?>

<nav class="bg-gray-900 text-white p-4">
    <ul class="flex gap-6 justify-center">
        <?php foreach ($menu as $nombre => $enlace): ?>
            <li>
                <a href="<?= $enlace ?>" class="hover:text-blue-400"><?= $nombre ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
