<?php

function step1(){
    $kaartspel = [];
    for ($i=1;$i<=13;$i++){
        for($j=0;$j<4;$j++){
            $kaartspel[] = $i;
        }
    }
    return $kaartspel;
}

function step2(){
    $kaartspel = step1();
    $speler = [];

    $kaart = random_int(0, 51);
    print($kaart);
    $speler[] = $kaartspel[$kaart];
    unset($kaartspel[$kaart]);
    return var_dump($kaartspel);
}

function step3(){
    $kaartspel = step1();
    $speler = [];
    for($i=0;$i<26;$i++){
        $kaart = random_int(0, count($kaartspel));
        $speler[] = $kaartspel[$kaart];
        unset($kaartspel[$kaart]);
        sort($kaartspel);
    }
    $computer = $kaartspel;

    return var_dump(array_count_values($speler), array_count_values($computer));
}

function step4(){
    $kaartspel = step1();
    $kaarten_speler = [];
    for ($i=0;$i<26;$i++){
        $kaart = random_int(0, count($kaartspel)-1);
        $kaarten_speler[] = $kaartspel[$kaart];
        unset($kaartspel[$kaart]);
        $kaartspel = array_values($kaartspel);
    }
    $kaarten_computer = $kaartspel;

    for ($i=0;$i<3;$i++){
        $speler = $kaarten_speler[0];
        unset($kaarten_speler[0]);
        $computer = $kaarten_computer[0];
        unset($kaarten_computer[0]);
        $kaarten_speler = array_values($kaarten_speler);
        $kaarten_computer = array_values($kaarten_computer);
        if ($speler > $computer){
            $kaarten_speler[] = $speler;
            $kaarten_speler[] = $computer;
        }
        else{
            $kaarten_computer[] = $computer;
            $kaarten_computer[] = $speler;
        }
    }
    if (count($kaarten_speler) > count($kaarten_computer)) return "Speler wint van Computer met ".count($kaarten_speler)." kaarten tegen ".count($kaarten_computer)." kaarten";
    elseif(count($kaarten_computer) > count($kaarten_speler)) return "Computer wint van Speler met ".count($kaarten_computer)." kaarten tegen ".count($kaarten_speler)." kaarten ";
    else return "Er is geen winnaar Speler heeft nog ".count($kaarten_speler)." kaarten en Computer heeft nog ".count($kaarten_computer)." kaarten.";
}

function step5(){
    $kaartspel = step1();
    $kaarten_speler = [];
    for ($i=0;$i<26;$i++){
        $kaart = random_int(0, count($kaartspel)-1);
        $kaarten_speler[] = $kaartspel[$kaart];
        unset($kaartspel[$kaart]);
        $kaartspel = array_values($kaartspel);
    }
    $kaarten_computer = $kaartspel;

    while (true){
        $spelen = readline("Wil je verder spelen? ");
        if ($spelen == 'q') break;
        $speler = $kaarten_speler[0];
        unset($kaarten_speler[0]);
        $computer = $kaarten_computer[0];
        unset($kaarten_computer[0]);
        $kaarten_speler = array_values($kaarten_speler);
        $kaarten_computer = array_values($kaarten_computer);
        if ($speler > $computer){
            $kaarten_speler[] = $speler;
            $kaarten_speler[] = $computer;
        }
        else{
            $kaarten_computer[] = $computer;
            $kaarten_computer[] = $speler;
        }
    }
    if (count($kaarten_speler) > count($kaarten_computer)) return "Speler wint van Computer met ".count($kaarten_speler)." kaarten tegen ".count($kaarten_computer)." kaarten";
    elseif(count($kaarten_computer) > count($kaarten_speler)) return "Computer wint van Speler met ".count($kaarten_computer)." kaarten tegen ".count($kaarten_speler)." kaarten ";
    else return "Er is geen winnaar Speler heeft nog ".count($kaarten_speler)." kaarten en Computer heeft nog ".count($kaarten_computer)." kaarten.";
}

function step6(){
    $kaartspel = step1();
    $kaarten_speler = [];
    for ($i=0;$i<26;$i++){
        $kaart = random_int(0, count($kaartspel)-1);
        $kaarten_speler[] = $kaartspel[$kaart];
        unset($kaartspel[$kaart]);
        $kaartspel = array_values($kaartspel);
    }
    $kaarten_computer = $kaartspel;

    while (true){
        $spelen = readline("Wil je verder spelen? ");
        if ($spelen == 'q') break;
        $speler = $kaarten_speler[0];
        unset($kaarten_speler[0]);
        $computer = $kaarten_computer[0];
        unset($kaarten_computer[0]);
        $kaarten_speler = array_values($kaarten_speler);
        $kaarten_computer = array_values($kaarten_computer);
        if ($speler > $computer){
            $kaarten_speler[] = $speler;
            $kaarten_speler[] = $computer;
        }
        else{
            $kaarten_computer[] = $computer;
            $kaarten_computer[] = $speler;
        }
    }
    $waarde_speler = 0;
    $waarde_computer = 0;
    foreach($kaarten_speler as $kaart) $waarde_speler += $kaart;
    foreach($kaarten_computer as $kaart) $waarde_computer += $kaart;
    if ($waarde_speler > $waarde_computer) return "Speler wint van Computer met ".count($kaarten_speler)." kaarten en een totale waarde van $waarde_speler tegen ".count($kaarten_computer)." kaarten en een totale waarde van $waarde_computer";
    elseif(count($kaarten_computer) > count($kaarten_speler)) return "Computer wint van Speler met ".count($kaarten_computer)." kaarten en een totale waarde van $waarde_computer tegen ".count($kaarten_speler)." kaarten en een totale waarde van $waarde_speler";
    else return "Er is geen winnaar Speler heeft nog ".count($kaarten_speler)." kaarten en Computer heeft nog ".count($kaarten_computer)." kaarten.";
}

function step7(){

}

print(step6());