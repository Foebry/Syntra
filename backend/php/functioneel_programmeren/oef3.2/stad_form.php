<?php
    require_once "../lib/html_components.php";
    require_once "../lib/database.php";
    $css = array('stad_form.css');
    echo PrintHead($title="Stad", $css);

    echo PrintJumbo($titel="Bewerk Afbeelding");

    # aanmaken sql connector
    $conn = connectDb();
    #aanmaken query
    $sql = "select img_id, img_title, img_filename, img_width, img_height from images where img_id = ".$_GET['img_id'];
    # specifieke data inladen uit db
    $data = GetData($conn, $sql);

    $template = "../templates/form.html";

    $template = fillform($data, $template);

    $data = GetData($conn, "select * from land");
    $template = makeselect($data, $template, $_GET["img_id"]);
    echo($template);

?>
