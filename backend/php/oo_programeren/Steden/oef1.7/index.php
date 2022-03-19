<?php

    $public_access = true;
    

    require_once "lib/autoload.php";

    $container = $_SESSION["container"];

    $contentManager = $container->getContentManager();

    // laad homepage
    if( isset( $_GET["search"] ) ){
        $search = $_GET["search"];
        $contentManager->setTitles("home", "u zocht op $search");
    }
    elseif ( count($_GET) == 0){
        $contentManager->setTitles("Home");
        $contentManager->addPopularSection("stad", "populaire steden");
        $contentManager->addPopularSection("person", "Bekende auteurs", ["auteur"]);
        $contentManager->addPopularSection("person", "Bekende zangers & zangeressen", ["zanger", "zangeres"]);
    }

    // laad steden pagina
    elseif( isset( $_GET["steden"] ) ){

        if ( isset( $_GET["id"] ) ){

            $cityName = $contentManager->cityLoader->getById($_GET["id"])->getTitle();
            $contentManager->setTitles($cityName, "detail");
            $contentManager->addDetail("stad", $_GET["id"]);
        }
        else{
            $contentManager->setTitles("steden");
            $contentManager->addSection("stad");
        }
    }

    // laad mensen pagina
    elseif( isset( $_GET["people"]) ){
        
        
        if( isset( $_GET["cob"] ) ){
            $cityId = $_GET["cob"];
            $stadNaam = $contentManager->cityLoader->getById($cityId)->getTitle();
            $contentManager->setTitles("Bekende mensen", "geboren in $stadNaam");
        }
        elseif( isset( $_GET["id"] ) ){
            $contentManager->setTitles("PERSOON", "detail");
            $contentManager->addDetail("person", $_GET["id"]);
        }
        else{
            $contentManager->setTitles("Bekende mensen");
            $contentManager->addSection("person");
        }
    }

    // laad profile pagina
    elseif ( isset( $_GET["profile"] ) ){
        $contentManager->setTitles("profielpagina");
    }

    // laad login pagina
    elseif( isset( $_GET["login"] ) ){
        $contentManager->setTitles("Login", "om toegang te krijgen tot de volledige pagina");
        $contentManager->addForm("login.html", "user", $old_post);
    }

    // laad register pagina
    elseif( isset( $_GET["register"] ) ){
        $contentManager->setTitles("Registreer");
        $contentManager->addForm("register.html", "user", $old_post);
    }

    $contentManager->printContent();