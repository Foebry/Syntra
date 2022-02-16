<?php
    require_once "../lib/autoload.php";
    require_once "../models/ShoppingList.php";

    echo PrintHead("Shopping List");
    echo PrintJumbo("We gaan shoppen!", "");
 ?>

 <div class="container">
     <div class="row">
         <?php

            # $sl is een object variabele, ook wel een instance van de class ShoppingList genoemd
            $sl = new ShoppingList("Carrefour");
            #$vandaag = new DateTime();

            #$sl->setShop("Zeeman");
            #$sl->setDate();
            #$sl->items = ["sokken", "onderbroeken", "muts"];

            var_dump($sl->getShop());
            echo "<br>";
            var_dump($sl);
            echo "<br>";
            #var_dump($vandaag);
            ?>
