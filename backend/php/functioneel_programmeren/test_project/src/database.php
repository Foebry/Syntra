<?php

    function connectDb($host, $user, $password, $database){
        return new mysqli($host, $user, $password, $database);
    }

    function GetData($conn, $query){
        $rows = [];
        $data = $conn->query($query);
        while( $row = $data->fetch_assoc() ){
            $rows[] = $row;
        }
        return $rows;
    }

 ?>
