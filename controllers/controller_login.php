<?php
include ("../models/model_login.php");
session_start();

unset($_SESSION["errors"]);

$_SESSION["errors"] = checkLoginCorrectData($_POST["email"], $_POST["password"]);

if (!empty($_SESSION["errors"])){
	header('Location: http://'.$_SERVER['HTTP_HOST']."/blocks/form_login.php");
}

else {
	if (checkVerified($_POST["email"]) == 1){
		$_SESSION["username"] = getLoginByEmail($_POST["email"]);
		header('Location: http://'.$_SERVER['HTTP_HOST']."/index.php");
	}
	else{
		header('Location: http://'.$_SERVER['HTTP_HOST']."/blocks/form_please_check.php");
	}
}