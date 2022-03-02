<?php
$root = $_SERVER["DOCUMENT_ROOT"];
require_once "$root/lib/services/Logger.php";
require_once "security.php";
require_once "html_components.php";
require_once "validate.php";
require_once "$root/lib/services/DbManager.php";
require_once "$root/lib/services/CityLoader.php";
require_once "$root/lib/services/MessageService.php";
require_once "$root/lib/models/City.php";
require_once "$root/lib/models/User.php";

if (!isset($_SESSION)) session_start();
require_once "access_control.php";

$logger = new Logger("log.txt");
$config = json_decode(file_get_contents("$root/config.json"), true)["DATABASE"];
$dbm = new DbManager($config, $logger);
$city_loader = new CityLoader($dbm);
$ms = new MessageService($_SESSION["infos"], $_SESSION["errors"], $_SESSION["input_errors"]);

if(!isset($_SESSION["input_errors"])) $_SESSION["input_errors"] = [];
if(!isset($_SESSION["errors"])) $_SESSION["errors"] = [];
if(!isset($_SESSION["infos"])) $_SESSION["infos"] = [];
if(!isset($_SESSION["OLD_POST"])) $_SESSION["OLD_POST"] = [];

$old_post = $_SESSION["OLD_POST"];
$_SESSION["OLD_POST"] = [];
