<?php
session_start();
$_SESSION["username"] = "";
unset($_POST);
header('Location: http://'.$_SERVER['HTTP_HOST']."/index.php");
