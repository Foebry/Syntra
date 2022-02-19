<?php

require_once "./lib/Model/Ship.php";
require_once "./lib/Service/BattleManager.php";
require_once "./lib/Service/ShipLoader.php";
require_once "./lib/Model/BattleResult.php";
require_once "./lib/Service/Container.php";


$configuration = array(
    "db_dsn" => 'mysql:host=localhost;dbname=oo_battle',
    "db_user" => "root",
    "db_pass" => ""
);
