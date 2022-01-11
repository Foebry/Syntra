<?php
if (!isset($_SESSION)) session_start();

$old_post = [];
$errors = [];
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
