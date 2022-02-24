<?php
    class City{
        private $img_filename;
        private $img_title;
        private $img_width;
        private $img_height;
        private $img_desc;
        private $img_lan_id;
        private $img_id;

        function __construct($data){
            $this->setId($data["img_id"]);
            $this->setFileName($data["img_filename"]);
            $this->setTitle($data["img_title"]);
            $this->setWidth($data["img_width"]);
            $this->setHeight($data["img_height"]);
            $this->setDesc($data["img_desc"]);
            $this->setCountryId($data["img_lan_id"]);
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
        public function setTitle(string $title) :void{
            $this->img_title = $title;
        }
        public function getTitle($uppercase=True) :string{
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
        public function setDesc(string $desc) :void{
            $this->img_desc = $desc;
        }
        public function getDesc() :string{
            return $this->img_desc;
        }
        public function setCountryId(int $country_id) :void{
            $this->img_lan_id = $country_id;
        }
        public function getCountryId() :int{
            return $this->img_lan_id;
        }
    }
