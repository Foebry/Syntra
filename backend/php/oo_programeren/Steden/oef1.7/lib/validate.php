<?php

if (!isset($_SESSION)) session_start();

$container = $_SESSION["container"];
$dbm = $container->getDbManager();
$ms = $container->getMessageService();


function validate($field, $values, $dbm, $ms){
    /**
    * functie die de het meegegeven veld zal valideren.
    * @param $field: kolomhoofd
    * @param $values: eigenschappen van de kolom.
    * @type $field: string
    * @type $values: array(string => string|int)
    */

    $not_null = $_POST["DB_HEADERS"][$field]["is_null"] == "NO";
    $unique = $_POST["DB_HEADERS"][$field]["key"] == "UNI";
    $fields = [
        "usr_password" => "Het wachtwoord",
        "usr_voornaam" => "Voornaam",
        "usr_naam" => "Deze Naam",
        "usr_email" => "Dit e-mailadres",
        "cob" => "geboortestad"

    ];
    $_POST[$field] = $_POST[$field] == "" ? "null" : $_POST[$field];
    # indien de ingevoerde waarde leeg is, ga na of dit veld in de databank leeg mag zijn,
    # zoniet, zet de correcte error message en return;
    if ($not_null and $_POST[$field] == "null"){
        $msg = "$fields[$field] mag niet leeg zijn";
        $ms->addMessage("input_errors", $msg, $field);
        return;
    }
    # indien het veld uniek is in de databank, ga na of deze waarde nog niet bestaat.
    # indien wel het geval, zet de correcte error message en return.
    if ($unique){
        if ($dbm->getData("select $field from ".$_POST["table"]." where $field = "."'".$_POST[$field]."'")){
            $msg = "$fields[$field] is al in gebruik";
            $ms->addMessage("input_errors", $msg, $field);
            return;
        }
    }
    if($values["datatype"] == "int"){
        validateInteger($_POST[$field], $field, $fields, $ms);
    }
    elseif($values["datatype"] == "varchar"){
        validateString($_POST[$field], $field, $fields, $ms);
    }
}

function validateCSRF(){
    /**
    * functie die het csrf-token zal valideren
    *
    * @return: boolean
    */
    return hash_equals($_POST["csrf"], $_SESSION["latest_csrf"]);
}

function validateInteger($value, $field, $fields, $ms){
    /**
    * functie die een integer veld zal valideren.
    * @param $value: waarde ingegeven door de gebruiker.
    * @param $field: kolomhoofd
    * @type $value: int
    * @type $field: string
    */

    if (!is_numeric($value)){
        $msg = "$fields[$field] is een numeriek veld en mag enkel numerieke waarden bevatten";
        $ms->addMessage("input_error", $msg, $field);
    }
}

function validateString($value, $field, $fields, $ms){
    /**
    * functie die een string veld zal valideren.
    * @param $value: waarde ingegeven door de gebruiker
    * @param $field: kolomhoofd
    * @type $value: string
    * @type $field: string
    *
    * @return: null
    */

    # sanitization
    $_POST[$field] = htmlentities(trim($value), ENT_QUOTES);

    $not_null = $_POST["DB_HEADERS"][$field]["is_null"] == "NO";
    $max_size = $_POST["DB_HEADERS"][$field]["max_size"];
    $unique = $_POST["DB_HEADERS"][$field]["key"] == "UNI";
    $min_len = intval(key_exists($field."_min", $_POST) ? $_POST[$field."_min"] : 0);

    $strlen = strlen($_POST[$field]);
    $fields = [
        "usr_password" => "Het wachtwoord",
        "usr_voornaam" => "Voornaam",
        "usr_naam" => "Naam",
        "usr_email" => "e-mailadres",

    ];

    # indien de lengte van de ingevoerde waarde langer is dan de toegelaten lengte,
    # of net te kort, zet de correcte error messages voor de respectievelijke fouten.
    if(strlen($_POST[$field]) < $min_len){
        $msg = "$fields[$field] moet minstens $min_len tekens bevatten";
        $ms->addMessage("input_errors", $msg, $field);
    }
   elseif (strlen($_POST[$field]) > $max_size) {
       $msg = "$fields[$field] is $strlen lang, maar mag maximaal $max_size lang zijn.";
       $ms->addMessage("input_errors", $msg, $field);
   }
}

function ValidateUsrPassword($values, $ms){
    $passwords = explode(" ", $values);

    for($i=0;$i<count($passwords)-1;$i++){
        if ($_POST[$passwords[$i]] === $_POST[$passwords[$i+1]]) {
            $_POST[$passwords[0]] = password_hash($_POST[$passwords[0]], 1);
            return;
        }
        $msg = "Wachtwoorden komen niet overeen";
        $ms->addMessage("input_errors", $msg, "usr_password_verification");
    }
}
function ValidateUsrEmail($email, $ms){
    if (filter_var($_POST[$email], FILTER_VALIDATE_EMAIL)) return;
    $msg = "Geen geldig e-mailadres!";
    $ms->addMessage("input_errors", $msg, "usr_email");
}
 ?>
