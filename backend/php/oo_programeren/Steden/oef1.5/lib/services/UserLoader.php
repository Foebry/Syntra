<?php
    class UserLoader{
        private $dbm;

        function __construct($dbm){
            $this->dbm = $dbm;
        }

        function getUserByEmail($email){
            $data = $dbm->GetData("select * from user where usr_email = '$email'");
            return new User($data[0]);
        }
    }
