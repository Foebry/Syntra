<?php

function injectColumn($data){
  return "
  <div class='col-sm-4'>
      <h3>{$data["title"]}</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
      <div class='imgholder'>
        <img src='{$data["path"]}' />
      </div>
    </div>
  ";
}

function injectTitle($header, $title){
    return "<h$header>$title</h$header>";
}

function injectParagraphLorem($length){
    $lorem = file_get_contents('http://loripsum.net/api/1');
    $words = explode(" ", $lorem);

    return implode(" ", array_slice($words, 0, $length));
}

function injectImgHolder($path){
    return "<div class='imgholder'>
                <img src='$path'>
            </div>";
}

function injectLink($path, $txt){
    return "<a href=$path>$txt</a>";
}
 ?>
