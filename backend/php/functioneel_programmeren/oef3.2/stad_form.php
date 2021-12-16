<?php
    require_once "../lib/html_components.php";
    require_once "../lib/database.php";
    $css = array('stad_form.css');
    echo PrintHead($title="Stad", $css);

    echo PrintJumbo($titel="Bewerk Afbeelding");

    # aanmaken sql connector
    $conn = connectDb();
    #aanmaken query
    $sql = "select img_id id, img_title title, img_filename filename, img_width width, img_height height from images where img_id = ".$_GET['img_id'];
    # specifieke data inladen uit db
    $data = GetData($conn, $sql);

    $template = "../templates/form.html";
    $action = "../lib/save.php";
    $id = "mainform";
    $select = ["lan_land", "land"];

    $template = createFormView($template, $action, $id);
    echo viewModelTemplate($data, $template, $select);
?>
