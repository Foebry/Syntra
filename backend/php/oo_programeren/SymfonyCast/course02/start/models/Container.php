<?php
    class Container{

        private $pdo;
        private $ship_loader;
        private $battle_manager;


        public function __construct(array $configuration){
            $this->configuration = $configuration;
        }
        /**
        * @return PDO
        */
        public function getPDO(){

            if ($this->pdo === null){
                $this->pdo = new PDO(
                    $this->configuration["db_dsn"],
                    $this->configuration["db_user"],
                    $this->configuration["db_pass"]
                );
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }

            return $this->pdo;
        }

        /**
        *   @return ShipLoader
        */
        public function getShipLoader() :ShipLoader{
            if($this->ship_loader === null){
                $this->ship_loader = new ShipLoader($this->getPDO());
            }
            return $this->ship_loader;
        }

        /**
        * @return BattleManager
        */
        public function getBattleManager() :BattleManager{
            if($this->battle_manager === null){
                $this->battle_manager = new BattleManager();
            }
            return $this->battle_manager;
        }
    }
