<?php

//Reto: ¿Puedo retirar mis donaciones de Twitch?

//En Twitch, los streamers pueden recibir donaciones de sus seguidores. Sin embargo, Twitch cobra una comisión del 25% por cada donación. Por ejemplo, si un seguidor dona $100, el streamer solo recibe $75.

//Escribe un programa que reciba una cantidad donada y regrese la cantidad que el streamer recibirá después de que Twitch haya deducido su comisión.

$dinero = trim(readline("Cuanto dinro tienes?: "));

$dinero = (int)($dinero);

$deseasRetirar = trim(readline("Deseas retirar tu dinero? (si/no): "));

switch ($deseasRetirar) {
    case 'si':
        $comision = $dinero * 0.25;
        $dinero = $dinero - $comision;
        echo "Tu dinero menos la comision es: $dinero\n";
        break;
    case 'no':
        echo "Gracias por tu donacion\n";
        break;
    default:
        echo "Opcion no valida\n";
        break;
}


?>