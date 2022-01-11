<?php
    require_once "../lib/html_components.php";
    require_once "../lib/database.php";
    require_once "../lib/autoload.php";

    $css = array('stad_form.css');
    $headers = getHeaders("user");
    $form = printGenericForm("register.html", $headers, $old_post);

    echo PrintHead($title="register", $css);
    echo PrintJumbo($titel="Registratie");
    echo mergeErrors($form, $headers, $errors);
