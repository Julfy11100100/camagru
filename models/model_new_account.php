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

function addNewAccount($login, $password, $email, $token) {
	$pdo = connectDB();

	try {
		$add = $pdo->prepare("INSERT INTO users (`login`,`password`,`email`,`token`) VALUES (?,?,?,?)");
		$add->execute([$login,hash("sha256",$password),$email,$token]);
		closeConnectDB($pdo);
		return true;
	}
	catch(PDOException $e) {"CAN`T ADD NEW ACC:".$e->getMessage()." Aborting process<br>"; closeConnectDB($pdo);} 
}

function confirmationMail($login, $email, $token){
	$link = "http://".$_SERVER['HTTP_HOST']."/controllers/controller_verify_account.php?token=".$token."&login=".$login;
    $subject = "Confirm Camagru";
    $content = "<html>
                  <head>
                    <title> Camagru </title>
                    </head>
                    <body>
                    	<p>Hello " .$login. "! If you registered on the Camagru project, click on this link to confirm the registration.</p>
                    	<a href='".$link."'>Confirm ! </a>
                    </body>";
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: camagru2020@yandex.ru' . "\r\n";
    if (mail($email, $subject, $content, $headers)) {
		return (1);
	}
	else {
		return (0);
	}
}