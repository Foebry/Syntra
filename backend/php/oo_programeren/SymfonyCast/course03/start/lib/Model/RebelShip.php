<?php

    class RebelShip extends Ship{

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
    }