<?php
    require_once "../lib/autoload.php";
    require_once "../lib/html_components.php";
    require_once "../lib/elements.php";
    require_once "../lib/database.php";

    $css = array('steden.css', 'navbar.css');
    $images = GetData("select * from images limit 3");
    $main = mergeInfo("main.html", $info);
    $content = createArticles($images, "article_steden.html");

    echo PrintHead($title="Mijn eerste webpagina", $css);
    echo PrintJumbo("Leuke plekken in Europa (steden)", "Tips voor citytrips voor vrolijke vakantiegangers!");
    echo PrintNavBar("../templates/navbar.html");
    echo MergeContent($main, $content);
    ?>



  </body>
</html>
