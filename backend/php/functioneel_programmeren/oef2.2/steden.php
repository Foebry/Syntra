<?php
    require_once "../src/html_components.php";
    require_once "../src/elements.php";
    require_once "../src/database.php";
    $css = array('steden.css');
    echo PrintHead($title="Mijn eerste webpagina", $css)
 ?>
 <?=PrintJumbo("Leuke plekken in Europa", "Tips voor citytrips voor vrolijke vakantiegangers!")?>

    <div class="container">
        <?php
            # inladen elements module + mysql connector
            # aanmaken sql connector
            $conn = connectDb();
            # aanmaken query
            $sql = "select * from images";
            #opvragen data uit db
            $images = GetData($conn, $sql);
            # data uitprinten in de pagina
            foreach($images as $row){
                echo "<article>";
                echo injectTitle(1, $row["img_title"]);
                echo "<p>".$row['img_width']." x ".$row['img_height']."</p>";
                echo injectParagraphLorem(15);
                echo injectImgHolder('../images/'.$row['img_filename']);
                echo "</article>";
            }
         ?>
    </div>

  </body>
</html>
