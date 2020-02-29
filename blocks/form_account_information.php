<?php
session_start();
if ($_SESSION["username"] == "") {
	header('Location: http://'.$_SERVER['HTTP_HOST']."/index.php");
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="../css/style.css">
	<title>Account_information</title>
	<script type="text/javascript" src="../js/account_information.js" ></script>
</head>
<body>
	<div class="head">
		<?php require_once "../blocks/header.php" ?>
	</div>
	<div class="wrapper">
		<div class="main">
			<div class="form">
				<div class="inner_form">
					<form action="/controllers/controller_account_information.php" method="post">
						<input type="text" name="new_login"
						id="login" placeholder="New login" style="display: none">
						<input type="text" name="new_email"
						id="email" placeholder="New Email" style="display: none">
						<input type="password" name="new_password" style="display: none"
						id="new_password" placeholder="New password">
						<input type="password" name="password" style="display: none"
						id="old_password" placeholder="Password">
						<button class="btn btn-success" style="display: none"
						type ="submit" id="submit">Submit</button>
					</form>
					<button id="button_new_login" style="display: block">New Login</button>
					<button id="button_new_password" style="display: block">New Password</button>
					<button id="button_new_email" style="display: block">New Email</button>
					<button id="button_change" style="display: block">Change comment status</button>
					<div id="comment_status1" style="display: none">
						<p>Сomment notifications will be sent to your mail</p>
					</div>
					<div id="comment_status2" style="display: none">
						<p>Сomment notifications will not be sent to your mail</p>
					</div>
				</div>
				<?php if ($_SESSION["errors"] && !empty($_SESSION["errors"])) {
					echo ('<div class="divErrors">');
							for ($i = 0; $i < count($_SESSION["errors"]); $i++){
								echo ('<p>'.$_SESSION["errors"][$i].'</p><br>');
							}
							unset($_SESSION["errors"]);
					echo ('</div>');
				}?>
			</div>
		</div>
	</div>
	<div class="foot"> 
		<?php require_once "../blocks/footer.php" ?>
	</div>
</body>
</html>
 