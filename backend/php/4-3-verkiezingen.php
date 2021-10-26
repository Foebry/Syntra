<?php

include "oefening_2.4.php";

const breedte_tabel = 40;

$stemmen =  [
    "NVA"=> 2455,
    "SP-A"=> 2856,
    "CD&V"=> 1501,
    "GROEN"=> 1744,
    "OPEN-VLD"=> 1988,
    "VLAAMSBELANG"=> 586,
    "PVDA"=> 697
];

function percentageStemmen($stemmen): string{
    # totaal aantal stemmen berekenen
    $totaal_stemmen = 0;
    $totaal_percentage_stemmen = 0;
    foreach($stemmen as $aantal_stemmen){
        $totaal_stemmen += $aantal_stemmen;
    }

    # Hooding aanmaken
    $output = "Totaal aantal stemmen: $totaal_stemmen\n" . "\n";

    # rijen aanmaken
    foreach($stemmen as $partij => $aantal_stemmen){
        $output .= $partij;
        $percentage_stemmen = number_format($aantal_stemmen / $totaal_stemmen * 100, 2);
        $totaal_percentage_stemmen += floatval($percentage_stemmen);
        $output .= rechtsUitlijnen($percentage_stemmen, breedte_tabel - strlen($partij))."\n";
    }

    # totaal-rij aanmaken
    $totaal = "Totaal van de percentages:";
    $output .= "\n" . $totaal. rechtsUitlijnen(number_format($totaal_percentage_stemmen, 2), breedte_tabel-strlen($totaal));

    return $output;
}

print(percentageStemmen($stemmen));