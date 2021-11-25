<?php

// define connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "covid19";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
  die("Connection failed: ".$conn->connect_error);
}


//define and execute query
$sql = "select * from gemeente limit 10";
$result = $conn->query($sql);

print "<table>";

//show result (if there is any)
if ( $result->num_rows > 0 ){
  // output data of each row
  while( $row = $result->fetch_assoc() ){
  //var_dump($row); print "<br>";
    echo "<tr>";
    print "<td>" . $row["det_id"] . "</td>";
    print "<td>" . $row["det_niscode"] . "</td>";
    print "<td>" . $row["det_prv_id"] . "</td>";
    print "<td>" . $row["det_txt_nl"] . "</td>";
    print "<td>" . $row["det_txt_fr"] . "</td>";
    print "<td>" . $row["det_cases"] . "</td>";
    print "</tr>";
  }
} else{
  echo "No records found";
  }

  print "</table>";

  $conn->close();
?>
