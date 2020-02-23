<?php
include ("model_connectDB.php");

function checkEmailAndSendForRecovery($email){
	$pdo = connectDB();
	$query = $pdo->prepare("SELECT * FROM `users` WHERE `email`=:email");
	$query->execute(array(':email' => $email));
	$row = $query->fetch((PDO::FETCH_ASSOC));
	closeConnectDB($pdo);
	if ($row != null) {
		$link = "http://".$_SERVER['HTTP_HOST']."/controllers/controller_new_password.php?token=".$row["token"]."&login=".$row["login"];
    	$subject = "Confirm Camagru";
    	$content = "<html>
    	              <head>
    	                <title> Camagru </title>
    	                </head>
    	                <body>
    	                	<p>Hello " .$row["login"]. "! If you fargot you password on Camagru project, click on this link to change password.</p>
    	                	<a href='".$link."'>Confirm ! </a>
    	                </body>";
    	$headers  = 'MIME-Version: 1.0' . "\r\n";
    	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: camagru2020@yandex.ru>' . "\r\n";
		mail($email, $subject, $content, $headers);
	}
}