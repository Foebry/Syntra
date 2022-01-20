<!DOCTYPE html>
<html lang="en">
<head>
    <title>Weekoverzicht</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<main>
    <div class="jumbotron text-center">
        <h1>Weekoverzicht</h1>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="../oef4.2/steden.php">home</a>
                        <a class="dropdown-item" href="../oef4.2/register.php">register</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../oef4.2/login.php">login</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <table class="table table-bordered col-sm-10">
            <?php
                // dbconnectie aanmaken
                $db = new PDO(
                                "mysql:dbname=steden;host=localhost",
                                $user = "root",
                                $password = ""
                            );
                // indien datum meegegeven in de navigatiebalk, zet datestr gelijk aan deze datum anders gelijk aan "now"
                $datestr = $_GET ? str_replace("/", "-", array_keys($_GET)[0]) : "now";

                // wday van datestr - 1.
                // indien datestr een maandag is (wday maandag = 1) willen we 0 dagen terug gaan
                $wday = getdate(strtotime($datestr))["wday"] - 1;
                //creëer de datum voor de maandag van de week van datestr
                $start_date = date("d-m-Y", strtotime("$datestr - $wday day"));

                for ($i=0; $i<7; $i++){
                    // bereken de timestamp van iedere dag
                    $timestamp = strtotime("$start_date + $i day");
                    // dag, datum van deze dag
                    $dag = getdate($timestamp)["weekday"];
                    $datum = date("d-m-Y", $timestamp);
                    // date in Y-m-d notatie om in db te zoeken
                    $date = date("Y-m-d", $timestamp);

                    $sql = "select taa_start, taa_end, taa_omschr from taak where taa_datum = '".$date."'";
                    $result = $db->query($sql);
                    $data = $result->fetchall(PDO::FETCH_ASSOC);

                    $activiteiten = [];
                    if (count($data) > 0){
                        foreach($data as $row){
                            $start = substr($row["taa_start"], 0, 5);
                            $end = substr($row["taa_end"], 0, 5);
                            $omschr = $row["taa_omschr"];
                            $activiteiten[] = "$start-$end &nbsp;&nbsp; $omschr";
                        }
                    }
                    echo "<tr><td>".$dag."</td><td>$datum</td><td>".implode("<br>",$activiteiten)."</td>";
                }
                $volgende_week = date("Y-m-d", strtotime("$start_date + 1 week"));
                $vorige_week = date("Y-m-d", strtotime("$start_date - 1 week"));

        echo "</table>
        <div class='navigate'>
            <button>
                <a href='./oef7.1.php?".$vorige_week."'>Vorige Week</a>
            </button>
            <button>
                <a href='./oef7.1.php?".$volgende_week."'>Volgende
            </button>
        </div>";
