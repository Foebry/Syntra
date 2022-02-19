<?php
    interface ShipStorageInterface{
        /**
        * Returns an array of ship arrays, with keys id name weaponPoweer, defense.
        *
        * @return array
        */
        public function fetchAllShipsData();

        /**
        * @param int $id
        * @return array
        */
        public function fetchSingleShipData($id);
    }
