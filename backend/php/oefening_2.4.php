<?php

function RechtsUitlijnen($tekst, $breedte): string{
    /*
     * Lijnt de gegeven tekst rechts uit over een gegeven breedte.
     */
    $spaties = $breedte - strlen($tekst);
    $output = str_repeat(" ", $spaties);

    return $output . $tekst;
}

print RechtsUitlijnen("banaan", 70)."\n";
print RechtsUitlijnen("nog een banaan", 70)."\n";
print RechtsUitlijnen("2.30 euro", 70)."\n";
print RechtsUitlijnen("dit is een hele lange zin", 70)."\n";
print RechtsUitlijnen("14.10 euro", 70)."\n";

