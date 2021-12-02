<?php

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

 ?>
