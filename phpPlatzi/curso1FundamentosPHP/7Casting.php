<?php


$numeroFloat = 10.5;
$numeroTexto = "10";
$combinaTextoNumero = "10.5 " + $numeroEntero + "Hola mundo";
$bandera = -1;

//Casting de variables
echo "\n";
$numeroFloataEntero = (int) $numeroFloat;
var_dump($numeroFloataEntero);

echo "\n";
$numeroTextoEntero = (int) $numeroTexto;
var_dump($numeroTextoEntero);

echo "\n";
var_dump($combinaTextoNumero);

echo "\n";

$bandera = (bool) $bandera;
var_dump($bandera);

/* 
(array) forzado al tipo arreglo
(bool) forzado al tipo booleano
(boolean) forzado al tipo booleano
(double) forzado al tipo 'punto flotante'
(float) forzado al tipo 'punto flotante'
(int) forzado al tipo entero
(integer) forzado al tipo entero
(object) forzado al tipo objeto
(string) forzado al tipo 'cadena de texto'
*/

$stringVacio = "";

$bandera = (bool) $stringVacio;
var_dump($bandera);
