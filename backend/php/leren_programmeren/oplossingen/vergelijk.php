<?php


function vergelijkMet100(int $getal): string{
    if ($getal > 100){
        return "groter dan";
    }
    elseif ($getal < 100){
        return "kleiner dan";
    }
    return "gelijk aan";
}


$getallen = [];

for($i=0;$i<3;$i++){
    $getal = readline("Geef een getal in: ");
    array_push($getallen, $getal);
    printf("%d is ".vergelijkMet100($getal)." 100\n", $getal);
}