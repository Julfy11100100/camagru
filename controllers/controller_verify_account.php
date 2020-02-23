<?php
include ("../models/model_verify_account.php");

if ($_GET["token"] && $_GET["login"]){
	if (checkAndVerificationAccount($_GET["token"], $_GET["login"])){
		header('Location: http://'.$_SERVER['HTTP_HOST']."/blocks/form_verify_acc.php");
	}
}