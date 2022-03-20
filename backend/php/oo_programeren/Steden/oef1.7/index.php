<?php

    $public_access = true;
    

    require_once "lib/autoload.php";

    $container = $_SESSION["container"];

    $contentManager = $container->getContentManager();
    $contentManager->initPage();

    $ms = $container->getMessageService();
    $dbm = $container->getDbManager();
    $cityLoader = $container->getCityLoader();
    $personLoader = $container->getPersonLoader();

    // laad homepage
    if( isset( $_GET["search"] ) ){
        $search = $_GET["search"];
        $whereCity = "where name like '%$search%'";
        $whereAuthor = "where type = 'auteur' and name like '%$search%'";
        $whereSinger = "where type in ('zanger', 'zangeres') and name like '%$search%'";
        $contentManager->setTitles("home", "u zocht op $search");
        $contentManager->addSection($dbm, $db="stad", $title="steden", $limit=null, $whereCity);
        $contentManager->addSection($dbm, $db="person", $title="auteurs", $limit=null, $whereAuthor);
        $contentManager->addSection($dbm, $db="person", $title="zangers & zangeressen", $limit=null, $whereSinger);
    }

    // laad steden pagina
    elseif( isset( $_GET["steden"] ) ){

        if ( isset( $_GET["id"] ) ){
            $id = $_GET["id"];
            $cityName = $cityLoader->getById($id)->getName();
            
            if ( isset( $_GET["edit"] ) ){
                access_control($ms, "infos", "U heeft geen toegang.<a href='./?login'>Log in</a> om te bewerken.");
            
                $contentManager->setTitles($cityName, "edit");
                $data = $dbm->GetData("select * from stad where id = $id")[0];
                $contentManager->addForm($dbm, "edit.html", "stad", $old_post, $data);
            }
            else{
                $contentManager->setTitles($cityName, "detail");
                $contentManager->addDetail($cityLoader, null, "stad", $id);
            }
        }
        elseif( isset( $_GET["add"] ) ){
            access_control($ms, "infos", "U heeft geen toegang. <a href='./?login'>Log in</a> om toe te voegen.");

            $contentManager->setTitles("Stad", "toevoegen");
            $contentManager->addForm($dbm, "edit.html", "stad", $old_post, []);
        }
        else{
            $contentManager->setTitles("steden");
            $contentManager->addSection($dbm, "stad");
        }
    }

    // laad mensen pagina
    elseif( isset( $_GET["people"]) ){

        // mensen geboren in bepaalde stad
        if( isset( $_GET["cob"] ) ){
            $cityId = $_GET["cob"];
            $stadNaam = $cityLoader->getById($cityId)->getName();
            $where = "where cob = $cityId";
            $contentManager->setTitles("Bekende mensen", "geboren in $stadNaam");
            $contentManager->addSection($dbm, $db="person", $title=null, $limit=null, $where);
        }

        elseif( isset( $_GET["id"] ) ){
            $personId = $_GET["id"];
            $name = $personLoader->getById($personId)->getFullName();
            // persoon formulier
            if ( isset( $_GET["edit"] ) ){
                access_control($ms, "infos", "U heeft geen toegang. <a href='./?login'>Log in</a> om te bewerken.");

                $contentManager->setTitles($name, "edit");
                $data = $dbm->GetData("select * from person where id = $personId")[0];
                $contentManager->addForm($dbm, "edit.html", "person", $old_post, $data);
            }
            // persoon detail
            else{
                $contentManager->setTitles($name, "detail");
                $contentManager->addDetail($cityLoader, $personLoader, "person", $personId);
            }
        }
        elseif( isset( $_GET["add"] ) ){
            access_control($ms, "infos", "U heeft geen toegang. <a href='./?login'>Log in</a> om toe te voegen.");

            $contentManager->setTitles("Persoon", "toevoegen");
            $contentManager->addForm($dbm, "edit.html", "person", $old_post, []);
        }
        else{
            $contentManager->setTitles("Bekende mensen");
            $contentManager->addSection($dbm, "person");
        }
    }

    // laad profile pagina
    elseif ( isset( $_GET["profile"] ) ){
        access_control($ms, "infos", "U bent niet ingelogd. Klik <a href='./?login'>hier</a> om in te loggen.");
        
        $id = $_SESSION["user"]->getId();
        $data = $dbm->getData("select usr_id, usr_voornaam, usr_naam, usr_email, usr_avatar from user where usr_id =$id")[0];
        $contentManager->setTitles("profielpagina");
        $contentManager->addForm($dbm, "profile.html", "user", $old_post, $data);
    }

    // laad login pagina
    elseif( isset( $_GET["login"] ) ){
        $contentManager->setTitles("Login", "om toegang te krijgen tot de volledige pagina");
        $contentManager->addForm($dbm, "login.html", "user", $old_post, []);
    }

    // laad register pagina
    elseif( isset( $_GET["register"] ) ){
        $contentManager->setTitles("Registreer");
        $contentManager->addForm($dbm, "register.html", "user", $old_post, []);
    } 
    elseif( isset( $_GET["log"] ) ){
        access_control($ms, "infos", "Geen toegang");
        
        $logger = $container->getLogger();
        $contentManager->setTitles("Log");
        $contentManager->showLog($logger);
    }
    else{
        $whereAuthor = "where type = 'auteur'";
        $whereSinger = "where type in ('zanger', 'zangeres')";
        $contentManager->setTitles("Home");
        $contentManager->addSection($dbm, $db="stad", $title="populaire steden", $limit=3);
        $contentManager->addSection($dbm, $db="person", $title="Bekende auteurs", $limit=3, $whereAuthor);
        $contentManager->addSection($dbm, $db="person", $title="Bekende zangers & zangeressen", $limit=3, $whereSinger);
    }

    $contentManager->printContent($ms);