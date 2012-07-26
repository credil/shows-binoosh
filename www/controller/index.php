<?php

include_once 'Controller.php';
$c = new Controller();

if(isset($_GET['i']))  $c->setPointerFileByIndex($_GET['i']);

echo '<table cellpadding="5"><tr valign="top">'. "\n\n";


echo "<td>\n" ;

echo $c->printFowardBackwardControls();

echo "<p>";

echo $c->printFiles();

echo "</p>";

echo "</td>\n\n\n";

echo "<td><img src=\"" . $c->getPointerFile() . "\"></td>";

echo "</tr></table>";




?>
