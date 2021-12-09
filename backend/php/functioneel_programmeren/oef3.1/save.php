<?php
    require_once "../src/database.php";
    $conn = connectDb();
    $sql = "update images set";
    foreach($_POST as $key=>$value){
        if(strpos($key, "_id")) continue;
        $sql .= " $key = '$value', ";
    }
    $sql = trim($sql, ', ');
    $sql .= ' where img_id = ' . $_POST["img_id"];
    print($sql);
    print("<br>");

    execute($conn, $sql);
    //var_dump($_POST);
    print json_encode($_POST);
 ?>
