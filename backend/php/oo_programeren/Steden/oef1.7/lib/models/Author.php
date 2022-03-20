<?php

    class Author extends AbstractPerson{

        private $books;

        public function __construct($data){
            parent::__construct($data);
        }

        private function setBookCollection(){
            $id = $this->getId();
            $this->books = $BooksLoader->getByAuthor($id);
        }
        /**
         * Opvragen van alle boeken die auteur heeft geschreven
         */
        public function getBookCollection() :array{
            return $this->books;
        }
    }