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

function checkPasswordDB($login, $password){
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

function checkChangeAccountCorrectData($login, $new_login, $password, $new_password, $new_email){

	$errormassiv = Array();

	if (($new_login == "") && ($password == "") && ($new_password == "") && ($new_email == "")){
		$errormassiv[] = "Empty fields";
	}

	if (isset($new_login) && $new_login != "") {
		if (!checkLoginCorrect($new_login)) {
			$errormassiv[] = "Incorrect login. 8 - 20 a-z 0-9 _-";
		}
		if (!checkLoginDBForCreate($new_login)) {
			$errormassiv[] = "This login already exists";
		}
		if (!checkPasswordDB($login,$password)){
			$errormassiv[] = "Wrong password";
		}
	}
	else if (isset($new_password) && $new_password != ""){
		if (!checkPasswordCorrect($password)){
			$errormassiv[] = "Incorrect password. 8 - 20 a-z 0-9 _-";
		}
		if (!checkPasswordDB($login,$password)){
			$errormassiv[] = "Wrong password";
		}
	}
	else if (isset($new_email) && $new_email != ""){
		if (!checkEmailCorrect($new_email)) {
			$errormassiv[] = "Incorrect email";
		}
		if (!checkEmailDBForCreate($new_email)) {
			$errormassiv[] = "This email already exists";
		}
		if (!checkPasswordDB($login,$password)){
			$errormassiv[] = "Wrong password";
		}
	}
	return ($errormassiv);
}

function addChangesAccount($login, $new_login, $new_password, $new_email) {

	$pdo = connectDB();

	if (isset($new_login) && $new_login != "") {
		try {
			$update = $pdo->prepare("UPDATE users SET `login`=:nlogin WHERE `login`=:oldlogin");
			$update->execute([':nlogin' => $new_login, ':oldlogin' => $login]);
			$update = $pdo->prepare("UPDATE images SET `login`=:nlogin WHERE `login`=:oldlogin");
			$update->execute([':nlogin' => $new_login, ':oldlogin' => $login]);
			$update = $pdo->prepare("UPDATE comments SET `login`=:nlogin WHERE `login`=:oldlogin");
			$update->execute([':nlogin' => $new_login, ':oldlogin' => $login]);
			$update = $pdo->prepare("UPDATE likes SET `login`=:nlogin WHERE `login`=:oldlogin");
			$update->execute([':nlogin' => $new_login, ':oldlogin' => $login]);
		}
		catch(PDOException $e) {"CAN`T CHANGE INFORMATION ABOUT LOGIN:".$e->getMessage()." Aborting process<br>"; closeConnectDB($pdo);} 
		rename("../img/user_img/".$login, "../img/user_img/".$new_login);
	}
	else if (isset($new_password) && $new_password != ""){
		try {
			$update = $pdo->prepare("UPDATE users SET `password`=:npassword WHERE `login`=:oldlogin");
			$update->execute([':npassword' => hash("sha256",$new_password), ':oldlogin' => $login]);
		}
		catch(PDOException $e) {"CAN`T CHANGE INFORMATION ABOUT PASSWORD:".$e->getMessage()." Aborting process<br>"; closeConnectDB($pdo);} 
	}
	else if (isset($new_email) && $new_email != ""){
		try {
			$update = $pdo->prepare("UPDATE users SET `email`=:nemail WHERE `login`=:oldlogin");
			$update->execute([':nemail' => $new_email, ':oldlogin' => $login]);	
		}
		catch(PDOException $e) {"CAN`T CHANGE INFORMATION ABOUT EMAIL:".$e->getMessage()." Aborting process<br>"; closeConnectDB($pdo);} 
	}

	closeConnectDB($pdo);
}

function checkCommentStatus($login) {
	$pdo = connectDB();

	$query = $pdo->prepare("SELECT `comment_to_email` FROM users WHERE `login`=:logi");
	$query->execute(array(':logi' => $login));
	$row = $query->fetch(PDO::FETCH_ASSOC);
	closeConnectDB($pdo);
	return($row["comment_to_email"]);
}

function changeCommentStatus($login) {
	$status = 1;
	if (checkCommentStatus($login)) {
		$status = 0;
	}
	$pdo = connectDB();

	try {
		$update = $pdo->prepare("UPDATE users SET `comment_to_email`=:stat WHERE `login`=:logi");
		$update->execute([':stat' => $status, ':logi' => $login]);
		closeConnectDB($pdo);
	}
	catch(PDOException $e) {"CAN`T CHANGE COMMENT STATUS:".$e->getMessage()." Aborting process<br>"; closeConnectDB($pdo);} 
}