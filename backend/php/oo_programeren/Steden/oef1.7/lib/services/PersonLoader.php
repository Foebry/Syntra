<?php

    class PersonLoader implements LoaderInterface{

        public function __construct($dbm){
            $this->dbm = $dbm;
            $this->personTypes = [
                "acteur" => "Actor",
                "auteur" => "Author",
                "zanger" => "Singer",
                "zangeres" => "Singer"
            ];
        }

        function getAll($limit=null){
            $limit = $limit ? "limit = $limit" : "";
            $data = $this->dbm->GetData("SELECT * FROM person $limit");

            $personList = [];
            foreach($data as $personData){
                $personType = $personData["type"];
                // Maak nieuwe Person aan naargelang het type van de persoon.
                // Indien type "actor" is, wordt een nieuwe Actor aangemaakt,
                // indien type "writer" is, wordt een nieuwe Writer aangemaakt
                // indien type "singer" is, wordt een nieuwe Singer aangemaakt
                $personList[] = new $this->personTypes[$personType]($personData);
            }
            return $personList;
        }

        function getById($id){
            $personData = $this->dbm->GetData("SELECT * from person where id = $id")[0];

            $personType = $personData["type"];

            // Maak nieuwe Person aan naargelang het type van de persoon.
            // Indien type "actor" is, wordt een nieuwe Actor aangemaakt,
            // indien type "writer" is, wordt een nieuwe Writer aangemaakt
            // indien type "singer" is, wordt een nieuwe Singer aangemaakt
            return new $this->personTypes[$personType]($personData);
        }
    }