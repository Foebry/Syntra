<?php class Ship {
        private $name;
        private $weapon_power = 0;
        private $jedi_factor = 0;
        private $strength = 0;
        private $under_repair;

        public function __construct($name){
            $this->setName($name);
            $this->under_repair = mt_rand(1, 100) < 30;
        }

        public function setStrength($str){
            if (!is_numeric($str)){
                throw new Exception('Invalid strength passed');
            }
            $this->strength = $str;
        }

        public function getStrength(){
            return $this->strength;
        }
        public function setName($name){
            $this->name = $name;
        }
        public function getName() :string{
            return $this->name;
        }

        public function setJediFactor($factor){
            $this->jedi_factor = $factor;
        }
        public function getJediFactor(){
            return $this->jedi_factor;
        }

        public function setWeaponPower($power){
            $this->weapon_power = $power;
        }
        public function getWeaponPower(){
            return $this->weapon_power;
        }

        public function isFunctional(){
            return !$this->under_repair;
        }


        public function sayHello(){
            echo "Hello!";
        }

        public function getNameAndSpecs(bool $use_short_format=false) :string{
            return $use_short_format ?
            sprintf(
                '%s: %s/%s/%s',
                $this->name,
                $this->weapon_power,
                $this->jedi_factor,
                $this->strength
            )
            :
            sprintf(
                '%s (w:%s, j:%s, s:%s)',
                $this->name,
                $this->weapon_power,
                $this->jedi_factor,
                $this->strength
            );
        }

        public function doesGivenShipHaveMoreStrangth(Ship $ship) :bool{
            return $this->strength < $ship->strength;
        }
    }
