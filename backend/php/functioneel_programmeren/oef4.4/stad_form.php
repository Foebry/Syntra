<?php
    error_reporting(E_ALL ^ E_NOTICE);
    require_once "./lib/autoload.php";

    $css = array('steden.css', 'navbar.css');
    $img_id = $_GET["img_id"];
    $sql = "select * from images where img_id = 1";

    $data = GetData($sql);

    $sql = "select * from land";
    $select = getData($sql);

    $headers = getHeaders("images");
    $content = createForm("form.html", $headers, $data[0]);
    $content = mergeContent("main.html", $content);

    $headers = getHeaders("land");
    $sql = "select img_lan_id from images where img_id = 1";
    $id = getData($sql)[0]["img_lan_id"];

    $content = makeSelect($content, $select, $headers, $id, "option_land.html");
    $content = mergeErrorInfoPlaceholder($content, $headers, $errors, $info);
    $content = removeEmptyPlaceholder($content);

    echo PrintHead($title="Stad", $css);
    echo PrintJumbo("Bewerk Afbeelding");
    echo PrintNavBar("navbar.html");

    echo $content;
