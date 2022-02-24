<?php
    class User{
        private $usr_id;
        private $usr_voornaam;
        private $usr_naam;
        private $usr_email;

        public function __construct(array $data){
            $this->usr_id = $data["usr_id"];
            $this->usr_voornaam = $data["usr_voornaam"];
            $this->usr_naam = $data["usr_naam"];
            $this->usr_email = $data["usr_email"];
        }

        public function setId(int $id){
            $this->usr_id = $id;
        }
        public function getId() :int{
            return $this->usr_id;
        }

        public function setVoornaam(string $name) :void{
            $this->usr_voornaam = $name;
        }
        public function getVoornaam() :string{
            return $this->usr_voornaam;
        }

        public function setNaam(string $name) :void{
            $this->usr_naam = $name;
        }
        public function getNaam() :string{
            return $this->usr_naam;
        }

        public function setEmail(string $email) :void{
            $this->usr_email = $email;
        }
        public function getEmail() :string{
            return $this->usr_email;
        }

        public function getProps() :array{
            return [
                    "usr_id" => $this->usr_id,
                    "usr_voornaam" => $this->usr_voornaam,
                    "usr_naam" => $this->usr_naam,
                    "usr_email" => $this->usr_email
                ];
        }
    }
