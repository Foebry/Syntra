<?php
$public_access = false;
require_once "./lib/autoload.php";

$css = array('steden.css', 'navbar.css');
echo PrintHead($title="Mijn eerste webpagina", $css);
echo PrintJumbo("Logfile");
echo PrintNavBar("navbar.html");

?>
<div class="container">
    <p><?php echo $logger->showLog() ?></p>
</div>
