<?php

    abstract class AbstractPerson{

        private $cob; // city of birth
        private $fullName;
        private $id;
        private $fileName;
        private $content;
        private $rating;

        public function __construct($personData){
            $this->setId($personData["id"]);
            $this->setCoB($personData["cob"]);
            $this->setFullName($personData["name"]);
            $this->setFileName($personData["filename"]);
            $this->setContent($personData["content"]);
            $this->setRating($personData["rating"]);
        }

        private function setId(int $id) :void{
            $this->id = $id;
        }
        private function setCoB(int $cob) :void{
            $this->cob = $cob;
        }
        private function setFullName(string $name) :void{
            $this->fullName = $name;
        }
        private function setFileName($fileName) :void{
            $this->fileName = $fileName;
        }
        private function setContent($content) :void{
            $this->content = $content;
        }
        private function setRating($rating) :void{
            $this->rating = $rating;
        }

        public function getId() :int{
            return $this->id;
        }
        public function getCoB() :int{
            return $this->cob;
        }
        public function getFirstName() :string{
            return explode(" ", $this->fullName())[0];
        }
        public function getLastName() :string{
            return explode(" ", $this->fullName())[1];
        }
        public function getFullName() :string{
            return $this->fullName;
        }
        public function getFileName() :string{
            return $this->fileName;
        }
        public function getDesc() :string{
            $contentArr = explode(" ", $this->content);
            $slice = array_slice($contentArr, 0, min(20, count($contentArr)));
            return join(" ", $slice);
        }
        public function getContent(){
            return $this->content;
        }
        public function getRating() :int{
            return $this->rating;
        }
    }