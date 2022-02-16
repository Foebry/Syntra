<?php
if (!isset($_SESSION)) session_start();

require_once "database.php";
require_once "security.php";
require_once "html_components.php";
require_once "access_control.php";


$old_post = [];
$errors = [];
$status = [];
$info = "";

if (key_exists("OLD_POST", $_SESSION)){
    $old_post = $_SESSION["OLD_POST"];
    $_SESSION["OLD_POST"] = [];
}
if (key_exists("ERRORS", $_SESSION)){
    $errors = $_SESSION["ERRORS"];
    $_SESSION["ERRORS"] = [];
}
if (key_exists("INFO", $_SESSION)){
    $info = $_SESSION["INFO"];
    $_SESSION["INFO"] = "";
}
if (key_exists("STATUS", $_SESSION)){
    $status = $_SESSION["STATUS"];
    $_SESSION["STATUS"] = [];
}
