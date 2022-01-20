
<?php
    require_once "./autoload.php";

    $_SESSION["OLD_POST"] = $_POST;

    # valideer csrf-token, navigeer naar status.php en zet correcte status
    if (!validateCSRF()) {
        $_SESSION["STATUS"][401] = "U bent niet geautoriseerd om deze bewerking uit te voeren";
        exit(header('location:./status.php'));
    }

    if (LoginCheck()) exit(print("INLOGGEN GELUKT"));
    exit("HELAAS");

    function LoginCheck(): bool{
        $password_hash = getData("select usr_password from ".$_POST["table"]." where usr_email = '" .$_POST["usr_email"] ."'")[0]["usr_password"];
        return ($password_hash && password_verify($_POST["usr_password"], $password_hash));
    }

 ?>
