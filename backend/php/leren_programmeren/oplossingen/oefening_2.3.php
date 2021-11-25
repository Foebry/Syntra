<?php

    /*
     * Berekening van de inhoud van een zwembad
     */

    function oppervlakteZwembad($straal): float{
        $opp = round($straal**2*pi(), 2);
        return $opp;
    }

    function VolumeZwembad($straal_bodem, $hoogte, $diameter_top=null): float{
        if ($diameter_top == null){
            $volume = oppervlakteZwembad($straal_bodem) * $hoogte *1000;
            return $volume;
        }
        $straal_top = $diameter_top/2;
        $volume = 1/3 * pi() * $hoogte * ($straal_bodem**2 + $straal_bodem*$straal_top + $straal_top**2) * 1000;
        return $volume;
    }


    $diameter = readline("Wat is de diameter (m) van de bodem van het zwembad? ");
    $hoogte = readline("Wat is de hoogte (m) van het zwembad? ");
    $diameter_top = readline("Wat is de diameter (m) van het zwembad bovenaan? (Enter indien niet van toepassing) ");


    $opp = printf("De inhoud van het zwembad bedraargt %f l", round(volumeZwembad($diameter/2, $hoogte, $diameter_top), 3, 3));
