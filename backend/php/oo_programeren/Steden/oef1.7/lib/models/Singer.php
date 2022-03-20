<?php

    class Singer extends AbstractPerson{

        private $albums;

        public function __construct($data){
            parent::__construct($data);
        }

        private function setAlbums() :void{
            $id = $this->getId();
            $this->albums = $AlbumLoader->getByArtistId($id);
        }
        public function getAlbums() :array{
            return $this->albums;
        }

    }