<?php

$nosession = true;
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';

Tasca::assignarProjecte($_POST['pid_tasca'],$_POST['pid_projecte']);


?>