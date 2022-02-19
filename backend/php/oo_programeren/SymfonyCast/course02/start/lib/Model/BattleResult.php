<?php

    class BattleResult{
        private $winning_ship;
        private $losing_ship;
        private $used_jedi_powers;

        public function __construct(Ship $winning_ship=null, Ship $losing_ship=null, bool $used_jedi_powers){
            $this->winning_ship = $winning_ship;
            $this->losing_ship = $losing_ship;
            $this->used_jedi_powers = $used_jedi_powers;
        }

        public function getWinningShip(): ?Ship{
            return $this -> winning_ship;
        }

        public function getLosingShip(): ?Ship{
            return $this->losing_ship;
        }

        public function getUsedJediPowers() :bool{
            return $this->used_jedi_powers;
        }

        public function whereJediPowersUsed(): bool{
            return $this->used_jedi_powers;
        }

        public function IsThereAWinner() :bool{
            return $this->getWinningShip() !== null;
        }


    }
