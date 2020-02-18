<?php
include ("model_connectDB.php");

function checkLoginDBForLogin($login){
	$pdo = connectDB();
	$query = $pdo->prepare("SELECT `id` FROM users WHERE `login`=:logi");
	$query->execute(array(':logi' => $login));
	$res = $query->fetch();
	closeConnectDB($pdo);
	if ($res != null)
		return false;
	else
		return true;
}

function checkPasswordDBForLogin($login, $password) {
	$pdo = connectDB();
	$query = $pdo->prepare("SELECT `password` FROM users WHERE `login`=:logi");
	$query->execute(array(':logi' => $login));
	$res = $query->fetch();
	closeConnectDB($pdo);
	if (hash("sha256",$password) == $res["password"])
		return true;
	else
		return false;
}

function checkLoginCorrectData($login, $password){
	$errormassiv = Array();

	if (!checkLoginDBForLogin($login)){
		if (!checkPasswordDBForLogin($login,$password)){
			$errormassiv[] = "Wrong password";
		}
	}
	else {
		$errormassiv[] = "Login not found";
	}
	return ($errormassiv); 
}