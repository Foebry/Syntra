
<?php
    require_once "./autoload.php";

    $table = $_POST["table"];
    $headers = getHeaders($table);

    $_SESSION["OLD_POST"] = $_POST;

    # valideer csrf-token, navigeer naar 401 indien ongeldig.
    if (!validateCSRF()) {
        $_SESSION["ERRORS"]["status"] = "U bent niet geautoriseerd om deze bewerking uit te voeren";
        exit(header('location:./status.php'));
    }

    # valideer de waarde van iedere key overeenkomend met de headers van de tabel
    foreach ($headers as $key => $values) {
        if (key_exists($key, $_POST)){
            validate($key, $values);
        }
    }

    # indien een password_verification aanwezig in het form: valideer het password.
    if (key_exists("passwords", $_POST)) ValidateUsrPassword($_POST["passwords"]);
    # indien een email aanwezig in het form: valideer het email
    if (key_exists("email", $_POST)) ValidateUsrEmail($_POST["email"]);

    # indien er errors in het form aanwezig zijn, keer terug naar het form.
    if (count($_SESSION["ERRORS"]) > 0){
        exit(header('location:'.$_SERVER["HTTP_REFERER"]));
    }

    # statement is gelijk aan de submit-value van het form.
    $statement = $_POST["submit"];

    # maak het volledige sql-statement
    $sql = buildStatement($statement);

    # voer het statement uit
    if (!execute($sql)) exit(var_dump($sql));

    # zet de info-message gelijk aan de de info-message uit het formulier.
    $_SESSION["INFO"] = $_POST["info-msg"];

    # navigeer naar de pagina gespecifieerd in het form
    header('location:' . "../oef4.2/".$_POST["aftersql"]);
 ?>
