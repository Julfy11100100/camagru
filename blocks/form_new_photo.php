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
	<script type="text/javascript" src="../js/new_photo.js" ></script>

</head>
<body>
	<div class="head">
		<?php require_once "../blocks/header.php" ?>
	</div>
	<div class="wrapper">
		<div class="main">
			<div id="div_camera">
				<div class="block_camera" id="block_camera">
					<div class="camera" id="camera">
						<div id="input_box"></div>
						<video autoplay="true" id="video"></video>
					</div>
				</div>
			</div>
			<div class="button_panel" id="button_panel">
					<button type="submit" id="start_button">camera</button>
					<button type="submit" id="take_button">photo</button>
					<button type="submit" id="save_button">save</button>
					<button type="submit" id="delete_area">delete</button>
					<button type="submit" id="add_file_button">add file</button>
			</div>
			<div id="block_shot">
				<div id="shot">
					<div id="shot_box"></div>
				</div>
			</div>
			<div class="img_panel" id="img_panel">
				<div class="img1">
					<img src="../img/overlay/n2.png" alt="n2" id="n2" width="100"; height="22.7">
					<img src="../img/overlay/n3.png" alt="n3" id="n3" width="37"; height="37">
					<img src="../img/overlay/canada.png" alt="canada" id="canada" width="50"; height="50">
					<img src="../img/overlay/china.png" alt="china" id="china" width="50"; height="50">
					<img src="../img/overlay/cat2.png" alt="cat2" id="cat2" width="50"; height="50">
					<img src="../img/overlay/dog_cat1.png" alt="dog_cat1" id="dog_cat1" width="50"; height="50">
					<img src="../img/overlay/gitcat.png" alt="gitcat" id="gitcat" width="50"; height="50">
					<img src="../img/overlay/kz.png" alt="kz" id="kz" width="50"; height="50">
					<img src="../img/overlay/hamburger.png" alt="hamburger" id="hamburger" width="50"; height="50">
					<img src="../img/overlay/humster.png" alt="humster" id="humster" width="50"; height="50">
					<img src="../img/overlay/mouse_click.png" alt="mouse_click" id="mouse_click" width="50"; height="50">
					<img src="../img/overlay/mouse.png" alt="mouse" id="mouse" width="50"; height="50">
					<img src="../img/overlay/russia.png" alt="russia" id="russia" width="50"; height="50">
					<img src="../img/overlay/serp_molot.png" alt="serp_molot" id="serp_molot" width="50"; height="50">
					<img src="../img/overlay/smile1.png" alt="smile1" id="smile1" width="50"; height="50">
					<img src="../img/overlay/smile_ninja.png" alt="smile_ninja" id="smile_ninja" width="50"; height="50">
					<img src="../img/overlay/sweden.png" alt="sweden" id="sweden" width="50"; height="50">
					<img src="../img/overlay/ukraine.png" alt="ukraine" id="ukraine" width="50"; height="50">
					<img src="../img/overlay/usa.png" alt="usa" id="usa" width="50"; height="50">
				</div>
			</div>
			<div id="shots_panel"></div>
		</div>
	</div>
	<div class="foot"> 
		<?php require_once "../blocks/footer.php" ?>
	</div>
</body>
</html>
 