<?php
if (!isset($_SESSION)) session_start();

function validate($field, $values){
    if($values["datatype"] == "int"){
        validateInteger($_POST[$field], $field);
    }
    elseif($values["datatype"] == "varchar"){
        validateString($_POST[$field], $field);
    }
}

function validateCSRF(){
    if (!hash_equals($_POST["csrf"], $_SESSION["latest_csrf"])){
        return false;
    }
    return true;
}

function validateInteger($value, $field){
    // return false indien $value niet numeriek is, anders true
    if ($value == "") $value = "null";
    if (!is_numeric($value)){

        $_SESSION["ERRORS"][$field] = "$field is een numeriek veld en mag enkel numerieke waarden bevatten.";
    }
}

function validateString($value, $field){
    $_POST[$field] = htmlentities(trim($value), ENT_QUOTES);

    $not_null = $_POST["DB_HEADERS"][$field]["default"] == null;
    $max_size = $_POST["DB_HEADERS"][$field]["max_size"];
    $min_len = intval(key_exists($field."_min", $_POST) ? $_POST[$field."_min"] : 0);
    var_dump($field, $min_len);
    echo "<br>";
    $strlen = strlen($_POST[$field]);
    $fields = [
        "usr_password" => "Het wachtwoord",
        "usr_voornaam" => "Voornaam",
        "usr_naam" => "Naam",
        "usr_login" => "Login"
    ];

    if(strlen($_POST[$field]) < $min_len){
        $_SESSION["ERRORS"][$field] = "$fields[$field] moet minstens $min_len tekens bevatten";
    }
   elseif (strlen($_POST[$field]) > $max_size) {
       $_SESSION["ERRORS"][$field] = "$field is $strlen lang, maar mag maximaal $max_size lang zijn.";
   }
    elseif (strlen($_POST[$field]) == 0){
        if ($not_null){
            $_SESSION["ERRORS"][$field] = "$fields[$field] mag niet leeg zijn";
            return;
        }
        $_POST[$field] = "null";
     }
}


function ValidateUsrPassword($values){
    $passwords = explode(" ", $values);
    for($i=0;$i<count($passwords)-1;$i++){
        if ($_POST[$passwords[$i]] === $_POST[$passwords[$i+1]]) {
            $_POST[$passwords[0]] = password_hash($_POST[$passwords[0]], 1);
            return;
        }
        $_SESSION["ERRORS"][$_POST["password_verification"]] = "Wachtwoorden komen niet overeen";
    }
}
function ValidateUsrEmail($email){
    if (filter_var($_POST[$email], FILTER_VALIDATE_EMAIL)) return;
    $_SESSION["ERRORS"][$email] = "Geen geldig e-mailadres!";
}
 ?>
