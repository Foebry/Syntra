<?php


const MAX_LENGTH = 40;


$tekst = "Ruim 50.000 kandidaten hengelen in Vlaanderen naar uw stem en hopen " .
    "straks gemeenteraadslid te worden. Het is maar de vraag of ze zo blij gaan " .
    "zijn als die droom in vervulling gaat. De inzet van de lokale verkiezingen, op " .
    "14 oktober, is heel precies in cijfers vastgelegd: er moeten 7.398 nieuwe " .
    "gemeenteraadsleden verkozen worden, verspreid over de 308 Vlaamse " .
    "gemeenten, plus 175 nieuwe provincieraadsleden.";

$woorden = explode(" ", $tekst);
$line_width = 0;

foreach($woorden as $word) {
    if ($line_width + strlen($word) > MAX_LENGTH) {
        print "\n". $word. " " ;
        $line_width = strlen($word) + 1;
        continue;
    }
    print $word . " ";
    $line_width += strlen($word) + 1;
}


