<?php

    $public_access = true;

    require_once "lib/autoload.php";

    $container = $_SESSION["container"];

    $contentManager = $container->getContentManager("Home");

    $contentManager->addPopularSection("images", "populaire steden");

    $contentManager->printContent();