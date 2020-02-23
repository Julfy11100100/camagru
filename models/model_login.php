<?php
include ("model_connectDB.php");

function checkEmailDBForLogin($email){
	$pdo = connectDB();
	$query = $pdo->prepare("SELECT `id` FROM users WHERE `email`=:email");
	$query->execute(array(':email' => $email));
	$res = $query->fetch();
	closeConnectDB($pdo);
	if ($res != null)
		return false;
	else
		return true;
}

function checkPasswordDBForLogin($email, $password) {
	$pdo = connectDB();
	$query = $pdo->prepare("SELECT `password` FROM users WHERE `email`=:email");
	$query->execute(array(':email' => $email));
	$res = $query->fetch();
	closeConnectDB($pdo);
	if (hash("sha256",$password) == $res["password"])
		return true;
	else
		return false;
}

function checkLoginCorrectData($login, $password){
	$errormassiv = Array();

	if (!checkEmailDBForLogin($login)){
		if (!checkPasswordDBForLogin($login,$password)){
			$errormassiv[] = "Wrong password";
		}
	}
	else {
		$errormassiv[] = "Email not found";
	}
	return ($errormassiv); 
}

function checkVerified($email) {
	$pdo = connectDB();
	$query = $pdo->prepare("SELECT `verified` FROM `users` WHERE `email`=:email");
	$query->execute(array(':email' => $email));
	$res = $query->fetch();
	return($res["verified"]);
}

function getLoginByEmail($email){
	$pdo = connectDB();
	$query = $pdo->prepare("SELECT `login` FROM users WHERE `email`=:email");
	$query->execute(array(':email' => $email));
	$res = $query->fetch();
	closeConnectDB($pdo);
	return($res["login"]);
}