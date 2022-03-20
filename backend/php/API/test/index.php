<?php
$url_owm = "https://api.openweathermap.org/data/2.5/weather";
$key = "a1e6eae33485acdadf97f47f8b80ce60";

$stad = "Tervuren";
$lang = "nl";

$url = "$url_owm?q=$stad&lang=$lang&appid=$key&units=metric";

$curl = curl_init( $url );
curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
$curl_response = curl_exec( $curl );

print("<pre>");
print($curl_response);
print("</pre>");
