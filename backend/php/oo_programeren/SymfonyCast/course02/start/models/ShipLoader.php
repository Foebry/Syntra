<?php
    class ShipLoader{
        private $pdo;

        public function __construct(PDO $pdo){
            $this->pdo = $pdo;
        }

        /**
        * @return Ship[]
        */
        public function getShips()
        {
            $ships = [];
            $ships_data = $this->queryForShips();

            foreach($ships_data as $ship_data){
                $ships[] = $this->createShipFromData($ship_data);;
            }

            return $ships;
        }

        private function queryForShips(){
            $pdo = $this->getPDO();
            $statement = $pdo->prepare("SELECT * FROM ship");
            $statement->execute();
            $ships = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $ships;
        }

        public function findOneById($id){
            $pdo = $this->getPDO();
            $statement = $pdo->prepare("SELECT * FROM ship where id = :id");
            $statement->execute(array("id" => $id));
            $ship_data = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$ship_data) return null;

            return $this->createShipFromData($ship_data);
        }

        private function createShipFromData(array $ship_data){
            $ship = new Ship($ship_data["name"]);
            $ship->setWeaponPower($ship_data["weapon_power"]);
            $ship->setJediFactor($ship_data["jedi_factor"]);
            $ship->setStrength($ship_data["strength"]);
            $ship->setId($ship_data["id"]);

            return $ship;
        }

        /**
        * @return PDO
        */
        private function getPDO(){
            return $this->pdo;
        }
    }
