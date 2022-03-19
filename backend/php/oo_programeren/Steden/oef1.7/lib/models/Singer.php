<?php

    class Singer extends AbstractPerson{

        private $albums;

        public function __construct($data){
            parent::__construct($data);
            //$this->setAlbums();
        }

        private function setAlbums() :void{
            $id = $this->getId();
            $this->albums = $AlbumLoader->getBySinger($id);
        }
        public function getAlbums() :array{
            return $this->albums;
        }

    }