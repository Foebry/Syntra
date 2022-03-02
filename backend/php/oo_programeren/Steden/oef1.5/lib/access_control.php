<?php
    $unauthorized = ($public_access !== true and array_key_exists("user", $_SESSION) === false);

    if ($unauthorized) exit(header('location:../no_access.php'));
