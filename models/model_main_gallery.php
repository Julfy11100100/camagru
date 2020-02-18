<?php
include ("model_connectDB.php");

function getLast5Images($number_of_page){
	$mass = Array();
	$pdo = connectDB();

	$query = $pdo->prepare("SELECT COUNT(id) FROM images");
	$query->execute();
	$image_count = $query->fetchColumn();

	$number_of_page = ($number_of_page < 0)?0:$number_of_page;
	while ($image_count < $number_of_page * 5)
		$number_of_page--;
	$offset = $number_of_page * 5;
	$limit = ($number_of_page + 1) * 5;
	$query = $pdo->prepare("SELECT * FROM images ORDER BY id DESC LIMIT ".$offset.",".$limit."");
	$query->execute();

	while($row = $query->fetch(PDO::FETCH_ASSOC)) {
		$mass[] = $row;
	}

	return ($mass);
}

function mainGallery($number_of_page){
	$massiv = getLast5Images($number_of_page);
	for ($i = 0; $i < count($massiv); $i++){
		echo('
		<div class="image_block">
			<div class="name_panel">
				<span class="span_username">'.$massiv[$i]["login"].'</span>
				<span class="span_date">'.$massiv[$i]["date"].'</span>
			</div>
			<div class="image_of_user">
				<img src="/img/user_img/'.$massiv[$i]["login"].'/'.$massiv[$i]["title"].'">
			</div>
			<div class="like_comment_panel">
				<div class="comments_logo">
					<img src="/img/svg/comments.svg" alt="commentslogo" class="logo_comment">
					<span>282</span>
					<img src="/img/svg/plus.svg" alt="commentslogo" class="logo_plus">
				</div>
				<div class="like_logo">
					<img src="/img/svg/like1.svg" style="display:none" alt="likelogo" class="logo_like1">
					<img src="/img/svg/like2.svg" alt="likelogoactiv" class="logo_like2">
					<span>228</span>
				</div>
			</div>
			<div class="comments_block">
				<div class="comment">
					<span id="comment_name">USERTEST</span>
					<span id="comment_text">FOTKA OTSTOY!FOTKA OTSTOY!</span>
				</div>
			</div>
		</div>');
	}
}