<?php
    $public_access = true;
    require_once "./lib/autoload.php";

    $css = array('stad_form.css');
    $headers = $dbm->getHeaders("user");
    $content = createForm("register.html", $headers, $old_post);
    $content = mergeContent("main.html", $content);
    $content = mergeErrorInfoPlaceholder($content, $headers, $errors, $info);
    $content = removeEmptyPlaceholder($content);

    echo PrintHead($title="register", $css);
    echo PrintJumbo($titel="Registratie");
    echo $content;
