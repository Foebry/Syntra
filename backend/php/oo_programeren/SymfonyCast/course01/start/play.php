<?php
    require_once "./modules/Ship.php";


    function printShipSummary(Ship $ship) :void{
        echo "Ship name: ".$ship->getName();
        echo "<br>";
        echo $ship->sayHello();
        echo "<br>";
        echo $ship->getNameAndSpecs();
        echo "<br>";
        echo $ship->getNameAndSpecs(True);
        echo "<hr>";
    }



    $ship = new Ship();
    $ship->name = "Jedi Starship";

    $other_ship = new Ship();
    $other_ship->name = "Imperial Shuttle";
    $other_ship->weapon_power = 5;
    $other_ship-> strength = 50;

    printShipSummary($ship);
    printShipSummary($other_ship);
    echo $ship->doesGivenShipHaveMoreStrangth($other_ship) ? "$other_ship->name has more strength" : "$ship->name has more strength";
