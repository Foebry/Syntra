<?php

$rek=[
    'BE75832844265251',
    'BE05352906338775',
    'BE78793503484086',
    'BE02930902902740',
    'BE54679368522400',
    'BE79481522145939',
    'BE45238582867689',
    'BE90351463032632',
    'BE85594736411006',
    'BE43534698638801',
    'BE39862582066154',
    'BE96936741435905',
    'BE06120041275522',
    'BE42102532381041',
    'BE27643075640273',
    'BE44150090238545',
    'BE05501206942175',
    'BE38008704680572',
    'BE19295595075512',
    'BE18319809423665'
];

$foutieve_bankrekeningen = [];

function isGeldigNummber($bankrekening): bool{
    $check_digit = substr($bankrekening, 14);
    $controle = substr($bankrekening, 4, 10);

    if ($check_digit == "00") $check_digit = 97;
    if ($controle % 97 == $check_digit) return true;

    return false;
}
# Indien een bankrekening niet geldig is, voeg deze toe aan array foutieve_bankrekeningen
foreach ($rek as $bankrekening){
    if (!isGeldigNummber($bankrekening)) $foutieve_bankrekeningen[] = $bankrekening;
}

# Indien er geen foutieve bankrekeningen gevonden werden
if (count($foutieve_bankrekeningen) == 0){
    print("Geen foutieve bankrekeningnummers gevonden!");
    exit();
}

# print alle foutieve bankrekeningen.
foreach($foutieve_bankrekeningen as $bankrekening){
    printf("Bankrekening %s is FOUT HOOR !!!\n", $bankrekening);
}