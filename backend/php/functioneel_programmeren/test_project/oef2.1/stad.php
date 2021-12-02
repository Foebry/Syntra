<?php
require_once "../src/database.php";
require_once "../src/elements.php";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Stad</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="../css/stad.css">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  </head>
  <body>
    <div class="jumbotron text-center">
      <h1>Detail stad</h1>
    </div>
        <?php
            # aanmaken sql connector
            $conn = connectDb();
            #aanmaken query
            $sql = "select * from images where img_id = ".$_GET['img_id'];
            # specifieke data inladen uit db
            $data = GetData($conn, $sql);

            echo "<div class='container'>";
            foreach ($data as $row){
                echo injectTitle(2, $row['img_title']);
                echo "<p>filename: ".$row['img_filename'].'</p>';
                echo "<p>".$row['img_width']." x ".$row['img_height'];
                echo injectImgHolder('../images/'.$row['img_filename']);
                echo injectLink("steden2.php", "terug naar overzicht");
                echo "</div>";
            }
         ?>

  </body>
</html>
