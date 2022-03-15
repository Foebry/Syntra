<?php
    require_once "./lib/autoload.php";

    $container = $_SESSION["container"];

    $dbm = $container->getDbManager();
    $city_loader = $container->getCityLoader();
    $ms = $container->getMessageService();

    $ms->saveSession();

    $id = $_GET["img_id"];
    $city = $city_loader->getCityById($id);
    $headers = $dbm->getHeaders("images");

    $css = array('steden.css', 'navbar.css');

    $content = createCityDetail("city_detail.html", $city, True);
    $content = mergeContent("main.html", $content);
    $content = $ms->showErrors($content);
    $content = $ms->showInfos($content);
    $content = removeEmptyPlaceholder($content);

    echo PrintHead($title="OO-style", $css);
    echo PrintJumbo("Stad OO style");
    echo PrintNavBar("navbar.html");
    echo $content;
