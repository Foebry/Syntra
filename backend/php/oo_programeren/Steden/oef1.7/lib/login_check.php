<?php
    $public_access = true;

    require_once "autoload.php";
    
    if( isset($_POST["logout"] )){
        unset( $_SESSION["user"] );
        header("location:../index.php");
        die();
    }
    
    $_SESSION["old_post"] = $_POST;
    $container = $_SESSION["container"];

    $dbm = $container->getDbManager();
    $ms = $container->getMessageService();
    $userLoader = $container->getUserLoader($dbm);

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
        $user = $userLoader->getByEmail($email);
        $_SESSION["user"] = $user;
        $msg = "Welkom, ".$user->getVoornaam();
        $ms->addMessage("infos", $msg);
        exit(header("location:../"));
    }

 ?>
