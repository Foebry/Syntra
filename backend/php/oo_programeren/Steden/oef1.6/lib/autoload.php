<?php
$root = $_SERVER["DOCUMENT_ROOT"];

require_once "$root/lib/models/City.php";
require_once "$root/lib/models/User.php";
require_once "$root/lib/models/Container.php";
require_once "$root/lib/services/Logger.php";
require_once "$root/lib/services/DbManager.php";
require_once "$root/lib/services/CityLoader.php";
require_once "$root/lib/services/UserLoader.php";
require_once "$root/lib/services/MessageService.php";

if (!isset($_SESSION)) session_start();

if(!isset($_SESSION["container"])) $_SESSION["container"] = new Container();
if(!isset($_SESSION["input_errors"])) $_SESSION["input_errors"] = [];
if(!isset($_SESSION["errors"])) $_SESSION["errors"] = [];
if(!isset($_SESSION["infos"])) $_SESSION["infos"] = [];
if(!isset($_SESSION["OLD_POST"])) $_SESSION["OLD_POST"] = [];

require_once "security.php";
require_once "html_components.php";
require_once "validate.php";

require_once "access_control.php";

$old_post = $_SESSION["OLD_POST"];
$_SESSION["OLD_POST"] = [];
