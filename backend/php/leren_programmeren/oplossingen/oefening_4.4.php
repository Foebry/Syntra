<?php

$student =  [
    "voornaam"=> "Jan",
    "naam"=> "Janssens",
    "straat"=> "Oude baan",
    "huisnr"=> "22",
    "postcode"=> 2800,
    "gemeente"=> "Mechelen",
    "geboortedatum"=> "14/05/1991",
    "telefoon"=> "015 24 24 26",
    "e-mail"=> "jan.janssens@gmail.com"
];

function makeHeader($level, $string): string{
    return "<h$level>$string</h$level>\n";
}

function makeTable($data): string{
    $string = "<table>\n";
    foreach($data as $key => $value){
        $string .= "<tr><td>$key</td><td>$value</td></tr>\n";
    }
    return $string."</table>";
}

function StudentToTable($student_data): string{

    return makeHeader(1, "Student").makeTable($student_data);

}

#print StudentToTable($student);
