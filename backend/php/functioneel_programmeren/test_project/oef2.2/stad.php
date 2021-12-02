<?php
    require_once "..//src/html_components.php";
    require_once "../src/database.php";
    $css = array('stad.css');
    echo PrintHead($title="Stad", $css);

    echo PrintJumbo($titel="Detail stad");

    # aanmaken sql connector
    $conn = connectDb();
    #aanmaken query
    $sql = "select * from images where img_id = ".$_GET['img_id'];
    # specifieke data inladen uit db
    $data = GetData($conn, $sql);

    echo "<div class='container'>";
    foreach ($data as $row){
        echo PrintTitle(2, $row['img_title']);
        echo "<p>filename: ".$row['img_filename'].'</p>';
        echo "<p>".$row['img_width']." x ".$row['img_height'];
        echo PrintImgHolder('../images/'.$row['img_filename']);
        echo PrintLink("steden2.php", "terug naar overzicht");
        echo "</div>";
    }
?>

  </body>
</html>
