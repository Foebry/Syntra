<?php
    $public_access = true;
    $root = $_SERVER["DOCUMENT_ROOT"];
    require_once "$root/lib/autoload.php";

    $css = array("style.css");
    $login = '<a href="./login.php">in te loggen</a>';

    echo PrintHead($title="webpage", $css);
    echo PrintJumbo($titel="geen toegang", $subtitel="");
    echo "<div class='container'>";
    echo "<p class='msg--info'>U hebt helaas geen toegang! Probeer eventueel $login</p>";
