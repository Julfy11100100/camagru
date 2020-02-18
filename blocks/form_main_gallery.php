<?php
session_start();
include("../models/model_main_gallery.php");
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="../css/style.css">
	<title>Main gallery</title>
	<script type="text/javascript" src="/js/main_script.js" ></script>
</head>
<body>
	<div class="head">
		<?php require_once "../blocks/header.php" ?>
	</div>
	<div class="wrapper">
		<div class="main">
			<div id="prev_next_form">
				<button type="submit" id="prev">prev</button>
				<input type="number" id="number_of_page" readonly>
				<button type="submit" id="next">next</button>
			</div>
			<div class="main_gallery">
				<?php
					mainGallery(0);
				?>
			</div>
		</div>
	</div>
	<div class="foot"> 
		<?php require_once "../blocks/footer.php" ?>
	</div>
</body>
</html>
 