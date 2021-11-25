<?php

$artikelen = [];
const breedte_output = 47;
const linkse_uitlijning = 0;    # uitlijning aantal spaties vanaf de kantlijn


function Align($modus, $tekst, $breedte=0): string{
    /*
     * functie om uit te lijnen.
     * param breedte: het aantal characters die nog gebruikt mogen worden. (enkel van toepassing voor rechtse uitlijning.)
     */

    # aangepast

    if ($modus == "R"){
        $aantal_spaties = $breedte - strlen($tekst);
        $output = str_repeat(" ", $aantal_spaties).ucfirst($tekst);
        return $output;
    }
    $output = str_repeat(" ", linkse_uitlijning).ucfirst($tekst);
    return $output;
}

function sanderFabry($artikelen): string{
    /*
     * Functie om boodschappenlijstje uit te printen.
     */
    $output = "";
    ksort($artikelen); # sorteer de $artikelen lijst alfabetisch op de waarde van de keys.

    $boodschappen = "B O O D S C H A P P E N";
    $aantal_streepjes = (breedte_output-strlen($boodschappen)) / 2;
    $output .= str_repeat("-", $aantal_streepjes).$boodschappen. str_repeat("-", $aantal_streepjes)."\n";

    # overloop ieder artikel
    foreach($artikelen as $artikel => $aantal){
        $artikel = Align("L", $artikel);                                            # artikelen worden links uitgelijnd met 0 spaties.
        $aantal = Align("R", $aantal, breedte_output-strlen($artikel));      # aantallen worden rechts uitgelijnd
        $output .= $artikel. $aantal. "\n";

    }

    $output .= str_repeat("-", breedte_output)."\n";
    $aantal_lijnen = "Aantal lijnen: ".count($artikelen);
    $totaal = "Totaal: ".array_sum($artikelen);

    $aantal = Align("L", $aantal_lijnen);
    $totaal = Align("R", $totaal, breedte_output-strlen($aantal));

    $output .= $aantal . $totaal. "\n";
    $output .= str_repeat("-", breedte_output);

    return $output;
}




while(true){
    /*
     * Zolang input op $artikel geen "q" is blijf naar artikelen vragen.
     * Ieder artikel wordt in de $artikelen ass array bewaard als key samen met het corresponderende aantal als value.
     */
    $artikel = readline("Welk artikel? ");
    if ($artikel == "q") break;
    $aantal = readline("Aantal? ");
    $artikelen[$artikel] = $aantal;
}

# wanneer input op artikel "q" wordt, print het boodschappenlijstje.
print(sanderFabry($artikelen));

