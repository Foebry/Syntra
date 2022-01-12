<?php
if (!isset($_SESSION)) session_start();

function GenerateCSRF( string $formname = "noformname" ): string {
    /**
    * functie die een csrf-token zal aanmaken.
    * @param $formname: salt voor encryptie
    * @type $formname: string
    * @default $formname: "noformname"
    *
    * @return: string
    */

    # genereer csrf token
    $csrf_key = bin2hex( random_bytes(32) );
    $csrf = hash_hmac( 'sha256', 'PHP1CURSUS SECRET KEY ' . $formname, $csrf_key );

    # bewaar CSRF token in SESSION onder "latest_csrf" key
    $_SESSION['latest_csrf'] = $csrf;

    return $csrf;
}

 ?>
