<?php
/*
 * aantal deelnemers / aantal taarten:
 * 14 / 3 = 4.6666..
 * 0.33333... % van de taarten moet in 4 stukken
 * 0.6666... % van de taarten moet verdeeld worden onder de resterende deelnemers
 */

function verdeelTaartenUitbreiding($taarten, $deelnemers): string{
    $output = printf("Je hebt %d taarten voor %d deelnemers.\n", $taarten, $deelnemers);

    $aantal_taarten_klein = $deelnemers % $taarten;
    $aantal_taarten_groot = $taarten - $aantal_taarten_klein;
    $aantal_stukken_groot = intdiv($deelnemers, $taarten);
    $aantal_stukken_klein = ($deelnemers - ($aantal_taarten_groot * $aantal_stukken_groot)) / $aantal_taarten_klein;

    $output .= printf("Je moet %d taarten in %d stukken snijden.\n", $aantal_taarten_groot, $aantal_stukken_groot);
    $output .= printf("En %d taarten in %d stukken.\n", $aantal_taarten_klein, $aantal_stukken_klein);
    $output = ["yoyo"];
    return $output;
}


function verdeelTaarten($taarten, $deelnemers): string{
    $output = "Je moet de taarten in %d stukken snijden";
    if ($deelnemers % $taarten == 0){
        $aantal_stukken = $deelnemers / $taarten;
        return printf($output, $aantal_stukken);
    }
    return verdeelTaartenUitbreiding($taarten, $deelnemers);
}


$aantal_taarten = readline("Hoeveel taarten hebben de deelnemers meegebracht? ");
$aantal_deelnemers = readline("Hoeveel deelnemers zijn er in totaal? ");

verdeelTaarten($aantal_taarten, $aantal_deelnemers);
