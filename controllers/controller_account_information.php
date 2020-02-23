<?php
session_start();
include ("../models/model_account_information.php");

unset($_SESSION["errors"]);

if (isset($_POST["check_status"]) && $_POST["check_status"] == 1){
	$status = Array("status" => checkCommentStatus($_SESSION["username"]));
	echo json_encode(
		$status
	);
	unset($_POST["check_status"]);
}
else if (isset($_POST["change_status"]) && $_POST["change_status"] == 1){
	changeCommentStatus($_SESSION["username"]);
	unset($_POST["check_status"]);
}
else {
	$_SESSION["errors"] = checkChangeAccountCorrectData($_SESSION["username"], $_POST["new_login"], $_POST["password"],
	$_POST["new_password"], $_POST["new_email"]);

	if (!empty($_SESSION["errors"])) {
		header('Location: http://'.$_SERVER['HTTP_HOST']."/blocks/form_account_information.php");
	}
	else {
		addChangesAccount($_SESSION["username"], $_POST["new_login"],
		$_POST["new_password"], $_POST["new_email"]);
		header('Location: http://'.$_SERVER['HTTP_HOST']."/controllers/controller_logout.php");
	}
}
