<?php
session_start();
include ("../models/model_main_gallery.php");

if (isset($_POST["authorization"])) {
	$array_authorization = Array("authorization" => 0, "max_page" => getMaxPage());
	if (isset($_SESSION["username"]) && $_SESSION["username"] != "") {
		$array_authorization["authorization"] = 1;
	}
	echo json_encode(
		$array_authorization
	);
}

if (isset($_POST["number_of_page"])){
	$massiv = getLast5Images($_POST["number_of_page"], $_SESSION["username"]);
	unset($_POST["number_of_page"]);
	echo json_encode(
		$massiv
	);
}

if (isset($_POST['new_like']) && isset($_SESSION["username"]) && $_SESSION["username"] != ""){
	addLike($_SESSION["username"], $_POST['new_like']);
	unset($_POST['new_like']);
}

if (isset($_POST['remove_like']) && isset($_SESSION["username"]) && $_SESSION["username"] != ""){
	removeLike($_SESSION["username"], $_POST['remove_like']);
	unset($_POST['remove_like']);
}

$data = $_POST;
if (isset($data["comment_text"]) && isset($data["comment_img"]) && isset($_SESSION["username"])
&& $_SESSION["username"] != ""){
	addComment($_SESSION["username"], $data["comment_img"], $data["comment_text"]);
	unset($data);
	unset($_POST);
}
