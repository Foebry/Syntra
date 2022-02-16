<?php
    error_reporting(E_ALL ^ E_NOTICE);
    require_once "./lib/autoload.php";
    $css = array('steden.css', 'navbar.css');
    $headers = getHeaders("images");
    $images = GetData("select * from images limit 3");

    $content = createArticles($images, "article_steden.html");
    $content = mergeContent("main.html", $content);
    $content = mergeErrorInfoPlaceholder($content, $headers, $errors, $info);
    $content = removeEmptyPlaceholder($content);

    echo PrintHead($title="Mijn eerste webpagina", $css);
    echo PrintJumbo("Leuke plekken in Europa (steden)", "Tips voor citytrips voor vrolijke vakantiegangers!");
    echo PrintNavBar("navbar.html");
    echo $content;
    ?>
