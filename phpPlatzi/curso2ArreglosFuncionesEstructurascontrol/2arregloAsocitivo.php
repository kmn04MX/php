<?php
//Los arreglos asociativos son aquellos que tienen un indice asociado a un valor

$persona = array(
    'name' => 'Jose',
    'age' => 25,
    'country' => 'mexico'
);
echo "La edad de joe es: $persona[age]\n";


$persona2 = [
    'name' => 'Jose',
    'age' => 25,
    'country' => 'mexico'
];
echo "El nombre de la persona es: $persona2[name]\n";

$persona3 = [
    "Carlos" => [
        'name' => 'Carlos',
        'age' => 25,
        'country' => 'mexico'
    ],
    "Jose" => [
        'name' => 'Jose',
        'age' => 25,
        'country' => 'mexico'
    ]
];
echo "Cual es la edad de {$persona3['Carlos']['name']}: {$persona3['Carlos']['age']}\n";
//Para acceder a este tipo debemos hacerlo de lasiguente forma $nameArray['namePropiedad']
?>