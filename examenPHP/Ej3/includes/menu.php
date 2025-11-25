<?php
$menu = [
    "Inicio" => "inicio.php",
    "Sobre mí" => "sobremi.php",
    "Proyectos" => "proyectos.php",
    "Contacto" => "contacto.php",
    "Mis asignaturas" => "informeasignaturas.php"
];
?>
<nav class="bg-gray-600 text-gray-200 text-md p-4">
    <ul class="flex gap-6 items center justify-center">
        <li classname="hover:h-8">
            <a href="index.php">
            <img src="img/perfil.png" class="h-7 w-7 rounded-full">
            </a>
        </li>
        <?php foreach ($menu as $nombre => $enlace): ?>
            <li>
                <a href="<?= $enlace ?>" class="hover:text-white hover:text-lg"><?= $nombre ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
