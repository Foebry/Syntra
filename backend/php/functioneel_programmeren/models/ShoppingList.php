<?php
    class ShoppingList{
        # properties of the ShoppingList class
        # can be private, public or protected
        private $shop;
        private $date;
        private $items = [];

        public function __constructor(string $shop="", DateTime $date=null, array $items=[]){
            $this->shop = $shop;
            $this->date = $date;
            $this->items = $items;
        }

        public function setShop($name){
            $this->shop = $name;
        }
        public function setDate($date=null){
            if(!$date) return $this->date = new DateTime();
            $this->date = $date;
        }
        public function setItems($items){
            foreach($items as $item){
                $this->items[] = $item;
            }
        }
        public function getShop(){
            return $this->shop;
        }
        public function getListDate(){
            return $this->date;
        }
        public function getItems(){
            return $this->items;
        }
    }
