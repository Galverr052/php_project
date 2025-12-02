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

/* Función que inserta el personaje en la posición deseada */
function getPersonaje($tableroMarkup, $row, $col) {
    if (!is_numeric($row) || !is_numeric($col)) return $tableroMarkup;

    $row = intval($row);
    $col = intval($col);

    // Dividir el HTML por tiles
    $dom = new DOMDocument();
    libxml_use_internal_errors(true); // evitar warnings por HTML5
    $dom->loadHTML('<div id="contenedor">'.$tableroMarkup.'</div>');
    libxml_clear_errors();

    $tiles = $dom->getElementById('contenedor')->getElementsByTagName('div');
    $cols = 12; // columnas del tablero
    $index = $row * $cols + $col;

    if (isset($tiles[$index])) {
        $img = $dom->createElement('img');
        $img->setAttribute('src', './src/mario.png');
        $tiles[$index]->appendChild($img);
    }

    // Devolver HTML actualizado
    $nuevoHTML = '';
    foreach ($tiles as $tile) {
        $nuevoHTML .= $dom->saveHTML($tile);
    }
    return $nuevoHTML;
}

/* --- Lógica principal --- */

// Leer el CSV
$tablero = leerArchivoCSV("./data/tablero1.csv");

// Generar HTML del tablero
$tableroMarkup = getTableroMarkup($tablero);

// Recoger coordenadas de GET o POST
$row = $_GET['row'] ?? $_POST['row'] ?? null;
$col = $_GET['col'] ?? $_POST['col'] ?? null;

// Mensaje por defecto
$mensaje = "";
if ($row === null || $col === null) {
    $mensaje = "No se ha puesto ninguna posición al personaje.";
}

// Insertar personaje
$tableroMarkup = getPersonaje($tableroMarkup, $row, $col);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Minified version -->
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <title>Document</title>
    <style>
        .contenedorTablero {
            width:600px;
            height:600px;
            border: solid 2px grey;
            box-shadow: grey;
            display:grid;
            grid-template-columns: repeat(12, 1fr);
            grid-template-rows: repeat(12, 1fr);
        }
        .tile {
            float: left;
            margin: 0;
            padding: 0;
            border-width: 0;
            background-image: url("./src/464.jpg");
            background-size: 209px;
            background-repeat: none;
        }
        .img{
            max-width:100%;
        }
        .fuego {
            background-color: red;
            background-position: -105px -52px;
        }
        .tierra {
            background-color: brown;
            background-position: -157px 0px;
        }
        .agua {
            background-color: blue;
            background-position: -53px 0px;
        }
        .hierba {
            background-color: green;
            background-position: 0px 0px;
        }
        .piedra {
            background-color: gray;
            background-position: 0px 104px;
        }
        .ladrilloP {
            background-color: gray;
            background-position: 0px -157px;
        }
    </style>
</head>
<body>
    <h1>Tablero juego super rol DWES</h1>
    <div class="mesajesContainer"><p><?php echo $mensaje; ?></p></div>
    <div class="contenedorTablero">
        <?php echo $tableroMarkup; ?>
    </div>
</body>
</html>