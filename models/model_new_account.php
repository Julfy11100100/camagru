<?php
include ("model_connectDB.php");

function checkLoginCorrect($login){
	if (preg_match("/^[a-z0-9_-]{8,20}$/i", htmlspecialchars($login)))
        return true;
    else
        return false;
}

function checkPasswordCorrect($password){
	if (preg_match("/^[a-z0-9_-]{8,20}$/i", htmlspecialchars($password)))
		return true;
	else
		return false;
}

function checkEmailCorrect($email){
	if (filter_var(htmlspecialchars($email), FILTER_VALIDATE_EMAIL))
		return true;
	else
		return false;
}

function checkEmailDBForCreate($email){
	$pdo = connectDB();
	$query = $pdo->prepare("SELECT id FROM users WHERE `email`=:em");
	$query->execute(array(':em' => $email));
	$res = $query->fetch();
	closeConnectDB($pdo);
	if ($res != null)
		return false;
	else
		return true;
}

function checkLoginDBForCreate($login){
	$pdo = connectDB();
	$query = $pdo->prepare("SELECT id FROM users WHERE `login`=:logi");
	$query->execute(array(':logi' => $login));
	$res = $query->fetch();
	closeConnectDB($pdo);
	if ($res != null)
		return false;
	else
		return true;
}

function checkCreateAccountCorrectData($login, $password, $rep_password, $email) {

	$errormassiv = Array();

	if (!checkLoginCorrect($login)) {
		$errormassiv[] = "Incorrect login. 8 - 20 a-z 0-9 _-";
	}
	if (!checkPasswordCorrect($password)){
		$errormassiv[] = "Incorrect password. 8 - 20 a-z 0-9 _-";
	}
	if (!checkEmailCorrect($email)) {
		$errormassiv[] = "Incorrect email";
	}
	if ($password != $rep_password){
		$errormassiv[] = "Passwords do not match";
	}
	if (!checkEmailDBForCreate($email)) {
		$errormassiv[] = "this email already exists";
	}
	if (!checkLoginDBForCreate($login)) {
		$errormassiv[] = "this login already exists";
	}
	
	return ($errormassiv);

}

function addNewAccount($login, $password, $email) {
	$pdo = connectDB();

	try {
		$add = $pdo->prepare("INSERT INTO users (`login`,`password`,`email`) VALUES (?,?,?)");
		$add->execute([$login,hash("sha256",$password),$email]);
		closeConnectDB($pdo);
		return true;
	}
	catch(PDOException $e) {"CAN`T ADD NEW ACC:".$e->getMessage()." Aborting process<br>"; closeConnectDB($pdo);} 
}