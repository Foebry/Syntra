<?php
require_once "../lib/database.php";

function insertCSS($head, $files){
    $css = '';
    foreach($files as $file){
        $css .= '<link rel="stylesheet" href="../css/'.$file.'">';
    }
    return str_replace("@CSS@", $css, $head);
}


function PrintHead($title, $css=array(0)){
    $head = file_get_contents("../templates/head.html");

    $head = str_replace("@title@", $title, $head);
    $head = insertCSS($head, $css);

    return $head.PrintBody();
}

function PrintJumbo($titel, $subtitel=""){
    $jumbo = file_get_contents("../templates/jumbo.html");

    $jumbo = str_replace("@titel@", $titel, $jumbo);
    $jumbo = str_replace("@subtitel@", $subtitel, $jumbo);

    return $jumbo;
}

function PrintBody(){
    return "<body>";
}

function PrintTitle($header, $title){
    return "<h$header>$title</h$header>";
}

function PrintParagraphLorem($length){
    $lorem = file_get_contents('http://loripsum.net/api/1');
    $words = explode(" ", $lorem);

    return implode(" ", array_slice($words, 0, $length));
}

function PrintImgHolder($path){
    return "<div class='imgholder'>
                <img src='$path'>
            </div>";
}

function PrintLink($path, $txt){
    return "<a href=$path>$txt</a>";
}

function fillForm($data, $template){
    $template = file_get_contents($template);

    foreach($data as $key=>$value){
        $template = str_replace("@$key@", "$value", $template);
    }
    return $template;
}

function makeSelect($data, $template, $selected_id){
    $select = "";
    foreach($data as $row){
        $lan_id = $row["lan_id"];
        $lan_value = $row["lan_land"];
        $selected = $lan_id == $selected_id ? "selected" : "";
        $select .= "<option $selected value=$lan_id>$lan_value</option>";
    }
    $template = str_replace("@makeselect@", $select, $template);
    return $template;
}

 ?>
