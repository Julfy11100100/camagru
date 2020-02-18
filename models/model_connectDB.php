<?php
include ("../config/setup.php");
include ("../config/database.php");

$DSN = $DB_DSN;
$USER = $DB_USER;
$PASSWORD = $DB_PASSWORD;
$NAME = $DB_NAME;

function connectDB() {

	global $DSN, $USER, $PASSWORD, $NAME;

	$pdo = new PDO($DSN, $USER, $PASSWORD); 
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->exec("USE ".$NAME."");
	return ($pdo);
}

function closeConnectDB($pdo) {
	unset($pdo);
}

?>