<?php
    require_once "../lib/autoload.php";
    var_dump($errors);
    $data = [0 => ["usr_email" => "", "usr_password" => ""]];

    $css = array('stad_form.css');
    $content = createForm("login.html", $data, $old_post);
    $content = mergeContent("main.html", $content);
    $content = removeEmptyPlaceholder($content);

    echo PrintHead($title="login", $css);
    echo PrintJumbo($titel="Login");
    echo $content;
