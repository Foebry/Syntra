<?php

require_once "./autoload.php";

$container = $_SESSION["container"];

$dbm = $container->getDbManager();
$ms = $container->getMessageService();

$id = $_POST["id"];
$table = $_POST["table"];

$sql = "delete from $table were id=$id";

$dbm->execute("delete from $table where id = $id");

$ms->addMessage("infos", "Succesvol verwijderd!");

// indien een stad verwijderd wordt
// update personen die deze stad als geboortad hadden
// en zet hun geboortestad naar de default stad
if ($table == "stad") {
    $personen = $dbm->GetData("SELECT * FROM person where cob = $id");

    foreach ($personen as $person) {
        $id = $person["id"];
        $dbm->execute("UPDATE person SET cob = 0 where id =$id");
    }
}


header("location:" . $_POST["aftersql"]);
die();
