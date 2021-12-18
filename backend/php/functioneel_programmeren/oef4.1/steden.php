<?php
    require_once "../lib/html_components.php";
    require_once "../lib/elements.php";
    require_once "../lib/database.php";
    $css = array('steden.css', 'navbar.css');
    echo PrintHead($title="Mijn eerste webpagina", $css);
    echo PrintJumbo("Leuke plekken in Europa (steden)", "Tips voor citytrips voor vrolijke vakantiegangers!");
    $replacements = [["@HOME_LINK@", "./steden.php"], ["@REGISTER_LINK@", "./register.php"], ["@LOGIN_LINK@", "./login.php"]];
    echo PrintNavBar("../templates/navbar.html", $replacements);
    ?>

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
