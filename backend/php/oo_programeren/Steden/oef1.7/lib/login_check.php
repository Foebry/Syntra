<?php
    $public_access = true;

    require_once "autoload.php";
    
    if( isset($_POST["logout"] )){
        unset( $_SESSION["user"] );
        header("location:../");
        die();
    }
    
    $_SESSION["old_post"] = $_POST;
    $container = $_SESSION["container"];

    $dbm = $container->getDbManager();
    $ms = $container->getMessageService();
    $userLoader = $container->getUserLoader($dbm);

    $headers = $dbm->getHeaders($table="user");

    # valideer csrf-token
    if (!validateCSRF()) {
        $ms->addMessage("messages", "Fout met CSRF token");

        exit(header('location:../'));
    }

    if (key_exists("email", $_POST)) ValidateUsrEmail($_POST["email"], $ms);
    if (count($_SESSION["input_errors"]) > 0 or count($_SESSION["errors"]) > 0) {
        exit(header("Location: ../?login"));
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
