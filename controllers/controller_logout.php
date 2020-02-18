<?php
session_start();
$_SESSION["username"] = "";
header('Location: http://'.$_SERVER['HTTP_HOST']."/index.php");
