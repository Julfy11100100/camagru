<?php
include ("model_connectDB.php");

function getLast5Images($number_of_page, $username){
	$mass = Array();
	$pdo = connectDB();

	$query = $pdo->prepare("SELECT COUNT(id) FROM images");
	$query->execute();
	$image_count = $query->fetchColumn();

	$number_of_page = ($number_of_page < 0)?0:$number_of_page;
	while ($image_count < $number_of_page * 6)
		$number_of_page = $number_of_page - 1;
	$offset = $number_of_page * 6;
	$limit = 6;
	$query = $pdo->prepare("SELECT * FROM images ORDER BY id DESC LIMIT ".$offset.",".$limit."");
	$query->execute();

	while($row = $query->fetch(PDO::FETCH_ASSOC)) {
		$buf = array_merge($row, getCountOfCommentsAndLikes($row["title"], $username));
		$buf = array_merge($buf, array("comments" => getCommentsOfImage($row["title"])));
		$mass[] = $buf;
	}
	closeConnectDB($pdo);

	return ($mass);
}

function getCommentsOfImage($img_title) {
	$mass = Array();
	$pdo = connectDB();

	$query = $pdo->prepare("SELECT * FROM `comments` WHERE `img_title`=:img ORDER BY `id` DESC");
	$query->execute(array(':img' => $img_title));

	while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
		$mass[] = $row;
	}
	closeConnectDB($pdo);
	return ($mass);
}

function getCountOfCommentsAndLikes($img_title, $username) {
	$pdo = connectDB();
	$query = $pdo->prepare("SELECT COUNT(`id`) FROM comments WHERE `img_title`=:img");
	$query->execute(array(':img' => $img_title));
	$comments_count = Array("count_of_comments" => $query->fetchColumn());

	$query = $pdo->prepare("SELECT COUNT(`id`) FROM likes WHERE `img_title`=:img");
	$query->execute(array(':img' => $img_title));
	$comments_likes = Array("count_of_likes" => $query->fetchColumn());

	$query = $pdo->prepare("SELECT COUNT(`id`) FROM likes WHERE `img_title`=:img AND `login`=:logi");
	$query->execute(array(':img' => $img_title, ':logi' => $username));$query = $pdo->prepare("SELECT COUNT(`id`) FROM likes WHERE `img_title`=:img AND `login`=:logi");
	$query->execute(array(':img' => $img_title, ':logi' => $username));
	$user_like = Array("userlike" => $query->fetchColumn());

	$array = array_merge($comments_count, $comments_likes);
	$array = array_merge($array, $user_like);
	closeConnectDB($pdo);
	return ($array);
}

function sendCommentToMail($login_from, $login_to ,$email, $comment){
    $subject = "Confirm Camagru";
    $content = "<html>
                  <head>
                    <title> Camagru </title>
                    </head>
                    <body>
						<p>Hello " .$login_to. "! ".$login_from." put a comment on your photo.</p>
						<p>Comment: ".$comment."</p>
                    </body>";
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: camagru2020@yandex.ru>' . "\r\n";
	mail($email, $subject, $content, $headers);
}

function addComment($username, $img_title, $comment) {
	$pdo = connectDB();

	$query = $pdo->prepare("SELECT `login` FROM `images` WHERE `title`=:tit");
	$query->execute(array(':tit' => $img_title));
	$row = $query->fetch(PDO::FETCH_ASSOC);
	if ($row["login"] != $username) {
		$query = $pdo->prepare("SELECT * FROM `users` WHERE `login`=:logi");
		$query->execute(array(':logi' => $row["login"]));
		$row = $query->fetch(PDO::FETCH_ASSOC);
		if ($row["comment_to_email"] == 1){
			sendCommentToMail($username, $row["login"], $row["email"], $comment);
		}
	}
	try {
		$add = $pdo->prepare("INSERT INTO `comments` (`login`,`img_title`,`comment`) VALUES (?,?,?)");
		$add->execute([$username, $img_title, $comment]);
		return true;
	}
	catch(PDOException $e) {"CAN`T ADD NEW COMMENT:".$e->getMessage()." Aborting process<br>"; closeConnectDB($pdo);} 
	closeConnectDB($pdo);
}

function addLike($username, $img_title) {
	$pdo = connectDB();
	$query = $pdo->prepare("SELECT COUNT(`id`) FROM likes WHERE `img_title`=:img AND `login`=:logi");
	$query->execute(array(':img' => $img_title, ':logi' => $username));
	if ($query->fetchColumn() == 0){
		try{
			$add = $pdo->prepare("INSERT INTO likes (`login`,`img_title`) VALUES (?,?)");
			$add->execute(array($username, $img_title));
		}
		catch(PDOException $e) {"CAN`T ADD LIKE:".$e->getMessage()." Aborting process<br>"; closeConnectDB($pdo);} 
	}
	else{
		closeConnectDB($pdo);
	}
}

function removeLike($username, $img_title) {
	$pdo = connectDB();
	$query = $pdo->prepare("SELECT COUNT(`id`) FROM likes WHERE `img_title`=:img AND `login`=:logi");
	$query->execute(array(':img' => $img_title, ':logi' => $username));
	if ($query->fetchColumn() != 0){
		try{
			$delete = $pdo->prepare("DELETE FROM likes WHERE `img_title`=:img AND `login`=:logi");
			$delete->execute(array(':img' => $img_title, ':logi' => $username));
		}
		catch(PDOException $e) {"CAN`T DELETE LIKE:".$e->getMessage()." Aborting process<br>"; closeConnectDB($pdo);} 
	}
	else{
		closeConnectDB($pdo);
	}
}

function getMaxPage(){
	$pdo = connectDB();

	$query = $pdo->prepare("SELECT COUNT(id) FROM images");
	$query->execute();
	$image_count = $query->fetchColumn();
	$max_page = (int)($image_count/6);
	if (bcmod($image_count, 6) != 0){
		$max_page+=1;
	}
	closeConnectDB($pdo);
	return($max_page);
}

/*function mainGallery($number_of_page){
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
}*/