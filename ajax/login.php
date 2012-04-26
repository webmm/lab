<?php 

$nosession = true;
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';

if (isset($_POST['email'])&&isset($_POST['pass'])) {
	$resultat = Usuari::login($_POST['email'],$_POST['pass'],$_POST['recordar']);
	
	echo $resultat;
}

 ?>