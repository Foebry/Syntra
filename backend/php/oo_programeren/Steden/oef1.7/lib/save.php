
<?php
    $public_access = true;

    require_once "autoload.php";

    $container = $_SESSION["container"];
    $dbm = $container->getDbManager();
    $ms = $container->getMessageService();
    $userLoader = $container->getUserLoader();

    $table = $_POST["table"];
    $headers = $dbm->getHeaders($table);

    $_SESSION["old_post"] = $_POST;

    # valideer csrf-token, navigeer naar status.php en zet correcte status
    if (!validateCSRF()) {
        $_SESSION["STATUS"][401] = "U bent niet geautoriseerd om deze bewerking uit te voeren";
        exit(header('location:./status.php'));
    }

    # valideer de waarde van iedere key overeenkomend met de headers van de tabel
    foreach ($_POST as $key => $value) {
        if( !in_array($key, ["csrf", "table", "aftersql", "pkey", "email", "action", "info-msg", "register", "DB_HEADERS", "submit"]) and in_array($key, $headers)){
            validate($key, $value, $dbm, $ms);
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
    $pkey = $_POST["pkey"];
    $id = $_POST[$pkey];
    $object = $dbm->GetData("select * from $table where $pkey = $id");
    
    $statement = count($object) > 0 ? "update" : "insert";

    # maak het volledige sql-statement
    $sql = $dbm->buildStatement($statement, $pkey);
    # voer het statement uit
    if (!$dbm->execute($sql)) exit(var_dump($sql));

    # zet de info-message gelijk aan de de info-message uit het formulier.
    $_SESSION["infos"][] = $_POST["info-msg"];

    $email = isset($_POST["usr_email"]) ? $_POST["usr_email"] : $_SESSION["user"]->getEmail();
    $_SESSION["user"] = $userLoader->getByEmail($email);

    # navigeer naar de pagina gespecifieerd in het form
    header('location:'.$_POST["aftersql"]);
 ?>
