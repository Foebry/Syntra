<?php
$root = $_SERVER["DOCUMENT_ROOT"];
require_once "$root/lib/services/Logger.php";
require_once "security.php";
require_once "html_components.php";
require_once "validate.php";
require_once "$root/lib/services/DbManager.php";
require_once "$root/lib/services/CityLoader.php";
require_once "$root/lib/models/City.php";
require_once "$root/lib/models/User.php";

if (!isset($_SESSION)) session_start();
require_once "access_control.php";

$logger = new Logger("log.txt");
$config = json_decode(file_get_contents("$root/config.json"), true)["DATABASE"];
$dbm = new DbManager($config, $logger);
$city_loader = new CityLoader($dbm);

$old_post = [];
$errors = [];
$status = [];
$info = "";

if (key_exists("OLD_POST", $_SESSION)){
    $old_post = $_SESSION["OLD_POST"];
    $_SESSION["OLD_POST"] = [];
}
if (key_exists("ERRORS", $_SESSION)){
    $errors = $_SESSION["ERRORS"];
    $_SESSION["ERRORS"] = [];
}
if (key_exists("INFO", $_SESSION)){
    $info = $_SESSION["INFO"];
    $_SESSION["INFO"] = "";
}
if (key_exists("STATUS", $_SESSION)){
    $status = $_SESSION["STATUS"];
    $_SESSION["STATUS"] = [];
}
