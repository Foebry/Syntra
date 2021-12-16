<?php
require_once "./database.php";

function validateForm($data, $table){
    // Geldig formulier indien volgende zijn allen geldig
    // title, filename, width, height

    if (!validTitle($data["title"]) == false) return "invalid title";
    if (!validFilename($data["filename"])) return "invalid filename";
    if (!validWidth($data["width"])) return "invalid width";
    if (!validHeight($data["height"])) return "invalid height";
    return true;

}

function validTitle($title):bool{
    //geldige titel indien type title = string en max characters = 255
    if ((gettype($title) == "string") and (strlen($title) <= 255)) return true;
    return false;
}

function validFilename($filename):bool{
    //geldige filename indien type filename = string en max characters = 255
    if (gettype($filename) == "string" and strlen($title) <= 255) return true;
    return false;
}

function validWidth($width):bool{
    //geldige width indien type width = integer
    if (gettype($width) == "integer");
    return false;
}

function validHeight($height):bool{
    //geldige height indien type height = integer
    if (gettype($width) == "integer");
    return false;
}
 ?>
