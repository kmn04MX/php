<?php

//Operador de fusion de null

$numero1 = null;
$numero2 = 20;
$numero3 = 30;

$respuesta = $numero3 ?? $numero2 ?? $numero1;

echo $respuesta;