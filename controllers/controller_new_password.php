<?php
session_start();
include("../models/model_new_password.php");

unset($_SESSION["errors"]);

if (checkForNewPassword($_GET["token"], $_GET["login"])) {
	if (!isset($_POST["new_password"]) && !isset($_POST["rep_password"])){
		header('Location: http://'.$_SERVER['HTTP_HOST']."/blocks/form_new_password.php");
	}
	else {
		$_SESSION["errors"] = checkCorrectNewPassword($_POST["new_password"], $_POST["rep_password"]);
		if (!empty($_SESSION["errors"])) {
			header('Location: http://'.$_SERVER['HTTP_HOST']."/blocks/form_new_password.php");
		}
		else {
			addNewPassword($_POST["new_password"], $_GET["login"]);
			header('Location: http://'.$_SERVER['HTTP_HOST']."/blocks/form_login.php");
		}
	}
}
