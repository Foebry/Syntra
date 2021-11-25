<?php

function Euclides($getal_1, $getal_2): int {
    # functie om de grootste gemene deler te vinden tussen 2 getallen.
    # eerste parameter is steeds de grootste

    if ($getal_1 == $getal_2) return $getal_1;

    while($getal_2>$getal_1) $getal_2 -= $getal_1;

    return Euclides($getal_2, $getal_1);  #getal_2 wordt eerste parameter want dit is nu het grootste
}


$getal_1 = readline("Geef een getal aub: ");
$getal_2 = readline("Geef nog een getal aub ");

$max = max($getal_1, $getal_2);
$min = min($getal_1, $getal_2);

print("De grootste gemene deler van $getal_1 en $getal_2 is ".Euclides($max, $min));

