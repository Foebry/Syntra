<?php


$lijst = [ 14, 5, 8, 9, 13, 18, 16, 25 ];


function Gemiddelde($list): float{
    $gemiddelde = 0;
    $aantal = 0;

    foreach ($list as $item){
        $gemiddelde += $item;
        $aantal += 1;
    }

    $gemiddelde /= $aantal;

    return $gemiddelde;
}

$G = Gemiddelde($lijst);
print "Bij gebruik van de functie Gemiddelde is het gemiddelde ". $G."\n";
print "Bij gebruik van standaard functies is het gemiddelde ". array_sum($lijst)/count($lijst). "\n";