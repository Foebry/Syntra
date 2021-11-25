<?php


function step1(): string
{
    $mogelijkheden = ["Blad", "Steen", "Schaar"];
    $output = "Mogelijke keuzes:\n";
    foreach($mogelijkheden as $keuze){
        $output .= "- $keuze\n";
    }

    return $output;
}

function step2(): string{
    $mogelijkheden = [1=>"Blad", 2=>"Steen", 3=>"Schaar"];
    $output = "Mogelijke keuzes:\n".str_repeat("-", 17)."\n";

    foreach($mogelijkheden as $key=>$value){
        $output .= "- Druk $key voor $value\n";
    }
    return $output;
}


function step3(): string{
    $mogelijkheden = [1=>"Blad", 2=>"Steen", 3=>"Schaar"];
    $output = "";

    for($i=1;$i<=3;$i++){
        $speler = readline("Maak een keuze: Blad, Steen of Schaar (1, 2 of 3): ");
        $computer = random_int(1, 3);

        $output .= "Ronde $i: Speler koos $mogelijkheden[$speler] en computer koos $mogelijkheden[$computer]\n";
    }
    return $output;
}

function battle1($speler, $computer): string{
    if($speler == 1 and $computer == 1) return "Gelijk, niemand wint!";
    elseif ($speler == 1 and $computer == 2) return "Speler wint!";
    elseif ($speler == 1 and $computer == 3) return "Computer wint!";
    elseif ($speler == 2 and $computer == 1) return "Computer wint!";
    elseif ($speler == 2 and $computer == 2) return "Gelijk, niemand wint!";
    elseif ($speler == 2 and $computer == 3) return "Speler wint!";
    elseif ($speler == 3 and $computer == 1) return "Speler wint!";
    elseif ($speler == 3 and $computer == 2) return "Computer wint!";
    elseif ($speler == 3 and $computer == 3) return "Gelijk, niemand wint!";
    else return "";
}

function step4(): string{
    $mogelijkheden = [1=>"Blad", 2=>"Steen", 3=>"Schaar"];
    $output = "";

    for ($i=1;$i<=3;$i++){
        $speler = readline("Maak een keuze: Blad, Steen of Schaar (1, 2 of 3): ");
        $computer = random_int(1, 3);
        $winnaar = battle1($speler, $computer);

        $output .= "Ronde $i: Speler koos $mogelijkheden[$speler] en computer koos $mogelijkheden[$computer] - $winnaar\n";
    }
    return $output;
}


function step5(): string{
    $mogelijkheden = [1=>"Blad", 2=>"Steen", 3=>"Schaar"];
    $output = "";
    $score_speler = 0;
    $score_computer = 0;
    $ronde = 1;

    while($score_speler != 3 and $score_computer != 3){
        $speler = readline("Maak een keuze: Blad, Steen of Schaar (1, 2 of 3): ");
        $computer = random_int(1, 3);
        $winnaar = battle1($speler, $computer);
        $output .= "Ronde $ronde: Speler koos $mogelijkheden[$speler] en computer koos $mogelijkheden[$computer] - $winnaar\n";
        $ronde += 1;
        print("speler: $score_speler - computer: $score_computer\n");
        if ($winnaar == "Speler wint!") $score_speler += 1;
        elseif ($winnaar == "Computer wint!") $score_computer += 1;
    }
    $ronde -= 1;
    if ($score_computer > $score_speler) $output = "Computer wint na $ronde rondes:\n".$output;
    elseif($score_speler > $score_computer) $output = "Speler wint na $ronde rondes:\n".$output;

    return $output;
}

function step6(): string{
    $mogelijkheden = [1=>"Blad", 2=>"Steen", 3=>"Schaar"];
    $output = "";
    $score_speler = 0;
    $score_computer = 0;
    $ronde = 1;

    while(abs($score_computer - $score_speler) < 2){
        $speler = readline("Maak een keuze: Blad, Steen of Schaar (1, 2 of 3): ");
        $computer = random_int(1, 3);
        $winnaar = battle1($speler, $computer);
        $output .= "Ronde $ronde: Speler koos $mogelijkheden[$speler] en computer koos $mogelijkheden[$computer] - $winnaar\n";
        $ronde += 1;
        print("speler: $score_speler - computer: $score_computer\n");
        if ($winnaar == "Speler wint!") $score_speler += 1;
        elseif ($winnaar == "Computer wint!") $score_computer += 1;
    }
    $ronde -= 1;
    if ($score_computer > $score_speler) $output = "Computer wint na $ronde rondes met ".max($score_speler, $score_computer)." punten tegen ".min($score_computer, $score_speler).":\n".$output;
    elseif($score_speler > $score_computer) $output = "Speler wint na $ronde rondes:\n".$output;

    return $output;
}

function Battle($ronde, $speler, $computer, &$uitslagen): int{
    $mogelijkheden = [1=>"Blad", 2=>"Steen", 3=>"Schaar"];
    $wincondities = [-1=>"Computer wint!", 0=>"Gelijk, niemand wint!", 1=>"Speler wint!"];

    $uitslag = $computer - $speler;
    if ($uitslag == 2) $uitslag = -1;
    elseif($uitslag == -2) $uitslag = 1;

    $uitslagen["Ronde $ronde"] = "Speler koos $mogelijkheden[$speler] en Computer koos $mogelijkheden[$computer] - $wincondities[$uitslag]";

    return $uitslag;
}

function step7(): string{
    $uitslagen = [];
    $score = 0;
    $ronde = 0;

    while (abs($score) < 2){
        $speler = readline("Maak een keuze: Blad, Steen of Schaar (1, 2 of 3): ");
        $computer = random_int(1, 3);
        $score += Battle($ronde+1, $speler, $computer, $uitslagen);
        $ronde += 1;
    }
    if ($score > 0) $output = "Speler wint na $ronde rondes:\n";
    else $output = "Computer wint na $ronde rondes\n";

    foreach($uitslagen as $ronde => $uitslag){
        $output .= "$ronde: $uitslag\n";
    }

    return $output;
}

print(step7());