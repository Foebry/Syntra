<?php
require_once "../lib/validate.php";

    function connectDb(){
        // read config.json
        $file = file_get_contents("../config.json");
        //convert json to associative array and navigate down to "DATABASE" key
        $data = json_decode($file, true)["DATABASE"];

        // create and return connection
        $dsn = "mysql:dbname=".$data["dbname"].";host=".$data["host"];

        return new PDO(
                        $dsn,
                        $user = $data["username"],
                        $password = $data["password"]
                    );
    }

    function GetData($conn, $query){

        $data = [];

        // query uitvoeren
        $result = $conn->query($query);

        // alle rijen opvragen
        $data = $result->fetchall(PDO::FETCH_ASSOC);
        // while($row = $result->fetch(PDO::FETCH_ASSOC)){
        //     $data[] = $row;
        // }

        if (count($data) == 1) return $data[0];
        return $data;

    }

    function execute($conn, $query){
        return $conn->query($query);
    }

    function getHeaders($table){
        $conn = connectDb();
        $sql = "select * from information_schema.columns where table_name = '$table'";
        $data = GetData($conn, $sql);
        $headers = [];

        foreach($data as $row){

            // bepalen welke data van belang is
            $column = $row["COLUMN_NAME"];
            $column_datatype = $row["DATA_TYPE"];
            $column_key = $row["COLUMN_KEY"];
            $column_max_length = $row["CHARACTER_MAXIMUM_LENGTH"];

            // nieuwe associatieve array aanmaken met nodige data.
            $headers[$column] = [];
            $headers[$column]["datatype"] = $column_datatype;
            $headers[$column]["key"] = $column_key;
            $headers[$column]["max_size"] = $column_max_length;

        }
        $_POST["DB_HEADERS"] = $headers;
        return $headers;
    }

function buildStatement(){
    //controleer csrftoken
    if (!validateCSRF()) exit("Probleem met CSRF-token");

    $table_select = $_POST["table_select"];
    $table = $_POST["table"];
    $conn = connectDb();

    // check of er in tabel images records bestaan met img_lan_id gelijk aan $_POST["img_lan_id"]
    // zoja is de image voor het bepaalde land reeds gepost en willen we update
    // anders heeft het betreffende land nog geen image gepost en willen we inserten
    $data = getData($conn, "select * from images where img_lan_id = ".$_POST["img_lan_id"]);
    $statement = $data ? "update" : "insert";
    $sql = $statement == "insert" ? "insert into $table set " : "update $table set ";

    $headers = getHeaders($table);

    // overloop alle velden vanuit de db, en valideer de overeenkomende gegevens uit $_POST
    foreach($headers as $key=>$values){
        // negeeer niet-data
        if(in_array($key, ["img_id", "img_desc", "img_published"])) continue;

        // valideer $_POST[$key]
        validate($key, $values);

        $value = $_POST[$key];

        // vul $sql aan met veld en waarde
        $sql .= "$key = '$value', ";
    }
    $sql = trim($sql, ', ');
    if($statement == "update") $sql .= "where img_id = ".$_POST["img_id"];

    //exit(var_dump($sql));
    return $sql;
}
 ?>
