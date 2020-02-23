<?php
include ("model_connectDB.php");

function checkAndVerificationAccount($token, $login){
	$pdo = connectDB();
	$status = 1;
	$query = $pdo->prepare("SELECT `token` FROM `users` WHERE `login`=:logi");
	$query->execute(array(':logi' => $login));
	$row = $query->fetch(PDO::FETCH_ASSOC);
	if ($row["token"] != $token){
		return(0);
	}
	else {
		try {
			$update = $pdo->prepare("UPDATE users SET `verified`=1 WHERE `login`=:logi");
			$update->execute([':logi' => $login]);
			closeConnectDB($pdo);
		}
		catch(PDOException $e){
			echo "ERROR CAN`T CHANGE `verified` ".$e->getMessage()." Aborting process<br>";$status = 0;closeConnectDB($pdo);}
	}
	return ($status);
}