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

    // maak een array aan voor alle velden die we willen tonen
    $fields = array("img_id", "img_title", "img_filename", "img_width", "img_height", "img_blabla");
    echo PrintForm($data, $fields, $action="../lib/save.php");
    echo PrintImgHolder('../images/'.$data['img_filename']);
    echo PrintLink("./steden2.php", "Terug naar het overzicht");

    $conn = null;
?>

  </body>
</html>
