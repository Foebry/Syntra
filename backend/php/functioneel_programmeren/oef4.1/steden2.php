<?php
    require_once "../lib/html_components.php";
    require_once "../lib/database.php";
    $css = array('steden.css', 'navbar.css');
    echo PrintHead($title="Steden 2 - Plekken in Europa", $css);

    echo PrintJumbo('Leuke plekken in Europa', 'Tips voor citytrips voor vrolijke vakantiegangers!');
    $replacements = [["@HOME_LINK@", "./steden.php"], ["@REGISTER_LINK@", "./register.php"], ["@LOGIN_LINK@", "./login.php"]];
    echo PrintNavBar("../templates/navbar.html", $replacements);
    ?>

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
                echo PrintParagraphLorem(16);
                echo PrintImgHolder('../images/'.$row['img_filename']);
                echo PrintLink("stad_form.php?img_id=".$row['img_id'], 'Meer info');
                echo "</article>";
            }
            $conn = null;
         ?>
    </div>
</body>
</html>
