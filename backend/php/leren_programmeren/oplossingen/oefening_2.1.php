<?php

    function taartInStukkenUitbreiding($taarten, $deelnemers): string{

        /*
         * aantal deelnemers: 1283
         * aantal taarten: 150
         * deling: 8.5533..
         *
         * 44.66..% van de taarten moeten in 8 stukken verdeeld worden
         * 55.33% van de taarten moeten in verdeeld worden onder de resterende deelnemers
         */

        $aantal_stukken_groot = intdiv($deelnemers, $taarten);
        $p_taarten_groot = 1 - ($deelnemers/$taarten - $aantal_stukken_groot);

        $aantal_taarten_groot = $p_taarten_groot * $taarten;
        $aantal_taarten_klein = $taarten - $aantal_taarten_groot;
        $aantal_stukken_klein = ($deelnemers - ($aantal_taarten_groot * $aantal_stukken_groot)) / $aantal_taarten_klein;

        $solution = "Je hebt %d taarten voor %d deelnemers.\n"."Je moet %d taarten in %d stukken snijden.\n"."En %d taarten in %d stukken";

        return printf($solution, $taarten, $deelnemers, round($aantal_taarten_groot), $aantal_stukken_groot, round($aantal_taarten_klein), round($aantal_stukken_klein));
    }


    function taartInStukken($taarten, $deelnemers): string {
        if ($deelnemers % $taarten === 0) {
            return printf ("Je moet de taarten in %d stukken snijden", $deelnemers/$taarten);
        }
        return taartInStukkenUitbreiding($taarten, $deelnemers);
    }



    $taarten = readline("Hoeveel taarten zijn er beschikbaar? ");
    $deelnemers = readline("Hoeveel deelnemers zijn er aanwezig? ");

    taartInStukken($taarten, $deelnemers);

