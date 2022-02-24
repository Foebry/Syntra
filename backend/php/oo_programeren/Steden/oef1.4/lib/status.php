<?php
    $root = $_SERVER["DOCUMENT_ROOT"];
    require_once "autoload.php";

    $css = array('navbar.css', 'steden.css');
    $content = file_get_contents("./templates/status.html");
    $content = mergeContent("main.html", $content);
    $content = mergeErrors($content, $errors, $errors);
    $content = removeEmptyPlaceholder($content);

    echo PrintHead($title="Status", $css);
    echo PrintJumbo($title="Oops er ging iets mis...");
    echo PrintNavBar("navbar.html");
    echo $content;
