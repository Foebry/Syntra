<?php

    class PersonLoader implements LoaderInterface{

        public function __construct($dbm){
            $this->dbm = $dbm;
        }

        function getAll($limit=null){
            $limit = $limit ? "limit = $limit" : "";
            $data = $this->dbm->GetData("SELECT * FROM person $limit");

            $personList = [];
            foreach($data as $personData){
                $personList[] = new Person($personData);
            }
            return $personList;
        }

        function getById($id){
            $personData = $this->dbm->GetData("SELECT * from person where per_id = $id");

            return new Person($personData);
        }
    }