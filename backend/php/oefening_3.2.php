<?php

/*
 * Script om de grootste gemene deler te vinden van 2 getallen.
 */

function Euclides($getal_1, $getal_2): int{
    /*
     * Zolang getallen niet gelijk zijn,
     * trek het kleinste getal af van het grootste getal.
     * Indien de getallen gelijk zijn, is de grootste gemene deler gevonden
     *
     * param getal_1 → grootste getal
     * param getal_2 → kleinste getal
     */
    if($getal_1 == $getal_2) return $getal_1;

    while($getal_1 > $getal_2) {
        $getal_1 -= $getal_2;
    }
    # getal_2 is nu groter of gelijk aan getal_1
    return Euclides($getal_2, $getal_1);
}


$input_1 = readline("Wat is het eerste getal? ");
$input_2 = readline("Wat is het tweede getal? ");
$ggd = Euclides(max($input_1, $input_2), min($input_1, $input_2));

printf ("De grootste gemene deler van %d en %d is %d", $input_1, $input_2, $ggd);