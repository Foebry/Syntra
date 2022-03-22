<?php

function access_control($ms, $path_to_root)
{
    $uri = $_SERVER["REQUEST_URI"];

    $notLoggedIn = !isset($_SESSION["user"]);
    $notAdmin = $notLoggedIn || $_SESSION["user"]->getType() != "admin";

    $add = strpos($uri, "add") !== false;
    $edit = strpos($uri, "edit") !== false;
    $log = $uri == "/server-log";
    $profile = $uri == "/profile";

    $unauthorized = ($notLoggedIn && $add) || ($notLoggedIn && $edit) || ($notAdmin && $log) || ($notLoggedIn && $profile);

    if ($unauthorized) {
        $msg = "";

        if ($log) $msg = "Niet toegestaan!";
        elseif ($profile) $msg = "U bent niet ingelogd. Klik <a href='./login'>hier</a> om in te loggen.";
        elseif ($edit) $msg = "U heeft geen toegang. <a href='@@root@@/login'>Log in</a> om te bewerken.";
        elseif ($add) $msg = "U heeft geen toegang. <a href='@@root@@/login'>Log in</a> om toe te voegen.";

        $ms->addMessage("infos", $msg);
        exit(header("location:$path_to_root"));
    }
}
