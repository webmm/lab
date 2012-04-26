<?php 

@session_start();

//error_reporting(E_PARSE);
error_reporting(E_ALL);
ini_set('display_errors', '1');

$root = $_SERVER["DOCUMENT_ROOT"]; 
function __autoload($class_name) {
	$class_name = strtolower($class_name);
    include $_SERVER['DOCUMENT_ROOT'] . '/classes/class.' . $class_name . '.php';
}

// Connectem a la base de dades

$mysql = new MySQL();
MySQL::connectar($mysql->dbhost,$mysql->dbuser,$mysql->dbpass);
MySQL::seleccionar($mysql->dbbname);    

$pagina_actual = basename($_SERVER['REQUEST_URI'], ".php");

if(!isset($nosession)||!$nosession) include 'session.php';

 ?>