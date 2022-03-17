<?php


    class Container{
        private $cityLoader;
        private $dbm;
        private $logger;
        private $ms;
        private $userLoader;
        private $contentManager;
        private $personLoader;

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
            return $this->cityLoader;
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
        public function getPersonLoader(){
            if( $this->personLoader == null ){
                $dbm = $this->getDbManager();
                $this->personLoader = new PersonLoader($dbm);
            }
            return $this->personLoader;
        }

        public function getContentManager(){
            if( $this->contentManager == null ){
                $dbm = $this->getDbManager();
                $ms = $this->getMessageService();
                $cl = $this->getCityLoader();
                $this->contentManager = new ContentManager($dbm, $ms, $cl);
            }
            return $this->contentManager;
        }
    }
