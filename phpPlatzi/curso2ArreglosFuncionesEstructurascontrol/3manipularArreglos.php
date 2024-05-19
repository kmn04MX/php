<?php
$edades = [18, 25, 30, 20, 40];


//contar arreglo
echo count($edades) . "\n";

//Agregar un elemento al final del arreglo 
array_push($edades, 60);

//is_array
$esto_no_es_un_array = "Hola";

if (is_array($esto_no_es_un_array)) {
    echo "Esto es un array\n";
} else {
    echo "Esto no es un array\n";
}

//ordenar arreglo
sort($edades);
echo "Ordenado: ".print_r($edades)."\n";

//explode --> separa un string en un array
$nombres = "Jose,Felipe,David,Sandra,Victor";
$nombreArray = explode(",", $nombres);
echo "Nombre: ".print_r($nombreArray)."\n";


//funcione de un arreglo --> https://www.php.net/manual/es/ref.array.php
?>