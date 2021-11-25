<?php

$tekst = "Ruim 50.000 kandidaten hengelen in Vlaanderen naar uw stem en hopen " .
    "straks gemeenteraadslid te worden. Het is maar de vraag of ze zo blij gaan " .
    "zijn als die droom in vervulling gaat. De inzet van de lokale verkiezingen, op " .
    "14 oktober, is heel precies in cijfers vastgelegd: er moeten 7.398 nieuwe " .
    "gemeenteraadsleden verkozen worden, verspreid over de 308 Vlaamse " .
    "gemeenten, plus 175 nieuwe provincieraadsleden.";


function SplitParagraph($max_lengte, $tekst, $aantal_witregels=0){
    /*
     * param $max_lengte -> de opgegeven maximum lengte van de zinnen
     * param $tekst -> de gegeven op-te-splitsen tekst
     * param $aantal_witregels -> aantal witregels na het doorlopen van de tekst.
     * default $aantal_witregels -> 0 indien niet meegegeven.
     *
     * var $output -> de string om terug te geven.
     * var $woorden -> een array van alle woorden uit de tekst (gesplitst op de " ").
     * var $lijn_lengte -> de lengte van de huidige lijn.
     */

    $output = "";
    $woorden = explode(" ", $tekst);
    $lijn_lengte = 0;

    foreach($woorden as $word) {                                    # enkel als de lengte van het woord + de lengte van de bestaande lijn de max opgegeven lengte overschrijdt
        if ($lijn_lengte + strlen($word) > $max_lengte) {           # plaats dan een linebreak voor het woord met een spatie er achter en zet de $lijn_lengte opnieuw gelijk aan
            $output .= "\n$word ";                                  # de lengte van het woord (+1 voor de spatie)
            $lijn_lengte = strlen($word) + 1;
            continue;
        }                                                           # zet een spatie achter het nieuwe woord en tel de lengte van het woord (+1 voor de spatie) op bij de lengte van de zin.
        $output .= "$word ";
        $lijn_lengte += strlen($word) + 1;
    }
    return $output .str_repeat("\n", $aantal_witregels + 1);   # op het einde nog het gewenste aantal witregels bijvoegen (+ 1 om na de tekst naar een nieuwe regel te gaan).

}

print SplitParagraph(30, $tekst, 1);
print SplitParagraph(50, $tekst);