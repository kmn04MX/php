<?php

$hora = trim(readline("Ingrese la hora (HH:MM:SS): "));
$flaga = true;

while ($flaga) {
    if (preg_match("/([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]/", $hora)) {
        $flaga = false;
    } else {
        echo "Por favor ingrese una hora valida (HH:MM:SS)\n";
        $hora = trim(readline("Ingrese la hora (HH:MM:SS): "));
    }
}

$horasMinutosSegundos = explode(":", $hora);

$horas = (int)$horasMinutosSegundos[0];
$minutos = (int)$horasMinutosSegundos[1];
$segundos = (int)$horasMinutosSegundos[2];

$segundosTotales = ($horas * 3600) + ($minutos * 60) + $segundos;

echo "La hora ingresada en segundos es: $segundosTotales\n";