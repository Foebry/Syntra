<?php


function deelbaarDoor($getal, $deler){
    if ($getal%$deler == 0){
        return true;
    }
    return false;
}


$aantal = 20;
$deler = 7;

for ($i=0;$i<$aantal;$i++){
    $randomnr = random_int(100,999);
    if (deelbaarDoor($randomnr, $deler)){
        print("$randomnr is deelbaar door $deler \n");
        continue;
    };
    print($randomnr."\n");
}









function deelbaarDoorOther($aantal, $deler){
    for ($i=0;$i<$aantal;$i++){
        $getal = random_int(100,999);
        if($getal%$deler == 0){
            print "$getal is deelbaar door $deler\n";
            continue;
        }
        print $getal."\n";

    }
}

#deelbaarDoorOther($aantal, $deler);


