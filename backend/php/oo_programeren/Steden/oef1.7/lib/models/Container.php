<?php


    class Container{
        private $city_loader;
        private $dbm;
        private $logger;
        private $ms;
        private $user_loader;
        private $contentManager;

        public function __construct(){
            $this->cityLoader = null;
            $this->dbm = null;
            $this->logger = null;
            $this->ms = null;
            $this->userLoader = null;
            $this->contentManager = null;
        }

        public function getCityLoader(){
            if($this->cityLoader == null){
                $dbm = $this->getDbManager();
                $this->cityLoader = new CityLoader($dbm);
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
            if ($this->userLoader == null){
                $dbm = $this->getDbManager();
                $this->userLoader = new UserLoader($dbm);
            }
            return $this->userLoader;
        }

        public function getContentManager($h1, $h2=""){
            if( $this->contentManager == null ){
                $dbm = $this->getDbManager();
                $ms = $this->getMessageService();
                $this->contentManager = new ContentManager($dbm, $ms, $h1, $h2);
            }
            return $this->contentManager;
        }
    }
