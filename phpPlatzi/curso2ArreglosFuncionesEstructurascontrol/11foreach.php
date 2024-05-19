<?php

$tiendaDeCafes = [
    "Americano" => 20,
    "Latte" => 30,
    "Capuccino" => 25,
    "Mocha" => 35
];

foreach ($tiendaDeCafes as $precio) {
    echo "El café en cuestion cuesta: $$precio USD\n";
}

echo "\n";

foreach ($tiendaDeCafes as $cafe => $precio) {
    echo "El precio del $cafe es: $$precio USD\n";
}

//EL break funciona para salir del ciclo
//EL continue funciona para saltar a la siguiente iteración

//Ejemplo de break
echo "\n";
echo "Ejemplo de break";
echo "\n";
foreach ($tiendaDeCafes as $cafe => $precio) {
    if ($precio == 30) {
        break;
    }
    echo "El precio del $cafe es: $$precio USD\n";
}

//Ejemplo de continue
echo "\n";
echo "Ejemplo de continue";
echo "\n";
foreach ($tiendaDeCafes as $cafe => $precio) {
    if ($precio == 30) {
        continue;
    }
    echo "El precio del $cafe es: $$precio USD\n";
}
?>