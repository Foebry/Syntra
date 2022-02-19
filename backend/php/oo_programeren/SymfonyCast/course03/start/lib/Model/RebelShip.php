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

        public function getNameAndSpecs($useShortFormat = false)
        {
            if ($useShortFormat) {
                return sprintf(
                    '%s: %s/%s/%s (Rebel)',
                    $this->getName(),
                    $this->getWeaponPower(),
                    $this->getJediFactor(),
                    $this->getStrength()
                );
            } else {
                return sprintf(
                    '%s: w:%s, j:%s, s:%s (Rebel)',
                    $this->getName(),
                    $this->getWeaponPower(),
                    $this->getJediFactor(),
                    $this->getStrength()
                );
            }
        }
    }
