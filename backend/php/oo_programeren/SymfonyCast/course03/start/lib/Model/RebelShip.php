<?php

    class RebelShip extends AbstractShip{

        public function getFavoriteJedi(){
            $cool_jedis = ["Yoda", "Ben Kenobi"];
            $key = array_rand($cool_jedis);

            return $cool_jedis[$key];
        }

        public function getType(){
            return "Rebel";
        }

        public function isFunctional()
        {
            return True;
        }

        public function getNameAndSpecs($useShortFormat = false)
        {
            $val = parent::getNameAndSpecs($useShortFormat);
            $val .= " (Rebel)";

            return $val;
        }

        public function getJediFactor() :int{
            return rand(10, 30);
        }
    }
