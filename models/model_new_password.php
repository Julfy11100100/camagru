<?php
include ("model_connectDB.php");

function checkForNewPassword($token, $login){
	$pdo = connectDB();
	$query = $pdo->prepare("SELECT `token` FROM `users` WHERE `login`=:logi");
	$query->execute(array(':logi' => $login));
	$row = $query->fetch((PDO::FETCH_ASSOC));
	closeConnectDB($pdo);
	if ($row["token"] == $token) {
		return (1);
	}
	else {
		return (0);
	}
}

function checkPasswordCorrect($password){
	if (preg_match("/^[a-z0-9_-]{8,20}$/i", htmlspecialchars($password)))
		return true;
	else
		return false;
}

function checkCorrectNewPassword($password, $rep_password){
	$errormassiv = Array();
	if ($password == $rep_password) {
		if (!checkPasswordCorrect($password)){
			$errormassiv[] = "Wrong password";
		}
	}
	else{
		$errormassiv[] = "Passwords do not match";
	}
	return ($errormassiv);
}

function addNewPassword($password, $login) {
	$pdo = connectDB();

	try {
		$update = $pdo->prepare("UPDATE users SET `password`=:npassword WHERE `login`=:oldlogin");
		$update->execute([':npassword' => hash("sha256",$password), ':oldlogin' => $login]);
		closeConnectDB($pdo);
	}
	catch(PDOException $e) {"CAN`T CHANGE INFORMATION ABOUT PASSWORD:".$e->getMessage()." Aborting process<br>"; closeConnectDB($pdo);} 
}