
<?php
    $public_access = true;

    require_once "autoload.php";

    $container = $_SESSION["container"];
    $dbm = $container->getDbManager();
    $ms = $container->getMessageService();
    $user_loader = $container->getUserLoader();

    $table = $_POST["table"];
    $headers = $dbm->getHeaders($table);

    $_SESSION["OLD_POST"] = $_POST;

    # valideer csrf-token, navigeer naar status.php en zet correcte status
    if (!validateCSRF()) {
        $_SESSION["STATUS"][401] = "U bent niet geautoriseerd om deze bewerking uit te voeren";
        exit(header('location:./status.php'));
    }

    # valideer de waarde van iedere key overeenkomend met de headers van de tabel
    foreach ($headers as $key => $values) {
        if (key_exists($key."_verification", $_POST) and $_POST[$key."_verification"] == "") $_POST[$key."_verification"] = "null";

        if (key_exists($key, $_POST) and $key != $_POST["pkey"]){
            validate($key, $values, $dbm, $ms);
        }
    }

    # indien een password_verification aanwezig in het form: valideer het password.
    if (key_exists("passwords", $_POST)) ValidateUsrPassword($_POST["passwords"], $ms);
    # indien een email aanwezig in het form: valideer het email
    if (key_exists("email", $_POST)) ValidateUsrEmail($_POST["email"], $ms);

    # indien er errors in het form aanwezig zijn, keer terug naar het form.
    if (count($_SESSION["input_errors"]) > 0 OR count($_SESSION["errors"]) > 0){
        exit(header('location:'.$_SERVER["HTTP_REFERER"]));
    }

    # statement is gelijk aan de submit-value van het form.
    $statement = $_POST["submit"];

    # maak het volledige sql-statement
    $sql = $dbm->buildStatement($statement);

    # voer het statement uit
    if (!$dbm->execute($sql)) exit(var_dump($sql));

    # zet de info-message gelijk aan de de info-message uit het formulier.
    $_SESSION["infos"][] = $_POST["info-msg"];

    # zet de user gelijk aan het email van de registratie
    $user = $user_loader->getUserByEmail($_POST["usr_email"]);
    $_SESSION["user"] = $user;

    # navigeer naar de pagina gespecifieerd in het form
    header('location:'.$_POST["aftersql"]);
 ?>
