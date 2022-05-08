<?php
    global $public_access;
    
    $unauthorized = (!$public_access and !array_key_exists("user", $_SESSION));

    if ($unauthorized) exit(header('location:../no_access.php'));

    $public_access = false;
