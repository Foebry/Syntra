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

function printForm($data, $template, $select_field){
    /*
    * $select_field vormt basis waarrond een select gemaakt wordt.
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
    $template = str_replace("@csrf@", $csrf, $template);

    return $template;
}

function makeSelect($data, $template, $sel_lan){
    /*
    * $data = alle records vanuit de tabel bv. land
    */
    $conn = connectDb();
    $select = "";

    // voor ieder land een option aanmaken
    foreach($data as $row){
        $lan_id = $row["lan_id"];
        $lan_land = $row["lan_land"];



        $selected = $lan_id == $sel_lan ? "selected" : "";
        $select .= "<option $selected value=$lan_id>$lan_land</option>";
    }
    $template = str_replace("@makeselect@", $select, $template);
    return $template;
}

function PrintNavBar($template, $replacements){
    $file = file_get_contents($template);
    foreach($replacements as $row){
        $file = str_replace($row[0], $row[1], $file);
    }
    return $file;
}

 ?>
