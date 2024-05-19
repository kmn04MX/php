<?php
//La asociatividad te dice hacía que direccion se ejecuta primero
//Forma de procedencia https://www.php.net/manual/es/language.operators.precedence.php
/* A resultado primero se le asigna 1 y luego  contador se suma y es asignado a resultado*/
$contador = 1;
$resultado = $contador++;


//Asociatividad de izquierda
echo "\n";
echo 1 -2 -3 -4 -5;

//Asociatividad de derecha
//$b=5;
echo "\n";
$c = 3;
$a = $b = $c;
echo $a;


