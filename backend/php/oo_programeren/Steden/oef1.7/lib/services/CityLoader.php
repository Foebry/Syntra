<?php
    class CityLoader implements LoaderInterface{
        private $dbm;

        function __construct($dbm){
            $this->dbm = $dbm;
        }

        function getAll($limit=False) :array{
            $cities = [];
            $limit = $limit ? "limit $limit" : "";

            $sql = "SELECT * from images $limit";
            $data = $this->dbm->GetData($sql);

            foreach($data as $row){
                $cities[] = new City($row);
            }

            return $cities;
        }


        function getById(int $id) :City{
            $data = $this->dbm->GetData("Select * from images where img_id = $id");
            return new City($data[0]);
        }
    }
