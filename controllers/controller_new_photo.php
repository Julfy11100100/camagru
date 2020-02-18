<?php
session_start();
include ("../models/model_new_photo.php");

createImage($_POST["main_img"], $_POST["overlay"], $_SESSION["username"]);
