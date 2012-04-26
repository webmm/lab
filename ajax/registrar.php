<?php 

$nosession = true;
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';

$resultat = Usuari::nouUsuari($_POST['email'],$_POST['pass'],$_POST['nom'],$_POST['cognoms']);
echo $resultat;

 ?>