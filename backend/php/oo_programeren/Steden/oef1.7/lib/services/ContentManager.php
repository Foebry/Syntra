<?php

    class ContentManager{

        private $dbm;
        private $content;
        private $page;
        private $csrf;
        private $ms;

        public function __construct($dbm, $ms, $h1, $h2){
            $this->csrf = $this->generateCsrf();
            $this->page = $this->initPage($h1, $h2);
            $this->dbm = $dbm;
            $this->ms = $ms;
            
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

        private function initPage($h1, $h2){
            $jumbo = $this->setJumbo($h1, $h2);
            $navbar = $this->setNavbar();

            $page = file_get_contents("./templates/pageTemplate.html");
            $page = str_replace("@@jumbo@@", $jumbo, $page);
            $page = str_replace("@@navbar@@", $navbar, $page);

            return $page;
        }

        private function setJumbo($h1, $h2){
            $jumbo = file_get_contents("./templates/jumbo.html");
            $jumbo = str_replace("@@title@@", $h1, $jumbo);
            $jumbo = str_replace("@@subtitle@@", $h2, $jumbo);

            return $jumbo;
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
                }
                $content .= $templatestr ;
            }

            $this->content .= $content."</ul></section>";

        }

        public function printContent(){

            $this->page = str_replace("@@content@@", $this->content, $this->page);
            $this->page = $this->ms->ShowErrors($this->page);
            $this->page = $this->ms->showInfos($this->page);
            $this->removeEmptyPlaceholders();

            echo $this->page;
        }
    }