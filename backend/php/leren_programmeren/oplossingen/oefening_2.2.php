<?php

    function kamerBetegelen($lengte, $breedte, $lengte_tegel, $breedte_tegel): string{
        $tegels_lengte = ceil($lengte/$lengte_tegel);
        $tegels_breedte = ceil($breedte/$breedte_tegel);
        $aantal_tegels = $tegels_lengte * $tegels_breedte;

        $oplossing = "Je moet %d tegels kopen van %f x %f meter om een kamer van %d x %d meter te betegelen";

        return printf($oplossing, $aantal_tegels, $lengte_tegel, $breedte_tegel, $lengte, $breedte);
    }


    $l = readline("Wat is de lengte (m) van de kamer? ");
    $b = readline("Wat is de breedte (m) van de kamer? ");
    $l_tegel = readline("Wat is de lengte (m) van de tegel? ");
    $b_tegel = readline("Wat is de breedte (m) van de tegel? ");

    kamerBetegelen($l, $b, $l_tegel, $b_tegel);