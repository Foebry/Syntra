<?php
//Input associative array
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

Function StudentToTable($student)
{
    Echo"<h1>Student</h1>\n <table>\n";
    Foreach($student as $student=>$data)
    {
        printf("<tr><td>".ucfirst($student)."</td><td>".ucfirst($data)."</td></tr>\n"); // Zet de eerste letter om naar een hoofdletter
    }
    Echo"</table>";
}
#Echo StudentToTable($student);