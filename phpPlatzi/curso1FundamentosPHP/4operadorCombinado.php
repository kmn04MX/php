<?php

$numero1 = 8;
$numero2 = 0;

if($numero1 <=> $numero2){
    echo $numero1 <=> $numero2;
    echo " El numero de la izquierda es mayor";
    echo "\n";
}

$numero1 = 0;
$numero2 = 8;

if($numero1 <=> $numero2){
    echo $numero1 <=> $numero2;
    echo " El numero de la derecha es mayor";
    echo "\n";
}

$numero1 = 0;
$numero2 = 0;

if(!($numero1 <=> $numero2)){
    echo $numero1 <=> $numero2;
    echo " Los numeros son iguales";
    echo "\n";
}

?>