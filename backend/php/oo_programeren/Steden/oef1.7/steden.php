
<?php
    require_once "./lib/autoload.php";

    $container = $_SESSION["container"];

    $dbm = $container->getDbManager();
    $city_loader = $container->getCityLoader();
    $ms = $container->getMessageService();

    $ms->saveSession();

    $css = array('steden.css', 'navbar.css');
    $headers = $dbm->getHeaders("images");

    $cities = $city_loader->getCities($limit=3);

    $content = createArticles($cities, "article_steden.html", False);
    $content = mergeContent("main.html", $content);
    $content = $ms->ShowErrors($content);
    $content = $ms->ShowInfos($content);
    $content = removeEmptyPlaceholder($content);

    echo PrintHead($title="Mijn eerste webpagina", $css);
    echo PrintJumbo("Leuke plekken in Europa (steden)", "Tips voor citytrips voor vrolijke vakantiegangers!");
    echo PrintNavBar("navbar.html");
    echo $content;
    ?>
