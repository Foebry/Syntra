<?php
require_once "../lib/validate.php";

    function connectDb(){
        /**
        * functie verantwoordelijk voor het creëren van een connectie met de db van het project.
        */
        // laad content config.json in
        $file = file_get_contents("../config.json");
        // hervorm json naar een associatieve array en navigeer "DATABASE" key.
        $data = json_decode($file, true)["DATABASE"];

        // maak connectie met de db en geef het connectie object terug
        $dsn = "mysql:dbname=".$data["dbname"].";host=".$data["host"];

        return new PDO(
                        $dsn,
                        $user = $data["username"],
                        $password = $data["password"]
                    );
    }

    function GetData($query){
        /**
        * functie verantwoordelijk voor het opvragen en teruggeven van data uit de databank.
        */

        $data = [];
        // creëer een connectie
        $conn = connectDb();

        // query uitvoeren
        $result = $conn->query($query);

        // alle rijen opvragen en teruggeven
        return $result->fetchall(PDO::FETCH_ASSOC);

    }

    function execute($query){
        /**
        * functie verantwoordelijk voor het uitvoeren van queries.
        * bv. UPDATE - INSERT - DELETE - CREATE - DROP
        */

        // aanmaken connectie
        $conn = connectDb();

        return $conn->query($query);
    }

    function getHeaders($table){
        /**
        * functie verantwoordelijk voor het opvragen van de tabelhoofdingen voor een opgegeven tabel.
        * @param $table: tabel waarvoor de hoofdingen gevraagd wordt.
        * @type $table: string
        *
        * @var $headers: array van associatieve arrays die de nodige metadata bevat over iedere kolom van de database
        */

        $headers = [];
        // aanmaken connectie & query
        $conn = connectDb();
        $query = "select * from information_schema.columns where table_name = '$table' and table_schema = 'steden'";

        // opvragen data ahv bovenstaande query
        $data = GetData($query);

        // voor iedere rij (gevevens van 1 kolom) nagaan en uithalen wat van belang is.
        foreach($data as $row){
            // belangrijke eigenschappen van de rij (gegevens van 1 kolom) zijn:
            // COLUMN_NAME - DATA_TYPE - COLUMN_KEY - CHARACTER_MAXIMUM_LENGTH
            $column = $row["COLUMN_NAME"];
            $column_datatype = $row["DATA_TYPE"];
            $column_key = $row["COLUMN_KEY"];
            $column_max_length = $row["CHARACTER_MAXIMUM_LENGTH"];
            $is_null = $row["IS_NULLABLE"];

            // nieuwe associatieve array aanmaken met nodige data. en toevoegen aan de $headers array
            $headers[$column] = [];
            $headers[$column]["datatype"] = $column_datatype;
            $headers[$column]["key"] = $column_key;
            $headers[$column]["max_size"] = $column_max_length;
            $headers[$column]["is_null"] = $is_null;

        }
        $_POST["DB_HEADERS"] = $headers;
        return $headers;
    }

function buildStatement(){
    //controleer csrftoken
    if (!validateCSRF()) exit("Probleem met CSRF-token");

    //$table_select = $_POST["table_select"];
    $table = $_POST["table"];

    // check of er in tabel images records bestaan met img_lan_id gelijk aan $_POST["img_lan_id"]
    // zoja is de image voor het bepaalde land reeds gepost en willen we update
    // anders heeft het betreffende land nog geen image gepost en willen we inserten

    //$data = getData("select * from images where img_lan_id = ".$_POST["img_lan_id"]);
    //$statement = $data ? "update" : "insert";
    //$sql = $statement == "insert" ? "insert into $table set " : "update $table set ";

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
