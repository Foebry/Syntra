<?php
    $public_access = True;
    require_once "./lib/autoload.php";

    $id = $_GET["img_id"];
    $city = $city_loader->getCityById($id);
    $headers = $dbm->getHeaders("images");

    $css = array('steden.css', 'navbar.css');

    $content = createCityDetail("city_detail.html", $city, True);
    $content = mergeContent("main.html", $content);
    $content = mergeErrorInfoPlaceholder($content, $headers, $errors, $info);
    $content = removeEmptyPlaceholder($content);

    echo PrintHead($title="OO-style", $css);
    echo PrintJumbo("Stad OO style");
    echo PrintNavBar("navbar.html");
    echo $content;
