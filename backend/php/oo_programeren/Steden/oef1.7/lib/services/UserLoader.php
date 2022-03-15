<?php
    class UserLoader{
        private $dbm;

        function __construct($dbm){
            $this->dbm = $dbm;
        }

        function getAll($limit=null){
            $limit = $limit ? "limit=$limit" : "";

            $data = $this->dbm->GetData("SELECT * from user $limit");

            $users = [];

            foreach($data as $userData){
                $users[] = new User($userData);
            }
            return $users;
        }

        function getById($id){
            $userData = $this->dbm->GetData("SELECT * from user where usr_id = '$id'");
            return new User($data[0]);
        }

        function getUserByEmail($email){
            $userData = $this->dbm->GetData("select * from user where usr_email = '$email'");
            return new User($data[0]);
        }
    }
