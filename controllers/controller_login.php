<?php
include ("../models/model_login.php");
session_start();

unset($_SESSION["errors"]);

$_SESSION["errors"] = checkLoginCorrectData($_POST["login"], $_POST["password"]);

if (!empty($_SESSION["errors"])){
	header('Location: http://'.$_SERVER['HTTP_HOST']."/blocks/form_login.php");
}

else {
	$_SESSION["username"] = $_POST["login"];
	header('Location: http://'.$_SERVER['HTTP_HOST']."/index.php");
}