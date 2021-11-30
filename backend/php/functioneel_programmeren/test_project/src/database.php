<?php

    function connectDb($host, $user, $password, $database){
        return new mysqli($host, $user, $password, $database);
    }

    function GetData($conn, $query){
        return $conn->query($query);
    }

 ?>
