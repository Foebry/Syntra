<?php
    
    function access_control($ms, $msgType, $msg){

        $notLoggedIn = !isset( $_SESSION["user"] );
        $notAdmin = $notLoggedIn || $_SESSION["user"]->getType() != "admin";

        $add = strpos($_SERVER["REQUEST_URI"], "&add") !== false;
        $edit = strpos($_SERVER["REQUEST_URI"], "&edit") !== false;
        $log = strpos($_SERVER["REQUEST_URI"], "&log", true) !== false;


        $unauthorized = ($notLoggedIn && $add) || ($notLoggedIn && $edit) || ($notAdmin && $log);

        if ($unauthorized) {
            $ms->addMessage($msgType, $msg);
            header("location:../");
        }
    }
