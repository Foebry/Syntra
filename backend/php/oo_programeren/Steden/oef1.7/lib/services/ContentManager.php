<?php

    class ContentManager{

        private $dbm;
        private $content;
        private $page;
        private $csrf;
        private $ms;

        public function __construct($dbm, $ms, $cl, $pl){
            $this->csrf = $this->generateCsrf();
            $this->page = $this->initPage();
            $this->dbm = $dbm;
            $this->messageService = $ms;
            $this->cityLoader = $cl;
            $this->personLoader = $pl;
            
        }
        /**
         * functie om csrf-token aan te maken.
         * 
         * @return string
         */
        private function generateCsrf() :string{

            # genereer csrf token
            $csrf_key = bin2hex( random_bytes(32) );
            $csrf = hash_hmac( 'sha256', 'PHP1CURSUS SECRET KEY ', $csrf_key );

            # bewaar CSRF token in SESSION onder "latest_csrf" key
            $_SESSION['latest_csrf'] = $csrf;
            return $csrf;
        }

        /**
         * Genereert een blanco pagina met standaard jumbo en correcte navbar.
         * 
         * @@return string
         */
        private function initPage() :string{
            $jumbo = $this->setJumbo();
            $navbar = $this->setNavbar();

            $page = file_get_contents("./templates/pageTemplate.html");
            $page = str_replace("@@jumbo@@", $jumbo, $page);
            $page = str_replace("@@navbar@@", $navbar, $page);

            return $page;
        }

        /**
         * Genereert een standaard jumbo.
         * 
         * @@return string
         */
        private function setJumbo() :string{
            return file_get_contents("./templates/jumbo.html");
        }

        /**
         * Genereert en navbar.
         * Navbar verschilt licht tussen ingelogd vs niet-ingelogd.
         * Admin krijgt ook een extra link naar de log.
         * 
         * @@return string
         */
        private function setNavbar() :string{
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

        /**
         * Scant pagina op placeholders.
         * Placeholder staat tussen @@ @@;
         * 
         * @@param int $offset
         * 
         * @@return void
         */
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

        /**
         * Vervangt alle placeholders uit getTagFromPage met een lege string
         * 
         * @@return void
         */
        private function removeEmptyPlaceholders(){
            # verzamel alle nog bestaande placeholders
            $tags = $this->getTagsFromPage();
            # vervang iedere placeholder door een lege string
            foreach($tags as $tag){
                $this->page = str_replace("@@$tag@@", "", $this->page);
            }

            return $this->page;
        }

        /**
         * Vervangt de placeholders @@title@@ en @@subtitle@@ uit de jumbo door de parameters $h1 en $h2
         * 
         * @@param string $h1
         * @@param string $h2
         * 
         * @@return void
         */
        public function setTitles($h1, $h2=""){
            $this->page = str_replace("@@title@@", $h1, $this->page);
            $this->page = str_replace("@@subtitle@@", $h2, $this->page);
        }

        /**
         * Genereert een formulier op basis van het doorgegeven formTemplate
         * 
         * @@param string $formTemplate
         * @@param string $table
         * @@param array $old_post
         * 
         * @@return void
         */
        public function addForm($formTemplate, $table, $old_post) :void{
            $headers = $this->dbm->getHeaders($table);

            $form = file_get_contents("./templates/$formTemplate");
            $form = str_replace("@@csrf@@", $this->csrf, $form);

            foreach($headers as $key => $values){

                $value = array_key_exists($key, $old_post) ? $old_post[$key] : "";
                $form = str_replace("@@$key@@", $value, $form);
            }
            
            $this->content .= $form;
        }

        /**
         * Genereert een section tag met daarin een ul. 
         * Binnen de ul een lijst van de gevraagde records.
         * 
         * @@param string $table
         * @@param int|string $limit
         * 
         * @@return void
         */
        public function addSection(string $table, $title=null, $limit=null, $where=null) :void{

            $content = "<section><ul>";
            if ($title) $content = "<section><div class='title'><h1>$title</h1></div><ul>";

            $template = "article.html";

            $limit = $limit ? "limit $limit" : "";
            $where ?? "";

            $rows = $this->dbm->getData("SELECT * from $table $where $limit");
            $headers = $this->dbm->getHeaders($table);

            foreach( $rows as $row ){
                $content .= $this->addArticle($table, $row, $headers);
            }

            if( $content == "<section><ul>" ) $content = "<li><h1>Er zijn nog geen personen bekend. Voeg <a href='./?people&add' >hier</a> een persoon toe";
            elseif( $content == "<section><div class='title'><h1>$title</h1></div><ul>") $content = "";
            $this->content .= $content . "</ul></section>";
        }
        
        /**
         * Genereert een li met het article template.
         * Op basis van de doorgevoerde $data.
         * 
         * @@param string $table
         * @@param array $data
         * @@param array $headers
         * 
         * @@return string
         * 
         */
        private function addArticle(string $table, array $data, array $headers) :string{
            $template = "article.html";

            $refTables = [
                "stad" => "steden",
                "person" => "people"
            ];

            $templatestr = file_get_contents("./templates/$template");

            $wordArr = explode(" ", $data["content"]);
            $section = array_slice($wordArr, 0, min(20, count( $wordArr )));
            $desc = join(" ", $section);
            $templatestr = str_replace("@@desc@@", $desc, $templatestr);

            if( count( $wordArr ) > 0) $link = "<a href='./?@@ref@@&id=@@id@@'>...meer info</a>";
            else $link = "<a href='./?@@ref@@&id=@@id@@&edit'>voeg info toe</a>";

            $templatestr = str_replace("@@link@@", $link, $templatestr);
            $templatestr = str_replace("@@table@@", $table, $templatestr);
            $templatestr = str_replace("@@ref@@", $refTables[$table], $templatestr);


            foreach($headers as $key => $values){

                $templatestr = str_replace("@@$key@@", $data[$key], $templatestr);

            }

            return $templatestr;
            
        }

        /**
         * Genereert een detail pagina met template detail
         * op basis van de doorgestuurde $table en $id.
         * 
         * @@param string $table
         * @@param int $id
         * 
         * @@return void
         */
        public function addDetail($table, $id) :void{
            $link = "";

            // stadDetail
            if( $table == "stad" )  {
                $object = $this->cityLoader->getById($id);
                $name = $object->getName(false);
                $link = "Klik <a href='./?people&cob=$id'>hier</a> voor bekende mensen die in $name geboren zijn.";
            }
            
            //persoonDetail
            elseif( $table == "person" ) {
                $object = $this->personLoader->getById($id);
                $cob = $object->getCoB();
                $city = $this->cityLoader->getById($cob);
                $cityName = $city->getName(false);
                $link = "Klink <a href='./?steden&id=$cob'>hier</a> voor details over de geboortestad $cityName.";
            }

            // vervang placeholders uit detail.html
            $content = file_get_contents("./templates/detail.html");
            $content = str_replace("@@table@@", $table, $content);
            $content = str_replace("@@filename@@", $object->getFileName(), $content);
            $content = str_replace("@@content@@", $object->getContent(), $content);
            $content = str_replace("@@link@@", $link, $content);
            $content = str_replace("@@rating@@", $object->getRating(), $content);

            $this->content .= $content;
        }

        /**
         * print de volledige pagina content uit.
         * 
         * @@return void
         */
        public function printContent() :void{

            $this->page = str_replace("@@content@@", $this->content, $this->page);
            $this->page = $this->messageService->ShowErrors($this->page);
            $this->page = $this->messageService->showInfos($this->page);
            $this->removeEmptyPlaceholders();

            echo $this->page;
        }
    }