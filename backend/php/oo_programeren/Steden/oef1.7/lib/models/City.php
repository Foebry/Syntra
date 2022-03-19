<?php
    class City{
        private $img_filename;
        private $img_title;
        private $img_width;
        private $img_height;
        private $img_lan_id;
        private $img_id;

        function __construct($data){
            $this->setId($data["id"]);
            $this->setFileName($data["filename"]);
            $this->setName($data["name"]);
            $this->setWidth($data["width"]);
            $this->setHeight($data["height"]);
            $this->setCountryId($data["lan_id"]);
            $this->setContent($data["content"]);
            $this->setRating($data["rating"]);
        }
        public function setId(int $id) :void{
            $this->img_id = $id;
        }
        public function getId() :int{
            return $this->img_id;
        }
        public function setFileName(string $filename) :void{
            $this->img_filename = $filename;
        }
        public function getFileName() :string{
            return $this->img_filename;
        }
        public function setName(string $title) :void{
            $this->img_title = $title;
        }
        public function getName($uppercase=True) :string{
            return $uppercase ? strtoupper($this->img_title) : $this->img_title;
        }
        public function setWidth(int $width) :void{
            $this->img_width = $width;
        }
        public function getWidth() :int{
            return $this->img_width;
        }
        public function setHeight(int $height) :void{
            $this->img_height = $height;
        }
        public function getHeight() :int{
            return $this->img_height;
        }
        public function getDesc() :string{
            $wordArr = explode(" ", $this->getContent());
            $section = array_slice($wordArr, 0, 20);

            return implode(" ", $section);
        }
        public function setCountryId(int $country_id) :void{
            $this->img_lan_id = $country_id;
        }
        public function getCountryId() :int{
            return $this->img_lan_id;
        }
        public function setContent($content){
            $this->content = $content;
        }
        public function getContent() :string{
            return $this->content;
        }
        public function setRating($rating) :void{
            $this->rating = $rating;
        }
        public function getRating(): int{
            return $this->rating;
        }
    }
