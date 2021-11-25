<?php

/*
 * Betegel de vloer van de kamer.
 * Indien we een tegel moeten doorsnijden gooien we de rest van de tegel weg.
 * Dit om steeds zo groot mogelijke tegels(tukken) te gebruiken.
 *
 * Bereken dan eerst hoeveel tegels er nodig zijn om de lengte volledig te betegelen.
 * Bereken daarna hoeveel tegels er nodig zijn om de breedte volledig te betegelen.
 * Bereken dan het totaal aantal tegels nodig door aantal voor lengte te vermenigvuldigen
 * met aantal voor breedte.
 */

function kamerBetegelen($lengte_kamer, $breedte_kamer, $lengte_tegel, $breedte_tegel): string{
    $aantal_tegels_lengte = ceil($lengte_kamer / $lengte_tegel);
    $aantal_tegels_breedte = ceil($breedte_kamer / $breedte_tegel);
    $aantal_tegels = $aantal_tegels_lengte * $aantal_tegels_breedte;

    $output = "Je moet %d tegels van %.1f x %.1f meter kopen voor een kamer van %d op %d meter";

    return sprintf($output, $aantal_tegels, $lengte_tegel, $breedte_tegel, $lengte_kamer, $breedte_kamer);
}

$lengte_kamer = readline("Wat is de lengte van de kamer?(m) ");
$breedte_kamer = readline("Wat is de breedte van de kamer?(m) ");
$lengte_tegel = readline("Wat is de lengte van de tegel?(m) ");
$breedte_tegel = readline("Wat is de breedte van de tegel?(m) ");

print kamerBetegelen($lengte_kamer, $breedte_kamer, $lengte_tegel, $breedte_tegel);