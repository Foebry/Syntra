<?php

/*
 * Genereert een aantal getallen.
 * Vervolgens controleert ieder getal op zijn deelbaarheid door de opgegeven deler.
 * Indien deelbaar print getal is deelbaar door deler.
 * Anders print getal
 */

function DeelbaarDoor($getal, $deler):bool{
    /*
     * Gaat na of getal deelbaar is door deler.
     * Indien geen restwaarde, en dus deelbaar, geeft true terug.
     * Geeft anders false terug.
     */

    if($getal % $deler == 0) return true;
    return false;
}

$aantal_getallen = readline("Hoeveel getallen wil je controleren? ");
$deler = readline("Door welk deler moeten de getallen deelbaar zijn? ");

for($i=0;$i<$aantal_getallen;$i++){
    $getal = random_int(100, 999);
    $output = $getal;
    if (DeelbaarDoor($getal, $deler)) $output .= " is deelbaar door $deler";
    print($output."\n");
}