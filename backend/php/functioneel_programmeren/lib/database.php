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

    function GetData($conn, $query){

        $data = [];

        // query uitvoeren
        $result = $conn->query($query);

        // alle rijen opvragen
        $data = $result->fetchall(PDO::FETCH_ASSOC);
        // while($row = $result->fetch(PDO::FETCH_ASSOC)){
        //     $data[] = $row;
        // }

        if (count($data) == 1) return $data[0];
        return $data;

    }

    function execute($conn, $query){
        return $conn->query($query);
    }

 ?>
