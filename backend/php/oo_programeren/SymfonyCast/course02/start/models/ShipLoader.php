<?php
    class ShipLoader{

        public function getShips()
        {
            $ships = [];
            $ships_data = $this->queryForShips();

            foreach($ships_data as $ship_data){
                $ship = new Ship($ship_data["name"]);
                $ship->setWeaponPower($ship_data["weapon_power"]);
                $ship->setJediFactor($ship_data["jedi_factor"]);
                $ship->setStrength($ship_data["strength"]);

                $ships[] = $ship;
            }

            return $ships;
        }

        private function queryForShips(){
            $pdo = new PDO('mysql:host=localhost;dbname=oo_battle', "root");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $statement = $pdo->prepare("SELECT * FROM ship");
            $statement->execute();
            $ships = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $ships;
        }
    }
