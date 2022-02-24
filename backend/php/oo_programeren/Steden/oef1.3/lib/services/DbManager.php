<?php

    class DbManager{
        private $conn;

        function __construct($config){
            $this->conn = $this->connectDb($config);
        }

        function connectDb($config){
            if (!$this->conn){
                /**
                * functie die een connectie zal creëren met de db van het project.
                */
                $root = $_SERVER["DOCUMENT_ROOT"];
                // laad content config.json in
                $file = file_get_contents("$root/config.json");
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
            return $this->conn;

        }

        function GetData($query){
            /**
            * functie die de opgevragen data adhv de megeleverde querry uit de databank zal inladen.
            */

            $data = [];

            // query uitvoeren
            $result = $this->conn->query($query);

            // alle rijen opvragen en teruggeven
            return $result->fetchall(PDO::FETCH_ASSOC);

        }

        function getUserByEmail(string $email) :User{
            $data = $this->GetData("select * from user where usr_email = '$email'");
            return new User($data[0]);
        }

        function execute($query){
            /**
            * functie die queries uitvoert.
            * bv. UPDATE - INSERT - DELETE - CREATE - DROP
            */

            return $this->conn->query($query);
        }

        function getHeaders($table){
            /**
            * functie die de tabelhoofdingen van de tabel opvraagt en teruggeeft.
            * @param $table: tabel waarvoor de hoofdingen gevraagd wordt.
            * @type $table: string
            *
            * @return: array(string => array(string => string|int))
            */

            $headers = [];

            $query = "select * from information_schema.columns where table_name = '$table' and table_schema = 'steden'";

            // opvragen data ahv bovenstaande query
            $data = $this->GetData($query);

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

        function buildStatement($statement){
            /**
            * functie die de sql statment zal genereren.
            * @param $statement: type van statement ("insert", "update", ...)
            * @type $statement: string
            *
            * @return: string
            */

            $table = $_POST["table"];
            $headers = $_POST["DB_HEADERS"];
            $values = [];

            $statement = $statement == "insert" ? "insert into $table set " : "update $table set ";

            # overloop alle velden uit de db tabel, en valideer de overeenkomende gegevens uit $_POST
            foreach($headers as $key => $properties){
                if ($key == $_POST["pkey"]) continue;
                $value = $_POST[$key];

                # vul $values aan met veld en waarde
                $values[] = "$key = '$value'";
            }
            $values = implode(", ", $values);
            return $statement . $values;
        }
    }

?>
