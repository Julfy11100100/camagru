<?php
session_start();
include ("../models/model_new_account.php");

unset($_SESSION["errors"]);

//Проверка корректности данных и уникальность в бд
$_SESSION["errors"]= checkCreateAccountCorrectData($_POST["login"], $_POST["password"], $_POST["rep_password"],
$_POST['email']);

//Если есть ошибки перенаправляем опять на форму регистрации 
if (!empty($_SESSION["errors"])) {
	header('Location: http://'.$_SERVER['HTTP_HOST']."/blocks/form_new_account.php");
}
// иначе добавляем в бд и перенаправляем на страницу с просьбой верификации 
else {
	addNewAccount($_POST["login"], $_POST["password"], $_POST["email"]);
	header('Location: http://'.$_SERVER['HTTP_HOST']."/blocks/form_please_check.php");
}

