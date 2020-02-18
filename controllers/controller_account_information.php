<?php
session_start();
include ("../models/model_account_information.php");

unset($_SESSION["errors"]);

$_SESSION["errors"] = checkChangeAccountCorrectData($_SESSION["username"], $_POST["new_login"], $_POST["password"],
$_POST["new_password"], $_POST["new_email"]);

if (!empty($_SESSION["errors"])) {
	header('Location: http://'.$_SERVER['HTTP_HOST']."/blocks/form_account_information.php");
}
else {
	addChangesAccount($_SESSION["username"], $_POST["new_login"], $_POST["password"],
	$_POST["new_password"], $_POST["new_email"]);
	header('Location: http://'.$_SERVER['HTTP_HOST']."/controllers/controller_logout.php");
}
