<?php 

$nosession = true;
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';

$resultat = Tasca::nova($_POST['projecte'],$_POST['nom'],$_POST['deadline']);
echo $resultat;

 ?>