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
<<<<<<< HEAD
function getTableroMarkup($tablero) {
    $html = "";
    foreach ($tablero as $fila) {
        foreach ($fila as $celda) {
=======
function getTableroMarkup($tablero, $row, $col, $cRow, $cCol) {
    $html = "";
    foreach ($tablero as $r => $fila) {
        foreach ($fila as $c => $celda) {

>>>>>>> 7455e40bfae5e1a32dedea2ecf153d8d939e7ccb
            switch ($celda) {
                case 'fuego':  $tipo = 'fuego'; break;
                case 'tierra': $tipo = 'tierra'; break;
                case 'agua':   $tipo = 'agua'; break;
                case 'hierba': $tipo = 'hierba'; break;
                case 'piedra': $tipo = 'piedra'; break;
                case 'ladrilloP': $tipo = 'ladrilloP'; break;
                default:       $tipo = ''; break;
            }
<<<<<<< HEAD
            $html .= "<div class='tile $tipo'></div>";
=======

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
>>>>>>> 7455e40bfae5e1a32dedea2ecf153d8d939e7ccb
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

<<<<<<< HEAD
/* Inserta personaje */
function getPersonaje($tablero, $row, $col) {
    $cols = count($tablero[0]); 
    $nuevoHTML = "";

    foreach ($tablero as $r => $fila) {
        foreach ($fila as $c => $celda) {
            $tipo = $celda; 
            $nuevoHTML .= "<div class='tile $tipo'>";
            if ($r === $row && $c === $col) {
                $nuevoHTML .= "<img src='./src/mario.png' class='img'>";
            }
            $nuevoHTML .= "</div>";
        }
    }

    return $nuevoHTML;
}

=======
/* Movimiento controlado */
>>>>>>> 7455e40bfae5e1a32dedea2ecf153d8d939e7ccb
function getNewPosicion($row, $col, $pos){
    switch ($pos) {
        case 'up':
            if ($row > 0) $row--;
            break;
<<<<<<< HEAD

        case 'down':
            if ($row < 11) $row++;
            break;

        case 'left':
            if ($col > 0) $col--;
            break;

=======
        case 'down':
            if ($row < 11) $row++;
            break;
        case 'left':
            if ($col > 0) $col--;
            break;
>>>>>>> 7455e40bfae5e1a32dedea2ecf153d8d939e7ccb
        case 'right':
            if ($col < 11) $col++;
            break;
    }
    return [$row, $col];
<<<<<<< HEAD
}

function pintarBotonesMarkup($row, $col){
    return '
        <div style="text-align:center; margin-top:20px; font-size:30px">
            <p class="">CONTROL</p>
            <a href="?row='.($row-1).'&col='.$col.'&pos=up">▲</a><br>
            <a href="?row='.$row.'&col='.($col-1).'&pos=left">◀</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="?row='.$row.'&col='.($col+1).'&pos=right">▶</a><br>
            <a href="?row='.($row+1).'&col='.$col.'&pos=down">▼</a><br>
        </div>
    ';
}


// Leer tablero
$tablero = leerArchivoCSV("./data/tablero1.csv");

// Coordenadas
$row = isset($_GET['row']) ? intval($_GET['row']) : null;
$col = isset($_GET['col']) ? intval($_GET['col']) : null;

$mensaje = "";
if ($row === null || $col === null) {
    $mensaje = "No se ha puesto ninguna posición al personaje.";
    } else if ($row < 0 || $col < 0 || $row > 11 || $col > 11) {
    $mensaje = "Personaje fuera del tablero.";
}

// Mostrar el tablero normal
$tableroMarkup = getTableroMarkup($tablero);

// Añadir personaje si hay coordenadas
if ($row !== null && $col !== null) {
   $tableroMarkup = getPersonaje($tablero, $row, $col);

}
=======
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
>>>>>>> 7455e40bfae5e1a32dedea2ecf153d8d939e7ccb

?>
<!DOCTYPE html>
<html lang="en">
<head>
<<<<<<< HEAD
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <title>Juego DWES</title>

    <style>
        body {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    }
    p.{}
        .contenedorTablero {
            width:600px;
            height:600px;
            border: solid 2px grey;
            display:grid;
            grid-template-columns: repeat(12, 1fr);
            grid-template-rows: repeat(12, 1fr);
            margin: 10px;
        }
        .tile { 
            background-image: url("./src/464.jpg");
            background-size: 209px;
        }
        .img { width: 100%;
=======
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
>>>>>>> 7455e40bfae5e1a32dedea2ecf153d8d939e7ccb
        height: 100%;
        object-fit: contain;
        display:block;
        margin:auto;
        opacity:100%;
        pointer-events: none; }
<<<<<<< HEAD
        .fuego { background-position: -105px -52px; }
        .tierra { background-position: -157px 0px; }
        .agua { background-position: -53px 0px; }
        .hierba { background-position: 0px 0px; }
        .piedra { background-position: 0px 104px; }
        .ladrilloP { background-position: 0px -157px; }
    </style>

=======
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
>>>>>>> 7455e40bfae5e1a32dedea2ecf153d8d939e7ccb
</head>
<body>

<h1>Tablero juego super rol DWES</h1>

<<<<<<< HEAD
<p><?= $mensaje ?></p>

<?= pintarBotonesMarkup($row, $col) ?>
=======
<?= mostrarVidas($vidas) ?>

<?php if ($vidas <= 0): ?>
<h2>GAME OVER</h2>
<?php endif; ?>

<?= pintarBotonesMarkup($row, $col, $vidas, $cRow, $cCol) ?>
>>>>>>> 7455e40bfae5e1a32dedea2ecf153d8d939e7ccb

<div class="contenedorTablero">
    <?= $tableroMarkup ?>
</div>

<<<<<<< HEAD
=======

>>>>>>> 7455e40bfae5e1a32dedea2ecf153d8d939e7ccb
</body>
</html>
