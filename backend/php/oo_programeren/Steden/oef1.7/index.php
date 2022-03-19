<?php

    $public_access = true;
    

    require_once "lib/autoload.php";

    $container = $_SESSION["container"];

    $contentManager = $container->getContentManager();

    // laad homepage
    if( isset( $_GET["search"] ) ){
        $search = $_GET["search"];
        $whereCity = "where name like '%$search%'";
        $whereAuthor = "where type = 'auteur' and name like '%$search%'";
        $whereSinger = "where type in ('zanger', 'zangeres') and name like '%$search%'";
        $contentManager->setTitles("home", "u zocht op $search");
        $contentManager->addSection($db="stad", $title="steden", $limit=null, $whereCity);
        $contentManager->addSection($db="person", $title="auteurs", $limit=null, $whereAuthor);
        $contentManager->addSection($db="person", $title="zangers & zangeressen", $limit=null, $whereSinger);
    }

    // laad steden pagina
    elseif( isset( $_GET["steden"] ) ){

        if ( isset( $_GET["id"] ) ){
            $id = $_GET["id"];
            $cityName = $contentManager->cityLoader->getById($id)->getName();
            
            if ( isset( $_GET["edit"] ) ){
                $contentManager->setTitles($cityName, "edit");
                $data = $container->getDbManager()->GetData("select * from stad where id = $id")[0];
                $contentManager->addForm("edit.html", "stad", $old_post, $data);
            }
            else{
                $contentManager->setTitles($cityName, "detail");
                $contentManager->addDetail("stad", $id);
            }
        }
        elseif( isset( $_GET["add"] ) ){
            $contentManager->setTitles("Stad", "toevoegen");
            $contentManager->addForm("edit.html", "stad", $old_post, []);
        }
        else{
            $contentManager->setTitles("steden");
            $contentManager->addSection("stad");
        }
    }

    // laad mensen pagina
    elseif( isset( $_GET["people"]) ){
        // mensen geboren in bepaalde stad
        if( isset( $_GET["cob"] ) ){
            $cityId = $_GET["cob"];
            $stadNaam = $contentManager->cityLoader->getById($cityId)->getName();
            $where = "where cob = $cityId";
            $contentManager->setTitles("Bekende mensen", "geboren in $stadNaam");
            $contentManager->addSection($db="person", $title=null, $limit=null, $where);
        }

        elseif( isset( $_GET["id"] ) ){
            $personId = $_GET["id"];
            $name = $contentManager->personLoader->getById($personId)->getFullName();
            // persoon formulier
            if ( isset( $_GET["edit"] ) ){
                $contentManager->setTitles($name, "edit");
                $data = $container->getDbManager()->GetData("select * from person where id = $personId")[0];
                $contentManager->addForm("edit.html", "person", $old_post, $data);
            }
            // persoon detail
            else{
                $contentManager->setTitles($name, "detail");
                $contentManager->addDetail("person", $personId);
            }
        }
        elseif( isset( $_GET["add"] ) ){
            $contentManager->setTitles("Persoon", "toevoegen");
            $contentManager->addForm("edit.html", "person", $old_post, []);
        }
        else{
            $contentManager->setTitles("Bekende mensen");
            $contentManager->addSection("person");
        }
    }

    // laad profile pagina
    elseif ( isset( $_GET["profile"] ) ){
        $id = $_SESSION["user"]->getId();
        $data = $container->getDbManager()->getData("select usr_id, usr_voornaam, usr_naam, usr_email, usr_avatar from user where usr_id =$id")[0];
        $contentManager->setTitles("profielpagina");
        $contentManager->addForm("profile.html", "user", $old_post, $data);
    }

    // laad login pagina
    elseif( isset( $_GET["login"] ) ){
        $contentManager->setTitles("Login", "om toegang te krijgen tot de volledige pagina");
        $contentManager->addForm("login.html", "user", $old_post, []);
    }

    // laad register pagina
    elseif( isset( $_GET["register"] ) ){
        $contentManager->setTitles("Registreer");
        $contentManager->addForm("register.html", "user", $old_post, []);
    } 
    else{
        $whereAuthor = "where type = 'auteur'";
        $whereSinger = "where type in ('zanger', 'zangeres')";
        $contentManager->setTitles("Home");
        $contentManager->addSection($db="stad", $title="populaire steden", $limit=3);
        $contentManager->addSection($db="person", $title="Bekende auteurs", $limit=3, $whereAuthor);
        $contentManager->addSection($db="person", $title="Bekende zangers & zangeressen", $limit=3, $whereSinger);
    }

    $contentManager->printContent();