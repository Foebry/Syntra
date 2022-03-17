<?php

    $public_access = true;
    

    require_once "lib/autoload.php";

    $container = $_SESSION["container"];

    $contentManager = $container->getContentManager();

    // laad homepage
    if ( count($_GET) == 0){
        $contentManager->setTitles("Home");
        $contentManager->addPopularSection("images", "populaire steden");
    }
    elseif( isset( $_GET["search"] ) ){
        print("searching");
    }

    // laad steden pagina
    elseif( isset( $_GET["steden"] ) ){

        if ( isset( $_GET["id"] ) ){
            print( "specific city ". $_GET["id"] );
        }
        else{
            print("alle steden");
        }
    }

    // laad mensen pagina
    elseif( isset( $_GET["people"]) ){
        

        if( isset( $_GET["id"] ) ){
            print("specific mens");
        }
        else{
            print("mensen pagina");
        }
    }

    // laad profile pagina
    elseif ( isset( $_GET["profile"] ) ){
        print("profile pagina");
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