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
function getTableroMarkup($tablero) {
    $html = "";
    foreach ($tablero as $fila) {
        foreach ($fila as $celda) {
            switch ($celda) {
                case 'fuego':  $tipo = 'fuego'; break;
                case 'tierra': $tipo = 'tierra'; break;
                case 'agua':   $tipo = 'agua'; break;
                case 'hierba': $tipo = 'hierba'; break;
                case 'piedra': $tipo = 'piedra'; break;
                case 'ladrilloP': $tipo = 'ladrilloP'; break;
                default:       $tipo = ''; break;
            }
            $html .= "<div class='tile $tipo'></div>";
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

/* Inserta personaje */
function getPersonaje($tablero, $row, $col) {
    $cols = count($tablero[0]); // número de columnas
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

function getNewPosicion($row, $col, $mov){
    switch ($mov) {
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

/* Botones con enlaces */
function pintarBotonesMarkup($row, $col){
    return '
        <div style="text-align:center; margin-top:20px;">
            <a href="?row='.($row-1).'&col='.$col.'&mov=up">Arriba</a>
            <a href="?row='.$row.'&col='.($col-1).'&mov=left">Izquierda</a>
            <a href="?row='.$row.'&col='.($col+1).'&mov=right">Derecha</a>
            <a href="?row='.($row+1).'&col='.$col.'&mov=down">Abajo</a>
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
    $mensaje = "No se ha puesto ninguna posición al personaje";
    }else if ($row < 0 || $col < 0 || $row > 11 || $col > 11) {
    $mensaje = "Personaje fuera del tablero.";
}

// Mostrar el tablero normal
$tableroMarkup = getTableroMarkup($tablero);

// Añadir personaje si hay coordenadas
if ($row !== null && $col !== null) {
   $tableroMarkup = getPersonaje($tablero, $row, $col);

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <title>Juego DWES</title>

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
            background-image: url("./src/464.jpg");
            background-size: 209px;
        }
        .img { width: 100%;
        height: 100%;
        object-fit: contain;
        display:block;
        margin:auto;
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

<p><?= $mensaje ?></p>

<?= pintarBotonesMarkup($row, $col) ?>

<div class="contenedorTablero">
    <?= $tableroMarkup ?>
</div>

</body>
</html>
