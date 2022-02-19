<?php

$configuration = array(
    'db_dsn'  => 'mysql:host=localhost;dbname=oo_battle',
    'db_user' => 'root',
    'db_pass' => null,
);

require_once __DIR__.'/lib/Service/Container.php';
require_once __DIR__.'/lib/Model/AbstractShip.php';
require_once __DIR__.'/lib/Model/BrokenShip.php';
require_once __DIR__.'/lib/Model/Ship.php';
require_once __DIR__.'/lib/Model/RebelShip.php';
require_once __DIR__.'/lib/Service/BattleManager.php';
<<<<<<< HEAD
<<<<<<< HEAD
=======
require_once __DIR__.'/lib/Service/AbstractShipStorage.php';
=======
require_once __DIR__.'/lib/Service/ShipStorageInterface.php';
>>>>>>> ed65981 (ep3 chapter 10)
require_once __DIR__.'/lib/Service/PdoShipStorage.php';
require_once __DIR__.'/lib/Service/JsonFileShipStorage.php';
>>>>>>> c457d80 (chapter 9)
require_once __DIR__.'/lib/Service/ShipLoader.php';
require_once __DIR__.'/lib/Model/BattleResult.php';
