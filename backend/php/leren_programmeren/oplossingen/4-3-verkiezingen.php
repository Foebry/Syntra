<?php


include './rechts_uitlijen.php';


const BREEDTE_REGEL = 35;
const WITREGELS = 1;
const HEADER = "Totaal aantal stemmen: ";
const FOOTER = "Totaal van de percentages:";


$stemmen =  [
    "NVA"=> 2455,
    "SP-A"=> 2856,
    "CD&V"=> 1501,
    "GROEN"=> 1744,
    "OPEN-VLD"=> 1988,
    "VLAAMSBELANG"=> 586,
    "PVDA"=> 697
];


function main($stemmen){
    $totaal_stemmen = 0;
    $p_totaal = 0;

    foreach($stemmen as $aantal_stemmen) $totaal_stemmen += $aantal_stemmen; # bereken totaal aantal stemmen

    print(HEADER.$totaal_stemmen."\n");
    print(str_repeat("\n", WITREGELS)); # print witregels

    foreach($stemmen as $partij => $aantal_stemmen){
        $p_stemmen = number_format($aantal_stemmen / $totaal_stemmen * 100, 2); # bereken percentage van totaal aantal stemmen (wordt een string door number_format)
        $p_totaal += (float)$p_stemmen;                                                      # tel p_stemmen als een float op bij p_totaal
        $percentage = rechtsUitlijnen($p_stemmen, BREEDTE_REGEL-strlen($partij));            # creëer rechtsuitegelijnde string met totaal breedte gelijk aan de totale lengte van BREEDTE_REGEL - de lengte van de string(partij)
        print($partij.$percentage."\n");
    }
    print(str_repeat("\n", WITREGELS));

    $p_totaal = number_format($p_totaal, 2);
    $percentage = rechtsUitlijnen($p_totaal, BREEDTE_REGEL-strlen(FOOTER));
    print(FOOTER.$percentage."\n");
}


main($stemmen);