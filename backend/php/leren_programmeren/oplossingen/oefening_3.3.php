<?php

include "rechts_uitlijen.php";

# breedte kolommen bepalen
const breedte_jaar = 4;
const breedte_kapitaal = 12;
const breedte_rente = 8;


function intrestBerekening($kapitaal, $intrest, $looptijd, $limiet){

    # header aanmaken
    $jaar_value = rechtsUitlijnen("Jaar", breedte_jaar);
    $kapitaal_value = rechtsUitlijnen("Kapitaal", breedte_kapitaal);
    $rente_value = rechtsUitlijnen("Rente", breedte_rente);

    $header = $jaar_value.$kapitaal_value.$rente_value;
    print($header."\n");

    for($i=1;$i<$looptijd+1;$i++){
        $limiet_overschreden = ($limiet and $kapitaal > $limiet);
        if ($limiet_overschreden) break;

        $rente = $kapitaal * $intrest;

        # rij-gegevens aanmaken
        $jaar_value = rechtsUitlijnen($i, breedte_jaar);
        $kapitaal_value = rechtsUitlijnen(number_format($kapitaal, 2), breedte_kapitaal);
        $rente_value = rechtsUitlijnen(number_format($rente, 2), breedte_rente);

        print($jaar_value.$kapitaal_value.$rente_value."\n");

        $kapitaal += $rente;
        }
}


$kapitaal = readline("Wat is het kapitaal? ");
$intrest = readline("Wat is de intrest in procenten? ");
$looptijd = readline("Wat is de looptijd? ");
$is_limiet = readline("Is er een limiet? (y/n) ");
$limiet = null;
if ($is_limiet == "y") $limiet = readline("Wat is de limiet? ");

intrestBerekening($kapitaal, $intrest/100, $looptijd, $limiet);