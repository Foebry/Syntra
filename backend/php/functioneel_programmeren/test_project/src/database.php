<?php

    function connectDb($host, $user, $password, $password){
        return new sqli($host, $database, $user, $password);
    }

    function GetData($conn, $query){
        return $conn->query($query);
    }

 ?>
