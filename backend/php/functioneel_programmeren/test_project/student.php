<?php

$student =	array(
"voornaam" =>  "Jan",
"naam" =>  "Janssens",
"straat" =>  "Oude baan",
"huisnr" =>  "22",
"postcode" =>  2800,
"gemeente" =>  "Mechelen",
"geboortedatum" =>  "14/05/1991",
"telefoon" =>  "015 24 24 26",
"e-mail" =>  "jan.janssens@gmail.com"
);


function StudentToTable($student){
  $table = "
  <h1>Student</h1>
  <table>
    <tr><td>Voornaam</td><td>{$student['voornaam']}</td></tr>
    <tr><td>Naam</td><td>{$student['naam']}</td></tr>
    <tr><td>Straat</td><td>{$student['straat']}</td></tr>
    <tr><td>Huisnr</td><td>{$student['huisnr']}</td></tr>
    <tr><td>Postcode</td><td>{$student['postcode']}</td></tr>
    <tr><td>Gemeente</td><td>{$student['gemeente']}</td></tr>
    <tr><td>Geboortedatum</td><td>{$student['geboortedatum']}</td></tr>
    <tr><td>Telefoon</td><td>{$student['telefoon']}</td></tr>
    <tr><td>E-mail</td><td>{$student['e-mail']}</td></tr>
  </table>
";

  return $table;

}
 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Oefeningen</title>
 </head>
 <body>
   <?php
     echo StudentToTable($student);
    ?>
 </body>
 </html>
