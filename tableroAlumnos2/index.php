<?php
/* Inicialización del entorno */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* Funciones de debug */
function dump($var){
    echo '<pre>'.print_r($var,1).'</pre>';
}

/* Función lógica presentación: genera el tablero HTML */
function getTableroMarkup($tablero, $row, $col, $cRow, $cCol) {
    $html = "";
    foreach ($tablero as $r => $fila) {
        foreach ($fila as $c => $celda) {

            switch ($celda) {
                case 'fuego':  $tipo = 'fuego'; break;
                case 'tierra': $tipo = 'tierra'; break;
                case 'agua':   $tipo = 'agua'; break;
                case 'hierba': $tipo = 'hierba'; break;
                case 'piedra': $tipo = 'piedra'; break;
                case 'ladrilloP': $tipo = 'ladrilloP'; break;
                default:       $tipo = ''; break;
            }

            $html .= "<div class='tile $tipo'>";

            // Corazón (objeto)
            if ($r === $cRow && $c === $cCol) {
                $html .= "<img src='./src/vida.png' class='objeto'>";
            }

            // Personaje
            if ($r === $row && $c === $col) {
                $html .= "<img src='./src/mario.png' class='img'>";
            }

            $html .= "</div>";
        }
    }
    return $html;
}

/* Función lógica de negocio: leer CSV */
function leerArchivoCSV($rutaArchivoCSV) {
    $tablero = [];
    if (($f = fopen($rutaArchivoCSV, "r")) !== false) {
        while (($fila = fgetcsv($f, 0, ",")) !== false) {
            $fila = array_map(fn($v) => trim($v, '"'), $fila);
            $tablero[] = $fila;
        }
        fclose($f);
    }
    return $tablero;
}

/* Movimiento controlado */
function getNewPosicion($row, $col, $pos){
    switch ($pos) {
        case 'up':
            if ($row > 0) $row--;
            break;
        case 'down':
            if ($row < 11) $row++;
            break;
        case 'left':
            if ($col > 0) $col--;
            break;
        case 'right':
            if ($col < 11) $col++;
            break;
    }
    return [$row, $col];
}

/* Botones */
function pintarBotonesMarkup($row, $col, $vidas, $cRow, $cCol){
    return '
        <div style="text-align:center; margin-top:20px;">
            <a href="?row='.$row.'&col='.$col.'&pos=up&vidas='.$vidas.'&cRow='.$cRow.'&cCol='.$cCol.'">Arriba</a>
            <a href="?row='.$row.'&col='.$col.'&pos=left&vidas='.$vidas.'&cRow='.$cRow.'&cCol='.$cCol.'">Izquierda</a>
            <a href="?row='.$row.'&col='.$col.'&pos=right&vidas='.$vidas.'&cRow='.$cRow.'&cCol='.$cCol.'">Derecha</a>
            <a href="?row='.$row.'&col='.$col.'&pos=down&vidas='.$vidas.'&cRow='.$cRow.'&cCol='.$cCol.'">Abajo</a>
        </div>
    ';
}

/* Mostrar vidas */
function mostrarVidas($vidas){
    $html = "<div style='margin-bottom:10px;'>";
    for ($i=0; $i<$vidas; $i++){
        $html .= "<img src='./src/vida.png' width='30'>";
    }
    $html .= "</div>";
    return $html;
}

/* ---------------- LÓGICA PRINCIPAL ---------------- */

// Leer tablero
$tablero = leerArchivoCSV("./data/tablero1.csv");

// Coordenadas personaje
$row = isset($_GET['row']) ? intval($_GET['row']) : 0;
$col = isset($_GET['col']) ? intval($_GET['col']) : 0;

// Vidas
$vidas = isset($_GET['vidas']) ? intval($_GET['vidas']) : 3;
$maxVidas = 5;

// Coordenadas corazón
$cRow = isset($_GET['cRow']) ? intval($_GET['cRow']) : rand(0,11);
$cCol = isset($_GET['cCol']) ? intval($_GET['cCol']) : rand(0,11);

// Movimiento
if (isset($_GET['pos'])) {
    [$row, $col] = getNewPosicion($row, $col, $_GET['pos']);
}

// Daño por fuego
if ($tablero[$row][$col] === 'fuego') {
    $vidas--;
}

// Recoger corazón
if ($row === $cRow && $col === $cCol) {
    $vidas++;
    if ($vidas > $maxVidas) $vidas = $maxVidas;
    $cRow = rand(0,11);
    $cCol = rand(0,11);
}

// Pintar tablero
$tableroMarkup = getTableroMarkup($tablero, $row, $col, $cRow, $cCol);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Juego DWES</title>
<link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
<style>
.contenedorTablero {
    width:600px;
    height:600px;
    border: solid 2px grey;
    display:grid;
    grid-template-columns: repeat(12, 1fr);
    grid-template-rows: repeat(12, 1fr);
}
.tile {
    position: relative;
    background-image: url("./src/464.jpg");
    background-size: 209px;
}
.img { width: 100%;
        height: 100%;
        object-fit: contain;
        display:block;
        margin:auto;
        opacity:100%;
        pointer-events: none; }
.objeto { width: 100%;
        height: 100%;
        object-fit: contain;
        display:block;
        margin:auto;
        opacity:100%;
        pointer-events: none; }
.fuego { background-position: -105px -52px; }
.tierra { background-position: -157px 0px; }
.agua { background-position: -53px 0px; }
.hierba { background-position: 0px 0px; }
.piedra { background-position: 0px 104px; }
.ladrilloP { background-position: 0px -157px; }
</style>
</head>
<body>

<h1>Tablero juego super rol DWES</h1>

<?= mostrarVidas($vidas) ?>

<?php if ($vidas <= 0): ?>
<h2>GAME OVER</h2>
<?php endif; ?>

<?= pintarBotonesMarkup($row, $col, $vidas, $cRow, $cCol) ?>

<div class="contenedorTablero">
    <?= $tableroMarkup ?>
</div>


</body>
</html>
