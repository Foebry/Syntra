
<?php
    //header('Content-Type: application/json; charset=utf-8');
    require_once "./database.php";
    // require_once "./validate.php";
    //
    // $validated = validateForm($_POST, "images");
    //
    // if ($validated !== true) exit(var_dump($validated));

    $conn = connectDb();
    $sql = 'update images set ';

    foreach($_POST as $key=>$value){
        $value = trim($value);
        $sql .= $key.' = "'.$value.'", ';
    }
    // verwijder laatste character dat een ',' is.
    $sql = trim($sql, ', ');
    // filter op img_id
    $sql .= ' where img_id = ' . $_POST["img_id"];

    execute($conn, $sql);
    print("<br>");

    //var_dump($_POST);
    echo json_encode($_POST);
    header('location:' . "../oef3.2/steden2.php");
 ?>
