<?php
    if (!isset($_SESSION)) session_start();

    $public_access = true;
    $_SESSION["user"] = [];
    require_once "lib/autoload.php";

    $headers = $dbm->getHeaders("user");

    $css = array('stad_form.css', 'steden.css', 'navbar.css');
    $content = createForm("login.html", $headers, $old_post);
    $content = mergeContent("main.html", $content);
    $content = $ms->ShowErrors($content);
    $content = removeEmptyPlaceholder($content);

    echo PrintHead($title="login", $css);
    echo PrintJumbo($titel="Login");
    echo PrintNavBar("navbar.html");
    echo $content;
