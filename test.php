<?php 
$nosession = true;
include 'includes/init.php';

$tasques = Tasca::getListMes(4);

//print_r($tasques);

echo Calendari::pintar(5,2012);

 ?>
