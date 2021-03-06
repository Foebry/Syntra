<?php

class ShipLoader
{
    private $pdo;

<<<<<<< HEAD
<<<<<<< HEAD
    public function __construct(PDO $pdo)
=======
    public function __construct(AbstractShipStorage $shipStorage)
>>>>>>> c457d80 (chapter 9)
=======
    public function __construct(ShipStorageInterface $shipStorage)
>>>>>>> ed65981 (ep3 chapter 10)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return AbstractShip[]
     */
    public function getShips()
    {
        $ships = array();

        $shipsData = $this->queryForShips();

        foreach ($shipsData as $shipData) {
            $ships[] = $this->createShipFromData($shipData);
        }

        return $ships;
    }

    /**
     * @param $id
     * @return AbstractShip
     */
    public function findOneById($id)
    {
        $statement = $this->getPDO()->prepare('SELECT * FROM ship WHERE id = :id');
        $statement->execute(array('id' => $id));
        $shipArray = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$shipArray) {
            return null;
        }

        return $this->createShipFromData($shipArray);
    }

    private function createShipFromData(array $shipData)
    {
        if($shipData["team"] == "rebel"){
            $ship = new RebelShip($shipData["name"]);
        }
        else{
            $ship = new Ship($shipData['name']);
            $ship->setJediFactor($shipData['jedi_factor']);
        }
        $ship->setId($shipData['id']);
        $ship->setWeaponPower($shipData['weapon_power']);
        $ship->setStrength($shipData['strength']);

        return $ship;
    }

    /**
     * @return PDO
     */
    private function getPDO()
    {
        return $this->pdo;
    }

    private function queryForShips()
    {
        $statement = $this->getPDO()->prepare('SELECT * FROM ship');
        $statement->execute();
        $shipsArray = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $shipsArray;
    }
}
