<?php

/* Inicialización del entorno */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* Zona de declaración de funciones */
//Funciones de debugueo
function dump($var){
    echo '<pre>'.print_r($var,1).'</pre>';
}

//Función lógica presentación
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

//Función lógica de negocio
function leerArchivoCSV($rutaArchivoCSV) {
    $tablero = [];

    if (($f = fopen($rutaArchivoCSV, "r")) !== false) {
        while (($fila = fgetcsv($f, 0, ",")) !== false) {

            // Eliminar comillas si las hubiera
            $fila = array_map(fn($v) => trim($v, '"'), $fila);

            $tablero[] = $fila;
        }
        fclose($f);
    }

    return $tablero;
}


//Lógica de negocio

$tablero = leerArchivoCSV("./data/tablero2.csv");

$tableroMarkup = getTableroMarkup($tablero);

//Lógica de presentación



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
    <div class="contenedorTablero">
        <?php echo $tableroMarkup; ?>
    </div>
</body>
</html>