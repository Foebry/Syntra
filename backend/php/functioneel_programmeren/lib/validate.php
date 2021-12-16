<?php
if (!isset($_SESSION)) session_start();

function validate($field, $values){
    if($values["datatype"] == "int"){
        if (!validateInteger($_POST[$field])){
            exit(print("$field moet een integer zijn en mag enkel numerieke waarden bevatten"));
        }
    }
    elseif($values["datatype"] == "varchar"){
        if (!validateString($_POST[$field], $field)){
            $length = strlen($_POST[$field]);
            $max_length = $values["max_size"];
            exit(print("$field is $length lang, maar mag maximaal $max_length lang zijn"));
        }

    }
}

function validateCSRF(){
    if (!hash_equals($_POST["csrf"], $_SESSION["latest_csrf"])){
        return false;
    }
    return true;
}

function validateInteger($value){
    // return false indien $value niet numeriek is, anders true
    return !is_numeric($value) ? false : true;
}

function validateString($value, $field){
    $_POST[$field] = htmlentities(trim($value), ENT_QUOTES);

    $max_size = $_POST["DB_HEADERS"][$field]["max_size"];

    if (strlen($_POST[$field]) > $max_size) return false;

    return true;
}
 ?>
