<?php

function oppervlakte($straal):float {
    /*
     * Bereken de oppervlakte van een cirkel ($straal * $straal * pi)
     */
    return round($straal ** 2 * pi(), 2);
}

function VolumeCilinder($straal, $hoogte): string{
    /*
     * Bereken de inhoud van een cilinder in L.
     * Bereken eerst de inhoud door $oppervlakte * hoogte.
     * Bereken daarna het aantal liter,
     * wetende dat 1 liter = 1 dm3 en 1 m3 = 1000dm3
     */

    $inhoud = oppervlakte($straal) * $hoogte;
    $inhoud_liter = $inhoud * 1000;

    return sprintf("Het volume van het cilindervormige zwembad bedraagt %.2f liter",$inhoud_liter);
}

function volume($straal_bodem, $hoogte, $straal_top=null):string {
    /*
     * Indien alle parameters meegegeven, bereken het volume van een afgeknote kegel in L,
     * adhv de formule 1/3*pi()*hoogte*(straal_bodem + straal_bodem*straal_top + straal_top ** 2)
     * Bereken het volume van een cilinder in L indien straal_top niet meegegeven.
     */

    if (!$straal_top) return volumeCilinder($straal_bodem, $hoogte);

    $inhoud = 1/3 * pi() * $hoogte * ($straal_bodem**2 + $straal_bodem * $straal_top + $straal_top**2);

    return sprintf("Het volume van de afgeknotte kegel bedraagt %.2f l", $inhoud * 1000);
}

$straal_top = null;
$straal_bodem = readline("Wat is de straal?(m) ");
$hoogte = readline("Wat is de hoogte?(m) ");
$straal_top = readline("Wat is de straal aan de top?(m) Enter indien niet van toepassing ");

print volume($straal_bodem, $hoogte, $straal_top);