<?php


// 1️⃣ Variables y Constantes
$nombre = "Juan";   // string
$edad = 25;         // int
$precio = 19.99;    // float
$activo = true;     // boolean

define("PI", 3.1416); // Constante

echo "<h2>Variables y Constantes</h2>";
echo "Nombre: $nombre<br>";
echo "Edad: $edad<br>";
echo "Precio: $precio<br>";
echo "Activo: ".($activo ? "Sí" : "No")."<br>";
echo "Constante PI: ".PI."<hr>";

// 2️⃣ Estructuras de control

echo "<h2>Condicionales</h2>";
if ($edad >= 18) {
    echo "Mayor de edad<br>";
} else {
    echo "Menor de edad<br>";
}

$nota = 7;
if ($nota >= 9) echo "Excelente<br>";
elseif ($nota >= 6) echo "Aprobado<br>";
else echo "Reprobado<br>";

$dia = 3;
switch ($dia) {
    case 1: echo "Lunes<br>"; break;
    case 2: echo "Martes<br>"; break;
    case 3: echo "Miércoles<br>"; break;
    default: echo "Otro día<br>";
}

// Bucles
echo "<h2>Bucles</h2>";
echo "For: ";
for($i=1; $i<=5; $i++) echo $i." ";
echo "<br>";

echo "While: ";
$i=1;
while($i<=5){ echo $i." "; $i++; }
echo "<br>";

echo "Do..While: ";
$i=1;
do { echo $i." "; $i++; } while($i<=5);
echo "<br>";

$frutas = ["manzana","pera","uva"];
echo "Foreach: ";
foreach($frutas as $f) echo $f." ";
echo "<hr>";

// 3️⃣ Formularios y Superglobales
echo "<h2>Superglobales</h2>";
echo "Ejemplo: <br>";
echo '$_POST["nombre"], $_GET["edad"], $_SERVER["PHP_SELF"], $_SERVER["REQUEST_METHOD"]';
echo "<hr>";

// 4️⃣ Incluir archivos
echo "<h2>Incluir archivos</h2>";
echo "include 'archivo.php', require 'archivo.php', include_once, require_once<hr>";

// 5️⃣ OOP – Conceptos básicos
echo "<h2>OOP</h2>";
class Persona {
    public $nombre;
    private $edad;

    public function __construct($nombre,$edad){
        $this->nombre = $nombre;
        $this->edad = $edad;
    }

    public function saludar(){ echo "Hola, soy ".$this->nombre."<br>"; }
    private function mostrarEdad(){ echo $this->edad; }
}

$persona1 = new Persona("Juan",25);
$persona1->saludar();

echo "<hr><small>✅ Esta es tu chuleta PHP lista para repasar</small>";
?>
