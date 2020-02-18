<?php
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
					<form action="forgot_password.php" method="post">
						<input type="text" name="Email"
						id="login" placeholder="Email">
						<button class="btn btn-success"
						type ="submit">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="foot"> 
		<?php require_once "../blocks/footer.php" ?>
	</div>
</body>
</html>
 