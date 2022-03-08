<?php
    $public_access = true;
    require_once "autoload.php";

    $_SESSION["OLD_POST"] = $_POST;
    $headers = $dbm->getHeaders($table="user");

    # valideer csrf-token, navigeer naar status.php en zet correcte status
    if (!validateCSRF()) {
        $_SESSION["STATUS"][401] = "U bent niet geautoriseerd om deze bewerking uit te voeren";
        exit(header('location:status.php'));
    }

    if (key_exists("email", $_POST)) ValidateUsrEmail($_POST["email"]);
    //exit(var_dump($_SESSION));
    if (count($_SESSION["ERRORS"]) > 0) exit(header("location:../login.php"));

    if (LoginCheck($dbm)){
        $email = $_POST["usr_email"];
        $user = $dbm->getUserByEmail($email);

        $_SESSION["user"] = $user;
        $_SESSION["INFO"] = "Welkom, ".$user->getVoornaam();

        exit(header("location:../steden.php"));
    }
    unset($_SESSION["user"]);
    //exit(var_dump($_SESSION));
    exit(header('location:../no_access.php'));

 ?>
