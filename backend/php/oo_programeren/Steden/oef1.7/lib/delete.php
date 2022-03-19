<?php

    require_once "./autoload.php";

    $container = $_SESSION["container"];

    $dbm = $container->getDbManager();
    $ms = $container->getMessageService();

    $id = $_POST["id"];
    $table = $_POST["table"];

    $sql = "delete from $table were id=$id";

    $dbm->execute("delete from $table where id = $id");

    $ms->addMessage("infos", "verwijderen succesvol!");

    header("location:".$_POST["aftersql"]);
    die();
    

