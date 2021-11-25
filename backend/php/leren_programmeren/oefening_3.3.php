<?php
/*
 * Berekent de rente voor een opgegeven kapitaal, intrestvoet over een aantal jaar.
 */

include "oefening_2.4.php";

const breedte_kolom_jaar = 4;
const breedte_kolom_kapitaal = 12;
const breedte_kolom_rente = 8;


function intrestBerekening($kapitaal, $intrestvoet, $looptijd, $limiet=null): string{
    # hoofding aanmaken
    $hoofding_jaar = rechtsUitlijnen("Jaar", breedte_kolom_jaar);
    $hoofding_kapitaal = rechtsUitlijnen("Kapitaal", breedte_kolom_kapitaal);
    $hoofding_rente = rechtsUitlijnen("Rente", breedte_kolom_rente);
    $output = $hoofding_jaar.$hoofding_kapitaal.$hoofding_rente."\n";

    #rijen aanmaken
    for($jaar=1; $jaar<=$looptijd; $jaar++){
        $rente = $kapitaal * $intrestvoet;

        $waarde_jaar = rechtsUitlijnen($jaar, breedte_kolom_jaar);
        $waarde_kapitaal = rechtsUitlijnen(number_format($kapitaal, 2), breedte_kolom_kapitaal);
        $waarde_rente = rechtsUitlijnen(number_format($rente, 2), breedte_kolom_rente);

        if ($limiet and $kapitaal >= $limiet) return $output;

        $output .= $waarde_jaar.$waarde_kapitaal.$waarde_rente."\n";
        $kapitaal += $rente;
    }
    return $output;
}

$limiet = null;
$kapitaal = readline("Wat is het kapitaal? ");
$intrestvoet = readline("Wat is de intrest in procenten? ");
$looptijd = readline("Wat is de looptijd? ");
$is_limiet = readline("Is er een limiet?(y/n) ");
if($is_limiet == "y") $limiet = readline("Wat is de limiet? ");

print intrestBerekening($kapitaal, $intrestvoet/100, $looptijd, $limiet);