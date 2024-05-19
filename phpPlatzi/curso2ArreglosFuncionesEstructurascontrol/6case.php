<?php
//Estructura de control switch
//Se usa cuando se tiene que evaluar una variable en diferentes valores o hay multiples condiciones u opciones
// Es importante usar el break para que no se sigan evaluando las demas opciones

$fruta = "manzana";
switch ($fruta) {
    case 'manzana':
        echo "La fruta es una manzana\n";
        break;
    case 'pera':
        echo "La fruta es una pera\n";
        break;
    case 'uva':
        echo "La fruta es una uva\n";
        break;
    default:
        echo "La fruta no esta en el menu\n";
        break;
}
?>