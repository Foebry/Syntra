<?php

require_once "lib/autoload.php";

$container = $_SESSION["container"];

$contentManager = $container->getContentManager();
$contentManager->initPage();

$ms = $container->getMessageService();
$dbm = $container->getDbManager();
$cityLoader = $container->getCityLoader();
$personLoader = $container->getPersonLoader();

$uri = $_SERVER["REQUEST_URI"];
$method = $_SERVER["REQUEST_METHOD"];
$root = $_SERVER["DOCUMENT_ROOT"];
$path_to_root = ".";

// routes benoemen
$zoek_functie_gebruikt = $method == "POST" && $uri == "/search";
$navigeer_naar_login = $uri == "/login";
$navigeer_naar_register = $uri == "/register";
$navigeer_naar_server_log = $uri == "/server-log";
$navigeer_naar_profiel_pagina = $uri == "/profile";
$navigeer_naar_personen_geboren_in_bepaalde_stad = (strpos($uri, "/steden/") !== false && strpos($uri, "/people") !== false);
$navigeer_naar_stad_editeren = (strpos($uri, "/steden/") !== false && strpos($uri, "edit") !== false);
$navigeer_naar_stad_toevoegen = $uri == "/steden/add";
$navigeer_naar_stad_detail = strpos($uri, "/steden/") !== false;
$navigeer_naar_steden_pagina = $uri === "/steden";
$navigeer_naar_people_pagina = $uri === "/people";
$navigeer_naar_person_editeren = (strpos($uri, "/people/") !== false && strpos($uri, "edit") !== false);
$navigeer_naar_person_toevoegen = $uri == "/people/add";
$navigeer_naar_person_detail = strpos($uri, "/people/") !== false;


$access_control_vereist = in_array(
    true,
    [
        $navigeer_naar_server_log, $navigeer_naar_profiel_pagina, $navigeer_naar_stad_editeren,
        $navigeer_naar_stad_toevoegen, $navigeer_naar_person_editeren, $navigeer_naar_person_toevoegen
    ]
);

// voer access_controle uit indien nodig
if ($access_control_vereist) access_control($ms, $path_to_root);

// zet path naar root
if (in_array(
    true,
    [
        $navigeer_naar_personen_geboren_in_bepaalde_stad, $navigeer_naar_stad_editeren,
        $navigeer_naar_person_editeren, $navigeer_naar_person_toevoegen
    ]
)) $path_to_root = "../..";
elseif (in_array(true, [$navigeer_naar_stad_detail, $navigeer_naar_person_detail])) $path_to_root = "..";


/**
 * REQUEST_URI wanneer gebruiker gebruik maakt van de zoekfunctie
 * 
 * -> index/search
 */
if ($zoek_functie_gebruikt) {

    $search = $_POST["search"];
    $whereCity = "where name like '%$search%'";
    $whereAuthor = "where type = 'auteur' and name like '%$search%'";
    $whereSinger = "where type in ('zanger', 'zangeres') and name like '%$search%'";
    $contentManager->setTitles("home", "u zocht op '$search'");
    $contentManager->addSection($dbm, $db = "stad", $title = "steden", $limit = null, $whereCity);
    $contentManager->addSection($dbm, $db = "person", $title = "auteurs", $limit = null, $whereAuthor);
    $contentManager->addSection($dbm, $db = "person", $title = "zangers & zangeressen", $limit = null, $whereSinger);
}

/**
 * REQUEST_URI voor login pagina
 * 
 * -> index/login
 */
elseif ($navigeer_naar_login) {

    checkAlreadyLoggedIn($ms);

    $contentManager->setTitles("Login", "om toegang te krijgen tot de volledige pagina");
    $contentManager->addForm($dbm, "login.html", "user", $old_post, []);
}

/**
 * REQUEST_URI voor register pagina
 * 
 * -> index/register
 */
elseif ($navigeer_naar_register) {

    checkAlreadyLoggedIn($ms);

    $contentManager->setTitles("Registreer");
    $contentManager->addForm($dbm, "register.html", "user", $old_post, []);
}

/**
 * REQUEST_URI voor logs
 * 
 * -> index/server-log
 */
elseif ($navigeer_naar_server_log) {

    $logger = $container->getLogger();
    $contentManager->setTitles("Log");
    $contentManager->showLog($logger);
}

/**
 * REQUEST_URI voor profielpagina
 * 
 * -> index/profile
 */
elseif ($navigeer_naar_profiel_pagina) {

    $id = $_SESSION["user"]->getId();
    $data = $dbm->getData("select usr_id, usr_voornaam, usr_naam, usr_email, usr_avatar from user where usr_id =$id")[0];
    $contentManager->setTitles("profielpagina");
    $contentManager->addForm($dbm, "profile.html", "user", $old_post, $data);
}

// navigeren naar personen uit bepaalde stad of stad editeren
elseif ($navigeer_naar_personen_geboren_in_bepaalde_stad || $navigeer_naar_stad_editeren) {

    $substr = explode("/steden/", $uri)[1];
    $id = $navigeer_naar_personen_geboren_in_bepaalde_stad ? explode("/people", $substr)[0] : explode("/edit", $substr)[0];

    $stadNaam = getNameIfValidId($id, $path_to_root, "stad", $dbm, $cityLoader);

    /**
     * REEQUEST_URI voor personen geboren in een bepaalde stad.
     * 
     * -> index/steden/{id}/people
     */
    if ($navigeer_naar_personen_geboren_in_bepaalde_stad) {
        $where = "where cob = $id";
        $contentManager->setTitles("Bekende mensen", "geboren in $stadNaam");
        $contentManager->addSection($dbm, $db = "person", $title = null, $limit = null, $where);
    }
    /**
     * REQUEST_URI voor stad editeren
     * 
     * -> index/steden/{id}/edit
     */
    else {
        $contentManager->setTitles($stadNaam, "edit");
        $data = $dbm->GetData("select * from stad where id = $id")[0];
        $contentManager->addForm($dbm, "edit.html", "stad", $old_post, $data);
    }
}

/**
 * REQUEST_URI voor stad toevoegen
 * 
 * -> index/steden/add
 */
elseif ($navigeer_naar_stad_toevoegen) {

    $contentManager->setTitles("Stad", "toevoegen");
    $contentManager->addForm($dbm, "edit.html", "stad", $old_post, []);
}

/**
 * REQUEST_URI om details stad op te vragen
 * 
 * -> index/steden/{id}
 */
elseif ($navigeer_naar_stad_detail) {

    $id = explode("/steden/", $uri)[1];

    $cityName = getNameIfValidId($id, $path_to_root, "stad", $dbm, $cityLoader);
    $contentManager->setTitles($cityName, "detail");
    $contentManager->addDetail($cityLoader, null, "stad", $id);
}

/**
 * REQUEST_URI om steden pagina op te vragen
 * 
 * -> index/steden
 */
elseif ($navigeer_naar_steden_pagina) {

    $contentManager->setTitles("steden");
    $contentManager->addSection($dbm, "stad");
}

/**
 * REQUEST_URI om people pagina op te vragen
 * 
 * -> index/people
 */
elseif ($navigeer_naar_people_pagina) {

    $contentManager->setTitles("Bekende mensen");
    $contentManager->addSection($dbm, "person");
}

/**
 * REQUEST_URI om details specifieke person te wijzigen
 * 
 * -> index/people/{id}/edit
 */
elseif ($navigeer_naar_person_editeren) {

    $substr = explode("/people/", $uri)[1];
    $id = explode("/edit", $substr)[0];

    $personName = getNameIfValidId($id, $path_to_root, "person", $dbm, $personLoader);

    $contentManager->setTitles($personName, "edit");
    $data = $dbm->GetData("select * from person where id = $id")[0];
    $contentManager->addForm($dbm, "edit.html", "person", $old_post, $data);
}

/**
 * REQUEST_URI om persoon toe te voegen
 * 
 * -> index/people/add
 */
elseif ($navigeer_naar_person_toevoegen) {

    $contentManager->setTitles("Persoon", "toevoegen");
    $contentManager->addForm($dbm, "edit.html", "person", $old_post, []);
}

/**
 * REQUEST_URI om details specifieke person op te vragen
 * 
 * -> index/people/{id}
 */
elseif ($navigeer_naar_person_detail) {

    $id = explode("/people/", $uri)[1];

    $personName = getNameIfValidId($id, $path_to_root, "person", $dbm, $personLoader);
    $contentManager->setTitles($personName, "detail");
    $contentManager->addDetail($cityLoader, $personLoader, "person", $id);
}

/**
 * Alle andere REQUEST_URI's
 */
else {
    $whereAuthor = "where type = 'auteur'";
    $whereSinger = "where type in ('zanger', 'zangeres')";
    $contentManager->setTitles("Home");
    $contentManager->addSection($dbm, $db = "stad", $title = "populaire steden", $limit = 3);
    $contentManager->addSection($dbm, $db = "person", $title = "Bekende auteurs", $limit = 3, $whereAuthor);
    $contentManager->addSection($dbm, $db = "person", $title = "Bekende zangers & zangeressen", $limit = 3, $whereSinger);
}


$contentManager->printContent($ms, $path_to_root);



function getNameIfValidId($id, $path_to_root, $table, $dbm, $loader)
{
    $redirects = [
        "person" => "people",
        "stad" => "steden"
    ];
    $page = $redirects[$table];

    // check dat stad id numeriek is en bestaat in de db
    if (is_numeric($id) && count($dbm->getData("select * from $table where id = $id")) > 0) {

        $name = $loader->getById($id)->getName();

        return $name;
    } else {
        exit(header("location:$path_to_root/$page"));
    }
}


function checkAlreadyLoggedIn($ms)
{
    // gebruiker kan niet meer naar de login pagina gaan indien deze reeds ingelogd is.
    if (isset($_SESSION["user"])) {
        $ms->addMessage("infos", "U bent reeds ingelogd");
        exit(header("location:."));
    }
}
