<?php

    function connectDb(){
        // read config.json
        $file = file_get_contents("../config.json");
        //convert json to associative array and navigate down to "DATABASE" key
        $data = json_decode($file, true)["DATABASE"];

        // create and return connection
        $dsn = "mysql:dbname=".$data["dbname"].";host=".$data["host"];

        return new PDO(
                        $dsn,
                        $user = $data["username"],
                        $password = $data["password"]
                    );
    }

    function GetData($conn, $query, $params=null){

        // query uitvoeren
        $data = $conn->query($query);

        // alle rijen opvragen en als array teruggeven
        return $data->fetchAll();
    }

    function execute($conn, $query){
        return $conn->query($query);
    }

 ?>
