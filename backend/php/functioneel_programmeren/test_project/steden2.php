<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Mijn eerste webpagina</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="css/steden.css">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  </head>
  <body>
    <div class="jumbotron text-center">
      <h1>Leuke plekken in Europa</h1>
      <p>Tips voor citytrips voor vrolijke vakantiegangers!</p>
    </div>
    <div class="container">
        <?php
            # inladen elements module + mysql connector
            require_once "src/elements.php";
            require_once "src/database.php";
            # aanmaken sql connector
            $conn = new mysqli("localhost", "root", "", "steden");
            # aanmaken query
            $sql = "select * from images";
            #opvragen data uit db
            $images = GetData($conn, $sql);

            # data uitprinten in de pagina
            foreach($images as $row){
                echo "<article>";
                echo injectTitle(1, $row["img_title"]);
                echo "<p>".$row['img_width']." x ".$row['img_height'];
                echo injectParagraphLorem(15);
                echo injectImgHolder('images/'.$row['img_filename']);
                echo injectLink("stad.php?img_id=".$row['img_id'], 'Meer info');
                echo "</article>";
            }
         ?>
    </div>

  </body>
</html>
