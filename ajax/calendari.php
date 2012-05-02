<?php 
$nosession = true;
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';

$mes = $_POST['mes'];
$any = $_POST['any'];
echo Calendari::pintar($mes,$any); ?>