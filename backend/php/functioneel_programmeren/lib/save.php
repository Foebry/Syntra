
<?php
    header('Content-Type: application/json; charset=utf-8');
    header('location:' . $_SERVER['HTTP_REFERER']);
    require_once "./database.php";

    $conn = connectDb();
    $sql = "update images set";

    foreach($_POST as $key=>$value){
        // id wordt niet veranderd
        if(strpos($key, "_id")) continue;

        $sql .= " $key = '$value', ";
    }
    // verwijder laatste character dat een ',' is.
    $sql = trim($sql, ', ');
    // filter op img_id
    $sql .= ' where img_id = ' . $_POST["img_id"];
    print($sql);
    print("<br>");

    execute($conn, $sql);
    //var_dump($_POST);
    echo json_encode($_POST);
 ?>
