<?php

class ContentManager
{

    private $content;
    private $page;
    private $csrf;

    public function __construct()
    {
        $this->csrf = $this->generateCsrf();
        $this->initPage();
    }
    /**
     * functie om csrf-token aan te maken.
     * 
     * @return string
     */
    public function generateCsrf(): string
    {

        # genereer csrf token
        $csrf_key = bin2hex(random_bytes(32));
        $csrf = hash_hmac('sha256', 'PHP1CURSUS SECRET KEY ', $csrf_key);

        # bewaar CSRF token in SESSION onder "latest_csrf" key
        $_SESSION['latest_csrf'] = $csrf;
        return $csrf;
    }

    /**
     * Genereert een blanco pagina met standaard jumbo en correcte navbar.
     * 
     * @@return string
     */
    public function initPage(): void
    {

        $this->content = "";
        $jumbo = $this->setJumbo();
        $navbar = $this->setNavbar();

        $page = file_get_contents("./templates/pageTemplate.html");
        $page = str_replace("@@jumbo@@", $jumbo, $page);
        $page = str_replace("@@navbar@@", $navbar, $page);
        $this->page = $page;
    }

    /**
     * Genereert een standaard jumbo.
     * 
     * @@return string
     */
    private function setJumbo(): string
    {
        return file_get_contents("./templates/jumbo.html");
    }

    /**
     * Genereert en navbar.
     * Navbar verschilt licht tussen ingelogd vs niet-ingelogd.
     * Admin krijgt ook een extra link naar de log.
     * 
     * @@return string
     */
    private function setNavbar(): string
    {
        $navbar = file_get_contents("./templates/navbar.html");

        if (isset($_SESSION["user"])) {

            $avatar = $_SESSION["user"]->getAvatar();
            $name = $_SESSION["user"]->getVoornaam();

            $navbar = file_get_contents("./templates/navbar_signed.html");
            $navbar = str_replace("@@usr_avatar@@", $avatar, $navbar);
            $navbar = str_replace("@@usr_name@@", $name, $navbar);

            if ($_SESSION["user"]->getType() == "admin") {
                $log = '<li class="nav-item"><a class="nav-link" href="@@root@@/server-log">log</a></li>';
                $navbar = str_replace("@@log@@", $log, $navbar);
            }
        }
        $navbar = str_replace("@@csrf@@", $this->csrf, $navbar);

        return $navbar;
    }

    public function getCSRF(): string
    {
        return $this->csrf;
    }

    /**
     * Scant pagina op placeholders.
     * Placeholder staat tussen @@ @@;
     * 
     * @@param int $offset
     * 
     * @@return void
     */
    private function getTagsFromPage($offset = 0)
    {
        $placeholders = [];
        # zoek naar de eerste positie waar een @ voorkomt.
        # @ duidt de start van een placeholder aan
        $offset = strpos($this->page, "@@", $offset);

        # zolang placeholders gevonden worden, voeg deze toe aan de placeholders array
        while ($offset) {
            # zoek naar de closing @ van de placeholder, vanaf de positie ná de opening @
            $start = $offset + 2;
            $end = strpos($this->page, "@@", $start);
            # indien geen closing @ gevonden, zijn er geen verdere placeholders en eindigd de while loop
            if ($end == 0) break;
            # indien wel een closing @ gevonden, voeg de waarde tussen opening en closing @ toe aan de placeholders array
            $placeholders[] = substr($this->page, $start, $end - $start);
            # zet $offset gelijk aan de positie van de volgende opening @
            # indien geen gevonden if $offset gelijk aan 0 (ofwel false) en eindigt de while loop
            $offset = strpos($this->page, "@@", $end + 2);
        }
        return $placeholders;
    }

    /**
     * Vervangt alle placeholders uit getTagFromPage met een lege string
     * 
     * @@return void
     */
    private function removeEmptyPlaceholders()
    {
        # verzamel alle nog bestaande placeholders
        $tags = $this->getTagsFromPage();
        # vervang iedere placeholder door een lege string
        foreach ($tags as $tag) {
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
    public function setTitles($h1, $h2 = "")
    {
        $this->page = str_replace("@@title@@", $h1, $this->page);
        $this->page = str_replace("@@subtitle@@", $h2, $this->page);
    }

    /**
     * Genereert een formulier op basis van het doorgegeven formTemplate
     * 
     * @@param string $formTemplate
     * @@param string $table
     * @@param array $old_post
     * @@param array|null $data
     * 
     * @@return void
     */
    public function addForm($dbm, $formTemplate, $table, $old_post, $data = null): void
    {
        $refTable = ["stad" => "steden", "person" => "people"];
        // inlade van template
        $form = file_get_contents("./templates/$formTemplate");

        // wanneer table person of stad is vervang @@id@@ door id van persoon / stad / volgende auto-incrementId
        if (in_array($table, ["person", "stad"])) {
            $id = isset($old_post["id"]) ? $old_post["id"] : ($data && isset($data["id"]) ? $data["id"] : $dbm->getNextId($table));
            $form = str_replace("@@id@@", $id, $form);
            $form = str_replace("@@ref@@", "@@root@@/$refTable[$table]/$id", $form);
            $form = str_replace("@@selectRating@@", $this->ratingSelect($table, $old_post, $data), $form);
        }
        // wanneer table user is vervang @@usr_id@@ door usr_id / volgende auto-incrementId
        elseif ($table == "user") {
            $usr_id = isset($_SESSION["user"]) ? $_SESSION["user"]->getId() : $dbm->getNextId("user");
            $form = str_replace("@@usr_id@@", $usr_id, $form);
        }

        if ($table == "person") {
            $geboortestadInput = '<div class="form-row"><label >geboorte stad</label><div class="col-sm-3"><input class="cob" name="cobName" type="text" value="@@stad@@" /></div></div>';
            $cob = isset($old_post["cob"]) ? $old_post["cob"] : ($data && isset($data["cob"]) ? $data["cob"] : 0);
            $cobName = $dbm->GetData("select name from stad where id = $cob")[0]["name"];

            $form = str_replace("@@geboortestadInput@@", $geboortestadInput, $form);
            $form = str_replace("@@cob@@", $cob, $form);
            $form = str_replace("@@stad@@", $cobName, $form);
            $form = str_replace("@@selectType@@", $this->typeSelect($old_post, $data), $form);
            $form = str_replace("@@stedenList@@", $this->stedenList($dbm), $form);
        }

        $form = str_replace("@@csrf@@", $this->csrf, $form);
        $form = str_replace("@@table@@", $table, $form);

        $headers = $dbm->getHeaders($table);

        foreach ($headers as $key => $values) {
            // indien key in old_post neem old_post anders data
            $value = array_key_exists($key, $old_post) ? $old_post[$key] : (array_key_exists($key, $data) ? $data[$key] : "");
            if ($key == "rating" && $value == "") $value = "0";
            if ($key == "filename" && $value == "") $value = "default.jpg";

            $form = str_replace("@@$key@@", trim($value), $form);
        }

        $this->content .= $form;
    }

    private function ratingSelect($table, $old_post, $data)
    {
        $niveaus = [
            "person" => [
                "0" => "onbekend",
                "1" => "lokaal",
                "2" => "regionaal",
                "3" => "nationaal",
                "4" => "continentaal",
                "5" => "internationaal"
            ],
            "stad" => [
                "0" => "onpopulair",
                "1" => "relatief populair",
                "2" => "populair",
                "3" => "zeer populair",
                "4" => "enorm populair",
                "5" => "hyper populair"
            ]
        ];
        $select = '<select name="rating" id="rating">';

        foreach ($niveaus[$table] as $key => $value) {
            $rating = isset($old_post["rating"]) ? $old_post["rating"] : (isset($data["rating"]) ? $data["rating"] : "0");
            $selected = $rating == $key ? "selected" : "";

            $select .= "<option value=$key $selected>$value</option>";
        }

        return $select .= "</select>";
    }

    private function typeSelect($old_post, $data)
    {
        $options = ["auteur", "zanger", "zangeres"];

        $select = '<div class="form-row">
                            <label for="type">Type</label>
                            <div class="col-sm-3">
                                <select name="type" id="type">';

        foreach ($options as $option) {
            $value = isset($old_post["type"]) ? $old_post["type"] : (isset($data["type"]) ? $data["type"] : "");
            $selected = $value == $option ? "selected" : "";

            $select .= "<option value=$option $selected>$option</option>";
        }

        return $select .= "</select></div></div>";
    }

    private function stedenList($dbm)
    {
        $data = $dbm->GetData("select id, name from stad");
        $list = "";

        foreach ($data as $row) {
            $id = $row["id"];
            $name = $row["name"];
            $list .= "<li id=$id>$name</li>";
        }
        return $list;
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
    public function addSection($dbm, string $table, $title = null, $limit = null, $where = null): void
    {
        $refs = ["stad" => "steden", "person" => "people"];
        $page = $refs[$table];

        $addButton = "<button class='add'><a href='@@root@@/$page/add'>voeg toe</a></button>";
        $content = "<section>@@button@@<ul>";
        if ($title) $content = "<section>@@button@@<div class='title'><h1>$title</h1></div><ul>";
        if (isset($_SESSION["user"])) $content = str_replace("@@button@@", $addButton, $content);

        $template = "article.html";

        $limit = $limit ? "limit $limit" : "";
        $where = $where ? $where . " and name != 'default'" : "where name != 'default'";

        $rows = $dbm->getData("SELECT * from $table $where order by rating desc, name $limit");
        $headers = $dbm->getHeaders($table);

        foreach ($rows as $row) {
            $content .= $this->addArticle($table, $row, $headers);
        }

        if ($content == "<section><ul>") $content = "<li><h1>Er zijn nog geen personen bekend. Voeg <a href='@@root@@/people/add' >hier</a> een persoon toe";
        elseif ($content == "<section><div class='title'><h1>$title</h1></div><ul>") $content = "";
        elseif ($content == "<section>$addButton<div class='title'><h1>$title</h1></div><ul>") $content = "";
        elseif ($content == "<section>@@button@@<div class='title'><h1>$title</h1></div><ul>") $content = "";
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
    private function addArticle(string $table, array $data, array $headers): string
    {
        $template = "article.html";

        $refTables = [
            "stad" => "steden",
            "person" => "people"
        ];

        $templatestr = file_get_contents("./templates/$template");

        $wordArr = explode(" ", $data["content"]);
        $section = array_slice($wordArr, 0, min(20, count($wordArr)));
        $desc = join(" ", $section);
        $templatestr = str_replace("@@desc@@", $desc, $templatestr);

        if ($data["content"] > "") $link = "<a href='@@root@@/@@ref@@/@@id@@'>...meer info</a>";
        else $link = "<a href='@@root@@/@@ref@@/@@id@@/edit'>voeg info toe</a>";

        $templatestr = str_replace("@@link@@", $link, $templatestr);
        $templatestr = str_replace("@@table@@", $table, $templatestr);
        $templatestr = str_replace("@@ref@@", $refTables[$table], $templatestr);


        foreach ($headers as $key => $values) {

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
    public function addDetail($cityLoader, $personLoader, $table, $id): void
    {
        $link = "";
        $edit = "";

        // stadDetail
        if ($table == "stad") {
            $object = $cityLoader->getById($id);
            $name = $object->getName(false);
            $link = "Klik <a href='@@root@@/steden/$id/people'>hier</a> voor bekende mensen die in <span>$name</span> geboren zijn.";
            if (isset($_SESSION["user"]) && $id != 0) $edit = "<div class='buttons'><button><a href='@@root@@/steden/$id/edit'>edit</a></button><form action='@@root@@/lib/delete.php' method='POST'><input type='hidden' name='aftersql' value='@@root@@/@@table@@' /><input type='hidden' name='table' value='@@table@@' /><input type='hidden' name='id' value='@@id@@'/><button class='delete'>delete</button></form>";
        }

        //persoonDetail
        elseif ($table == "person") {
            $object = $personLoader->getById($id);
            $cob = $object->getCoB();
            $city = $cityLoader->getById($cob);
            $cityName = $city->getName(false);
            $link = "Klink <a href='@@root@@/steden/$cob'>hier</a> voor details over de geboortestad <span>$cityName</span>.";
            if (isset($_SESSION["user"])) $edit = "<div class='buttons'><button><a href='@@root@@/people/$id/edit'>edit</a></button><form action='@@root@@/lib/delete.php' method='POST'> <input type='hidden' name='aftersql' value='@@root@@/@@table@@' /><input type='hidden' name='table' value='@@table@@' /><input type='hidden' name='id' value='@@id@@'/><button class='delete'>delete</button></form>";
        }

        // vervang placeholders uit detail.html
        $content = file_get_contents("./templates/detail.html");

        $content = str_replace("@@edit@@", $edit, $content);
        $content = str_replace("@@table@@", $table, $content);
        $content = str_replace("@@filename@@", $object->getFileName(), $content);
        $content = str_replace("@@content@@", $object->getContent(), $content);
        $content = str_replace("@@link@@", $link, $content);
        $content = str_replace("@@rating@@", $object->getRating(), $content);
        $content = str_replace("@@id@@", $object->getId(), $content);

        $this->content .= $content;
    }

    /**
     * print de volledige pagina content uit.
     * 
     * @@return void
     */
    public function printContent($ms, $path_to_root): void
    {

        $ms->saveSession();
        $this->page = str_replace("@@content@@", $this->content, $this->page);
        $this->page = str_replace("@@root@@", $path_to_root, $this->page);
        $this->page = $ms->ShowErrors($this->page);
        $this->page = $ms->showInfos($this->page);
        $this->removeEmptyPlaceholders();

        echo $this->page;
    }
    public function showLog($logger)
    {
        $this->content .= $logger->showLog();
    }

    public function getContent(): string
    {
        return $this->page;
    }
}
