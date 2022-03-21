<?php
    $public_access = true;

    require_once "autoload.php";

    $_SESSION["OLD_POST"] = $_POST;
    $container = $_SESSION["container"];

    $dbm = $container->getDbManager();
    $ms = $container->getMessageService();
    $user_loader = $container->getUserLoader($dbm);

    $headers = $dbm->getHeaders($table="user");

    # valideer csrf-token, navigeer naar status.php en zet correcte status
    if (!validateCSRF()) {
        $_SESSION["STATUS"][401] = "U bent niet geautoriseerd om deze bewerking uit te voeren";
        exit(header('location:status.php'));
    }

    if (key_exists("email", $_POST)) ValidateUsrEmail($_POST["email"], $ms);

    if (count($_SESSION["input_errors"]) > 0 or count($_SESSION["errors"]) > 0) {

        exit(header("Location: ../login.php"));
    }

    if (LoginCheck($dbm, $ms)){
        $email = $_POST["usr_email"];
        $user = $user_loader->getUserByEmail($email);
        $_SESSION["user"] = $user;
        $msg = "Welkom, ".$user->getVoornaam();
        $ms->addMessage("infos", $msg);
        exit(header("location:../steden.php"));
    }

 ?>
