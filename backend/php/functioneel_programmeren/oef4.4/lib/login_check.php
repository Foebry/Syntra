<?php
    require_once "autoload.php";

    $_SESSION["OLD_POST"] = $_POST;
    $headers = getHeaders($table="user");

    # valideer csrf-token, navigeer naar status.php en zet correcte status
    if (!validateCSRF()) {
        $_SESSION["STATUS"][401] = "U bent niet geautoriseerd om deze bewerking uit te voeren";
        exit(header('location:status.php'));
    }

    if (key_exists("email", $_POST)) ValidateUsrEmail($_POST["email"]);
    //exit(var_dump($_SESSION));
    if (count($_SESSION["ERRORS"]) > 0) exit(header("location:../login.php"));

    if (LoginCheck()){
        $data = getData("select * from user where usr_email = '".$_POST["usr_email"]."'");
        $_SESSION["user"] = $data[0];
        $_SESSION["INFO"] = "Welkom, ".$_SESSION["user"]["usr_voornaam"];
        exit(header("location:../steden.php"));
    }
    unset($_SESSION["user"]);
    //exit(var_dump($_SESSION));
    exit(header('location:../no_access.php'));

 ?>
