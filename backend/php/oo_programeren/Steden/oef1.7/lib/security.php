<?php

if (!isset($_SESSION)) session_start();

$root = $_SERVER["DOCUMENT_ROOT"];

$container = $_SESSION["container"];
$ms = $container->getMessageService();
$dbm = $container->getDbManager();

function LoginCheck($dbm, $ms): bool{
    $where = " where usr_email = '".$_POST["usr_email"]."'";

    $sql = "select usr_password from ".$_POST["table"]. $where;
    $data = $dbm->getData("select usr_password from ".$_POST["table"]. $where);

    if ( count($data) == 0) {
        $msg = "Dit email adress is niet bekend.";
        $ms->addMessage("input_errors", $msg, "usr_email");
        exit(header("location:../?login"));
    }
    if( key_exists("usr_password", $data[0]) AND !password_verify($_POST["usr_password"], $data[0]["usr_password"])){
        $msg = "Wachtwoord onjuist!";
        $ms->addMessage("input_errors", $msg, "usr_password");
        exit(header("location:../?login"));
    };

    return True;
}

 ?>
