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
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="../css/style.css">
	<title>User gallery</title>
	<script type="text/javascript" src="/js/user_gallery.js" ></script>
</head>
<body>
	<div class="head">
		<?php require_once "../blocks/header.php" ?>
	</div>
	<div class="wrapper">
		<div class="main">
			<div id="main_gallery"></div>
			<div id="prev_next_form">
				<button type="submit" id="prev">prev</button>
				<input type="number" id="number_of_page" readonly value="">
				<button type="submit" id="next">next</button>
			</div>
		</div>
	</div>
	<div class="foot"> 
		<?php require_once "../blocks/footer.php" ?>
	</div>
</body>
</html>
 