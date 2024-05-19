<?php
#Primer forma
$frutas = array("pera", "manzana", "uva");
echo "La fruta 1 es $frutas[0]\n";
#Desde este tipo podemos acceder segun el indice 

#Segunda forma
$frutas = ["Uva", "Pera", "Sandia"];
echo "La fruta 2 es $frutas[2]\n";
#Desde este tipo podemos acceder segun el indice 

#Arreglo Asociativo
$joe = array('name' => 'Jose', 'age' => 25, 'country' => 'mexico');
echo "La edad de joe es: $joe[age]\n";
#Para acceder a este tipo debemos hacerlo de lasiguente forma $nameArray['namePropiedad']
