<?php

include_once 'Controller.php';
$c = new Controller();

if(isset($_GET['i']))  $c->setPointerFileByIndex($_GET['i']);

echo $c->printFiles();

?>
