<?php

    $dbm = new DbManager();
    $city_loader = new CityLoader();


    class Container{
        private $city_loader;
        private $db;

        function __construct($credentials){
            $this->db = $this->connectDB($config);

        }
        function connectDB($config){
            $root = $_SERVER["DOCUMENT_ROOT"];
            // laad content config.json in
            $file = file_get_contents("$root/config.json");
            // hervorm json naar een associatieve array en navigeer "DATABASE" key.
            $data = json_decode($file, true)["DATABASE"];

            // maak connectie met de db en geef het connectie object terug
            $dsn = "mysql:dbname=".$data["dbname"].";host=".$data["host"];

            return new PDO(
                            $dsn,
                            $user = $data["username"],
                            $password = $data["password"]
                        );
        }

    }
