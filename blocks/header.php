<?php
session_start();
$flag = 0;
if ($_SESSION["username"] != "")
	$flag = 1;

?>

<header>
	<div class="header">
		<div class="header_container">
			<div class="logo">
                <img id="logo_img" src="../img/svg/logo_camagru.svg" alt="camagru">
			</div>
            <input type="checkbox" id="menu-checkbox">
            <nav role="navigation">
                <label for="menu-checkbox" class="toggle-button"
                data-open="MENU" data-close="CLOSE" onclick></label>
			    <ul class="main-menu">
					<?php if ($flag) {echo ('
						<li><a href="../index.php">MAIN</a></li>
						<li><a href="../blocks/form_user_gallery.php">GALLERY</a></li>
						<li><a href="../blocks/form_new_photo.php">PHOTO</a></li>
						<li><a href="../controllers/controller_logout.php">LOGOUT</a></li>
						<li><a href="../blocks/form_account_information.php">ACCOUNT</a></li>	
					');}
					else { echo ('
						<li><a href="../index.php">MAIN</a></li>
						<li><a href="../blocks/form_login.php">LOG IN</a></li>
						<li><a href="../blocks/form_new_account.php">NEW ACC</a></li>
					');}?>
                </ul>
            </nav>
		</div>
	</div>
</header>