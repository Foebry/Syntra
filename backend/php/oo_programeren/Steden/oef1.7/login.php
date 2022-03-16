<?php
    $public_access = true;

    require_once "lib/autoload.php";

    $container = $_SESSION["container"];
    
    $contentManager = $container->getContentManager("login");

    $contentManager->addForm("login.html", "user", $old_post);
    $contentManager->printContent();
