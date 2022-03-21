<?php


    class Container{
        private $city_loader;
        private $dbm;
        private $logger;
        private $ms;
        private $user_loader;

        public function __construct(){
            $this->city_loader = null;
            $this->dbm = null;
            $this->logger = null;
            $this->ms = null;
            $this->user_loader = null;
        }

        public function getCityLoader(){
            if($this->city_loader == null){
                $dbm = $this->getDbManager();
                $this->city_loader = new CityLoader($dbm);
            }
            return $this->city_loader;
        }

        public function getDbManager(){
            if($this->dbm == null){
                $logger = $this->getLogger();
                $this->dbm =  new DbManager($logger);
            }
            return $this->dbm;
        }

        public function getLogger(){
            if ($this->logger == null){
                $this->logger = new Logger();
            }
            return $this->logger;
        }

        public function getMessageService(){
            if ($this->ms == null){
                $this->ms = new MessageService();
            }
            return $this->ms;
        }

        public function getUserLoader(){
            if ($this->user_loader == null){
                $dbm = $this->getDbManager();
                $this->user_loader = new UserLoader($dbm);
            }
            return $this->user_loader;
        }
    }
