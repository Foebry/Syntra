
<?php
    require_once "./database.php";
    $table = $_POST["table"];
    $headers = getHeaders($table);

    $_SESSION["OLD_POST"] = $_POST;

    foreach ($headers as $key => $values) {
        if (key_exists($key, $_POST)){
            validate($key, $values);
        }
    }

    if (key_exists("passwords", $_POST)) ValidateUsrPassword($_POST["passwords"]);
    if (key_exists("email", $_POST)) ValidateUsrEmail($_POST["email"]);

    if (count($_SESSION["ERRORS"]) > 0){
        exit(header('location:'.$_SERVER["HTTP_REFERER"]));
    }

    $sql = $_POST["submit"] == "insert" ? "insert into " : $_POST["submit"] == "update" ? "update $table " : "";
    $sql = "insert into ".$_POST["table"]." set usr_voornaam = '".$_POST["usr_voornaam"]."', usr_naam = '".$_POST["usr_naam"]."', usr_email = '".$_POST["usr_email"]."', usr_password = '".$_POST["usr_password"]."'";

    execute($sql);

    $_SESSION["INFO"] = "Bedankt voor uw registratie";
    header('location:' . "../oef4.2/".$_POST["aftersql"]);
 ?>
