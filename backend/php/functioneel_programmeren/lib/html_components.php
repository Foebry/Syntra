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

function getTagsFromTemplate($template, $offset=0){
    $tags = [];
    $offset = strpos($template, "@", $offset);
    while($offset){
        $start = $offset+1;
        $end = strpos($template, "@", $start);
        if ($end == 0) break;
        $tags[] = substr($template, $start, $end-$start);
        $offset = strpos($template, "@", $end+1);
    }
    return $tags;
}

function createArticles($data , $template){
    $content = "<div class='articles'>";

    foreach($data as $row){
        $content .= file_get_contents("../templates/$template");
        foreach($row as $placeholder => $value){
            $content = str_replace("@$placeholder@", $value, $content);
        }
    }
    return $content."</div>";
}

function mergeContent($template, $content){
    $template = file_get_contents("../templates/$template");
    $template = str_replace("@content@", $content, $template);
    return $template;
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

function createForm($template, $headers, $old_post) :string{
    $template = file_get_contents("../templates/$template");
    foreach ($headers as $tag => $value) {
        $value_verification = key_exists($tag."_verification", $old_post) ? $old_post[$tag."_verification"] : "";
        $value = key_exists($tag, $old_post) ?  $old_post[$tag] : "";
        $template = str_replace("@$tag@", $value, $template);
        $template = str_replace("@$tag"."_verification@", $value_verification, $template);
    }
    if (strpos($template, "@csrf@")){
        $template = str_replace("@csrf@", generateCSRF(), $template);
    }
    return $template;
}
function mergeErrorInfoPlaceholder($templatetxt, $headers, $errors, $info){
    $templatetxt = mergeErrors($templatetxt, $headers, $errors);
    $templatetxt = mergeInfo($templatetxt, $info);
    return $templatetxt;
}
function removeEmptyPlaceholder($templatetxt){
    $tags = getTagsFromTemplate($templatetxt);
    foreach($tags as $tag){
        $templatetxt = str_replace("@$tag@", "", $templatetxt);
    }
    return $templatetxt;
}
function mergeErrors($templatetxt, $headers, $errors){

    foreach($headers as $tag => $value){
        $value = key_exists($tag, $errors) ? $errors[$tag] : "";
        $value_verification = key_exists($tag."_verification", $errors) ? $errors[$tag."_verification"] : "";
        $templatetxt = str_replace("@err_$tag@", $value, $templatetxt);
        $templatetxt = str_replace("@err_$tag"."_verification@", $value_verification, $templatetxt);
    }
    return $templatetxt;
}
function mergeInfo($templatetxt, $info){
    $templatetxt = str_replace("@info@", $info, $templatetxt);
    return $templatetxt;
}
function printForm($data, $template, $select_field) :string{
    /**
    * @param $select_field: vormt basis waarrond een select gemaakt wordt.
    */

    //$selected_land = $data["img_lan_id"];
    $template = file_get_contents("../templates/$template");

    foreach($data as $key=>$value){
        $template = str_replace("@$key@", "$value", $template);
    }

    $conn = connectDb();
    $data = GetData($conn, "select * from $select_field");

    //$template = makeselect($data, $template, $selected_land);

    $csrf = generateCSRF();
    return str_replace("@csrf@", $csrf, $template);
}

function makeSelect($data, $template, $selected_option) :string{
    /**
     *
     * @param $data: alle data uit de tabel bv. land nodig om de select tag te vervolledigen
     * @param $template: het beoogde template
     * @param $selected_option: option die als selected moet aangeduid worden
     *
     * @var $select: html-string die de hele select tag bevat.
     *
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
