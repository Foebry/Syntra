<?php

    class ContentManager{

        private $dbm;
        private $content;
        private $page;
        private $csrf;
        private $ms;

        public function __construct($dbm, $ms, $cl){
            $this->csrf = $this->generateCsrf();
            $this->page = $this->initPage();
            $this->dbm = $dbm;
            $this->messageService = $ms;
            $this->cityLoader = $cl;
            
        }
        /**
         * functie om csrf-token aan te maken.
         * @return string
         */
        private function generateCsrf(){

            # genereer csrf token
            $csrf_key = bin2hex( random_bytes(32) );
            $csrf = hash_hmac( 'sha256', 'PHP1CURSUS SECRET KEY ', $csrf_key );

            # bewaar CSRF token in SESSION onder "latest_csrf" key
            $_SESSION['latest_csrf'] = $csrf;
            return $csrf;
        }

        private function initPage(){
            $jumbo = $this->setJumbo();
            $navbar = $this->setNavbar();

            $page = file_get_contents("./templates/pageTemplate.html");
            $page = str_replace("@@jumbo@@", $jumbo, $page);
            $page = str_replace("@@navbar@@", $navbar, $page);

            return $page;
        }

        private function setJumbo(){
            return file_get_contents("./templates/jumbo.html");
        }
        private function setNavbar(){
            $navbar = file_get_contents("./templates/navbar.html");

            if( isset( $_SESSION["user"] ) ){

                $avatar = $_SESSION["user"]->getAvatar();
                $name = $_SESSION["user"]->getVoornaam();

                $navbar = file_get_contents("./templates/navbar_signed.html");
                $navbar = str_replace("@@usr_avatar@@", $avatar, $navbar);
                $navbar = str_replace("@@usr_name@@", $name, $navbar);

            }
            $navbar = str_replace("@@csrf@@", $this->csrf, $navbar);

            return $navbar;
        }

        private function getTagsFromPage($offset=0){
            $placeholders = [];
            # zoek naar de eerste positie waar een @ voorkomt.
            # @ duidt de start van een placeholder aan
            $offset = strpos($this->page, "@@", $offset);

            # zolang placeholders gevonden worden, voeg deze toe aan de placeholders array
            while($offset){
                # zoek naar de closing @ van de placeholder, vanaf de positie ná de opening @
                $start = $offset+2;
                $end = strpos($this->page, "@@", $start);
                # indien geen closing @ gevonden, zijn er geen verdere placeholders en eindigd de while loop
                if ($end == 0) break;
                # indien wel een closing @ gevonden, voeg de waarde tussen opening en closing @ toe aan de placeholders array
                $placeholders[] = substr($this->page, $start, $end-$start);
                # zet $offset gelijk aan de positie van de volgende opening @
                # indien geen gevonden if $offset gelijk aan 0 (ofwel false) en eindigt de while loop
                $offset = strpos($this->page, "@@", $end+2);
            }
            return $placeholders;
        }

        private function removeEmptyPlaceholders(){
            # verzamel alle nog bestaande placeholders
            $tags = $this->getTagsFromPage();
            # vervang iedere placeholder door een lege string
            foreach($tags as $tag){
                $this->page = str_replace("@@$tag@@", "", $this->page);
            }

            return $this->page;
        }

        public function setTitles($h1, $h2=""){
            $this->page = str_replace("@@title@@", $h1, $this->page);
            $this->page = str_replace("@@subtitle@@", $h2, $this->page);
        }

        public function addForm($formTemplate, $table, $old_post){
            $headers = $this->dbm->getHeaders($table);

            $form = file_get_contents("./templates/$formTemplate");
            $form = str_replace("@@csrf@@", $this->csrf, $form);

            foreach($headers as $key => $values){

                $value = array_key_exists($key, $old_post) ? $old_post[$key] : "";
                $form = str_replace("@@$key@@", $value, $form);
            }
            
            $this->content .= $form;
        }
        public function addSection($table){
            $templates = [
                "images" => "article_steden.html"
            ];
            $template = $templates[$table];

            $rows = $this->dbm->getData("SELECT * from $table");
            $headers = $this->dbm->getHeaders($table);

            $content = "<section><ul>";

            foreach($rows as $row){

                $templatestr = file_get_contents("./templates/$template");

                foreach($headers as $key => $values){
                    
                    $templatestr = str_replace("@@$key@@", $row[$key], $templatestr);

                    if( strpos($key, "content") != false){
                        // vervang placeholder desc met de eerste 20 woorden van de content uit de db.
                        $wordArr = explode(" ", $row[$key]);
                        $section = array_slice($wordArr, 0, 20);
                        $desc = implode(" ", $section);
                        $templatestr = str_replace("@@desc@@", $desc, $templatestr);
                    }
                    if( strpos($key, "rating") != false){
                        // zet de rating img
                        $templatestr = str_replace("@@rating@@", $row[$key], $templatestr);
                    }
                }
                $content .= $templatestr ;
            }
            $this->content .= $content."</ul></section>";

        }
        public function addPopularSection($table, $title){
            $templates = [
                "images" => "article_steden.html"
            ];
            $template = $templates[$table];

            $rows = $this->dbm->getData("SELECT * from $table limit 3");
            $headers = $this->dbm->getHeaders($table);

            $content = "<section class='popular $table'>";
            $content .= "<div class='title'><h1>$title</h1></div>";
            $content .= "<ul>";
            
            foreach($rows as $row){

                $templatestr = file_get_contents("./templates/$template");

                foreach($headers as $key => $values){
                    
                    $templatestr = str_replace("@@$key@@", $row[$key], $templatestr);

                    if( strpos($key, "content") != false){
                        // vervang placeholder desc met de eerste 20 woorden van de content uit de db.
                        $wordArr = explode(" ", $row[$key]);
                        $section = array_slice($wordArr, 0, 20);
                        $desc = implode(" ", $section);
                        $templatestr = str_replace("@@desc@@", $desc, $templatestr);
                    }

                    if( strpos($key, "rating") != false){
                        // zet de rating img
                        $templatestr = str_replace("@@rating@@", $row[$key], $templatestr);
                    }
                }
                $content .= $templatestr ;
            }
            
            $this->content .= $content."</ul></section>";

        }
        public function addDetail($table, $id){
            
            $link = "";

            // stadDetail
            if( $table == "images" )  {
                $object = $this->cityLoader->getById($id);
                $table = "cities";
                $name = $object->getTitle();
                $link = "Klik <a href='./?people&cob=$id'>hier</a> voor bekende mensen die in $name geboren zijn.";
            }
            
            //persoonDetail
            elseif( $table == "people" ) $object = $this->personLoader->getById($id);

            // replace placeholders uit detail.html
            $content = file_get_contents("./templates/detail.html");
            $content = str_replace("@@table@@", $table, $content);
            $content = str_replace("@@filename@@", $object->getFileName(), $content);
            $content = str_replace("@@desc@@", $object->getDesc(), $content);
            $content = str_replace("@@content@@", $object->getContent(), $content);
            $content = str_replace("@@link@@", $link, $content);
            $content = str_replace("@@rating@@", $object->getRating(), $content);

            $this->content .= $content;
        }

        public function printContent(){

            $this->page = str_replace("@@content@@", $this->content, $this->page);
            $this->page = $this->messageService->ShowErrors($this->page);
            $this->page = $this->messageService->showInfos($this->page);
            $this->removeEmptyPlaceholders();

            echo $this->page;
        }
    }