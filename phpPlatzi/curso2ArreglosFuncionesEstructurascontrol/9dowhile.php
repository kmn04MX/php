<?php

//Ejemplo de ciclo do while

$contador = 0;
do {
    echo "El contador es: $contador\n";
    $contador++;
} while ($contador <= 10);

//La diferencia entre el ciclo while y el ciclo do while es que el ciclo do while se ejecuta al menos una vez, ya que la condición se evalua al final del ciclo


$userNames = [
    'Jose',
    'Carlos',
    'Pedro',
    'Juan'
];

$contador = 0;
do {
    $userName = readline("Ingresa el nombre de usuario: ");
    if (in_array($userName, $userNames)) {
        echo "El nombre de usuario ya existe\n";
    } else {
        echo "El nombre de usuario no existe\n";
    }
} while (in_array($userName, $userNames));
?>