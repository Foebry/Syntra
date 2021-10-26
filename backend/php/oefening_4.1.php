<?php


function Gemiddelde($getallen_reeks): float{
    $som = 0;
    $aantal = 0;
    foreach($getallen_reeks as $getal){
        $som += $getal;
        $aantal += 1;
    }
    return $som / $aantal;
}



$lijst = [ 14, 5, 8, 9, 13, 18, 16, 25 ];
$G = Gemiddelde( $lijst ) ;
print( $G );
