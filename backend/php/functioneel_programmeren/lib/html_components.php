<?php
require_once "../lib/database.php";
require_once "../lib/security.php";

function insertCSS($head, $files){
    $css = '';
    foreach($files as $file){
        $css .= '<link rel="stylesheet" href="../css/'.$file.'">';
    }
    return str_replace("@CSS@", $css, $head);
}

function PrintHead($title, $css=array(0)) :string{
    $head = file_get_contents("../templates/head.html");

    $head = str_replace("@title@", $title, $head);
    $head = insertCSS($head, $css);

    return $head.PrintBody();
}

function PrintJumbo($titel, $subtitel=""): string{
    $jumbo = file_get_contents("../templates/jumbo.html");

    $jumbo = str_replace("@titel@", $titel, $jumbo);
    return str_replace("@subtitel@", $subtitel, $jumbo);
}

function PrintBody() :string{
    return "<body>";
}

function PrintTitle($header, $title) :string{
    return "<h$header>$title</h$header>";
}

function PrintParagraphLorem($length) :string{
    $lorem = file_get_contents('http://loripsum.net/api/1');
    $words = explode(" ", $lorem);

    return implode(" ", array_slice($words, 0, $length));
}

function PrintImgHolder($path) :string{
    return "<div class='imgholder'>
                <img src='$path' alt=''>
            </div>";
}

function PrintLink($path, $txt) :string{
    return "<a href=$path>$txt</a>";
}

function printForm($data, $template, $select_field) :string{
    /**
    * @param $select_field: vormt basis waarrond een select gemaakt wordt.
    */

    $selected_land = $data["img_lan_id"];
    $template = file_get_contents("../templates/$template");

    foreach($data as $key=>$value){
        $template = str_replace("@$key@", "$value", $template);
    }

    $conn = connectDb();
    $data = GetData($conn, "select * from $select_field");

    $template = makeselect($data, $template, $selected_land);

    $csrf = generateCSRF();
    return str_replace("@csrf@", $csrf, $template);
}

function makeSelect($data, $template, $selected_option) :string{
    /**
     *
     * @param $data: alle records uit de tabel bv. land
     * @param $template: het beoogde template
     * @param $selected_option: option die als selected moet aangeduid worden
     *
     * @var $select: html-string die de hele select tag bevat.
     *
     * @type $data: array
     * @type $template: string
     * @type $selected_option: int
     * @type $select: string
     *
     * @return: string
     */
    $select = "";

    // voor ieder land een option aanmaken
    foreach($data as $row){
        $lan_id = $row["lan_id"];
        $lan_land = $row["lan_land"];

        $selected = $lan_id == $selected_option ? "selected" : "";
        $select .= "<option $selected value=$lan_id>$lan_land</option>";
    }
    return str_replace("@makeselect@", $select, $template);
}

function PrintNavBar($template):string {
    /**
    * @param $template: het te gebruiken template
    *
    * @type $template: string
    */

    // ophalen content van template
    return file_get_contents($template);
}
