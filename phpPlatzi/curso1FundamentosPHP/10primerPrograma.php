<?php

$flag = true;

while ($flag) {
    $segundosUsuario = trim(readline("Ingrese los segundos: "));
    if (is_numeric($segundosUsuario)) {
        $flag = false;
    } else {
        echo "Por favor ingrese un valor numerico\n";
    }
}

$horas = (int)($segundosUsuario / 3600);
$segundosUsuario = (int)($segundosUsuario % 3600);
$minutos = (int)($segundosUsuario / 60);
$segundosUsuario = (int)($segundosUsuario % 60);

echo "Son $horas horas, $minutos minutos y $segundosUsuario segundos\n";