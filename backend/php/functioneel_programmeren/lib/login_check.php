
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

 ?>
