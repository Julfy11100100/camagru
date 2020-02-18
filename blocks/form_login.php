<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="../css/style.css">
    <title>Document</title>
</head>
<body>
	<div class="head">
		<?php require_once "../blocks/header.php" ?>
	</div>
	<div class="wrapper">
		<div class="main">
			<div class="form">
				<div class="inner_form">
					<form action="/controllers/controller_login.php" method="post">
						<input type="text" name="login"
						id="login" placeholder="Login">
						<input type="password" name="password"
						id="login" placeholder="Password">
						<button class="btn btn-success"
						type ="submit">Submit</button>
						<div class="form_link">
							<a href="form_forgot_password.php"><span>Fargot your password? Click here!</span></a>
						</div>
					</form>
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
 