<?php
    require_once "../src/html_components.php";
    require_once "../src/database.php";
    $css = array('steden.css');
    echo PrintHead($title="Mijn eerste webpagina", $css);
?>
    <?=PrintJumbo('Leuke plekken in Europa', 'Tips voor citytrips voor vrolijke vakantiegangers!')?>
    <div class="container">
        <?php
            # aanmaken connectie met db
            $conn = connectDb();
            # aanmaken query
            $sql = "select * from images";
            #opvragen data uit db
            $images = GetData($conn, $sql);

            # data uitprinten in de pagina
            foreach($images as $row){
                echo "<article>";
                echo PrintTitle(1, $row["img_title"]);
                echo "<p>".$row['img_width']." x ".$row['img_height'];
                echo PrintParagraphLorem(17);
                echo PrintImgHolder('../images/'.$row['img_filename']);
                echo PrintLink("stad.php?img_id=".$row['img_id'], 'Meer info');
                echo "</article>";
            }
         ?>
    </div>
</body>
</html>
