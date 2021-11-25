<?php


function rechtsUitlijnen($tekst, $breedte): string{
    $aantal_spacies = $breedte - strlen($tekst);
    $spacies = str_repeat(" ", $aantal_spacies);

    return $spacies."$tekst\n";
}



print rechtsUitlijnen("banaan",70);
print rechtsUitlijnen("nog een banaan",70);
print rechtsUitlijnen("2.30 euro",70);
print rechtsUitlijnen("dit is een hele lange zin",70);
print rechtsUitlijnen("14.10 euro",70);

