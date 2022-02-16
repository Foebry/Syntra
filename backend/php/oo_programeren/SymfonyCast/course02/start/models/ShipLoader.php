<?php
    class ShipLoader{

        public function getShips()
        {
            $ships = [];

            $ship = new Ship("Jedi Starfighter");
            $ship->setWeaponPower(5);
            $ship->setJediFactor(15);
            $ship->setStrength(30);

            $ship2 = new Ship("CloakShape Fighter");
            $ship2->setWeaponPower(2);
            $ship2->setJediFactor(2);
            $ship2->setStrength(70);

            $ship3 = new Ship("Super Star Destroyer");
            $ship3->setWeaponPower(70);
            $ship3->setJediFactor(0);
            $ship3->setStrength(500);

            $ship4 = new Ship("RZ-1 A-wing interceptor");
            $ship4->setWeaponPower(4);
            $ship4->setJediFactor(4);
            $ship4->setStrength(40);

            $ships["Jedi Starfighter"] = $ship;
            $ships["CloakShape Fighter"] = $ship2;
            $ships["Super Star Destroyer"] = $ship3;
            $ships["RZ-1 A-wing interceptor"] = $ship4;

            return $ships;
        }
    }
