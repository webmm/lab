<?php 

$nosession = true;
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';

$resultat = Projecte::nou($_POST['nom'],$_POST['descripcio']);
echo $resultat;

 ?>