<?php
    require_once "../lib/html_components.php";
    require_once "../lib/database.php";
    $css = array('stad_form.css');
    echo PrintHead($title="Stad", $css);

    echo PrintJumbo($titel="Bewerk Afbeelding");

    # aanmaken sql connector
    $conn = connectDb();
    #aanmaken query
    $sql = "select * from images where img_id = ".$_GET['img_id'];
    # specifieke data inladen uit db
    $data = GetData($conn, $sql);

    // form uitprinten obv template form.html ahv data $data met select op basis van land
    echo(printForm($data, "form.html", "land"));

?>
