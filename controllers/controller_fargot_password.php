<?php
include("../models/model_fargot_password.php");

checkEmailAndSendForRecovery($_POST["email"]);

header('Location: http://'.$_SERVER['HTTP_HOST']."/blocks/form_please_check.php");