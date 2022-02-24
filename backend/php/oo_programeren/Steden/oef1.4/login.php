<?php
    if (!isset($_SESSION)) session_start();
    $public_access = true;
    $_SESSION["user"] = [];
    require_once "lib/autoload.php";

    //var_dump($errors);
    $data = [0 => ["usr_email" => "", "usr_password" => ""]];

    $headers = $dbm->getHeaders("user");

    $css = array('stad_form.css');
    $content = createForm("login.html", $data, $old_post);
    $content = mergeContent("main.html", $content);
    $content = mergeErrors($content, $headers, $errors);
    $content = removeEmptyPlaceholder($content);

    echo PrintHead($title="login", $css);
    echo PrintJumbo($titel="Login");
    echo $content;
