<?php
    class Container{

        public function __construct(array $configuration){
            $this->configuration = $configuration;
        }
        /**
        * @return PDO
        */
        public function getPDO(){
            $pdo = new PDO(
                $this->configuration["db_dsn"],
                $this->configuration["db_user"],
                $this->configuration["db_pass"]
            );

            return $pdo;
        }
    }
