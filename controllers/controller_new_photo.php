<?php
session_start();
include ("../models/model_new_photo.php");

if (isset($_POST["main_img"]) && isset($_POST["overlay"]) && isset($_SESSION["username"])) {
	$result = createImage($_POST["main_img"], $_POST["overlay"], $_SESSION["username"]);
	echo json_encode(
		$result
	);
}
