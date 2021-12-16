
<?php
    require_once "./database.php";
    //exit(var_dump($_POST));
    $conn = connectDb();
    $sql = buildStatement("images");

    execute($conn, $sql);
    print("<br>");

    //var_dump($_POST);
    echo json_encode($_POST);
    header('location:' . "../oef3.2/".$_POST["aftersql"]);
 ?>
