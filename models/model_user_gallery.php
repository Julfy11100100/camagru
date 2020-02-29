<?php
include ("model_connectDB.php");

function getLast5ImagesUser($number_of_page, $username){
	$mass = Array();
	$pdo = connectDB();

	$query = $pdo->prepare("SELECT COUNT(`id`) FROM `images` WHERE login=:logi");
	$query->execute([":logi" => $username]);
	$image_count = $query->fetchColumn();

	$number_of_page = ($number_of_page < 0)?0:$number_of_page;
	while ($image_count < $number_of_page * 6)
		$number_of_page = $number_of_page - 1;
	$offset = $number_of_page * 6;
	$limit = 6;
	$query = $pdo->prepare("SELECT * FROM images WHERE login=:logi ORDER BY id DESC LIMIT ".$offset.",".$limit."");
	$query->execute([":logi" => $username]);

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

function getMaxPageUser($username){
	$pdo = connectDB();

	$query = $pdo->prepare("SELECT COUNT(id) FROM images WHERE login=:logi");
	$query->execute([":logi" => $username]);
	$image_count = $query->fetchColumn();
	$max_page = (int)($image_count/6);
	if (bcmod($image_count, 6) != 0){
		$max_page+=1;
	}
	closeConnectDB($pdo);
	return($max_page);
}

function addComment($username, $img_title, $comment) {
	$pdo = connectDB();

	try {
		$add = $pdo->prepare("INSERT INTO `comments` (`login`,`img_title`,`comment`) VALUES (?,?,?)");
		$add->execute([$username, $img_title, $comment]);
		closeConnectDB($pdo);
		return true;
	}
	catch(PDOException $e) {"CAN`T ADD NEW COMMENT:".$e->getMessage()." Aborting process<br>"; closeConnectDB($pdo);} 
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

function deleteImgUser($username, $img_title) {
	$pdo = connectDB();
	$file = "../img/user_img/".$username."/".$img_title;
	if (file_exists($file)) {
		unlink($file);
	}
	try {
		$delete = $pdo->prepare("DELETE FROM `images` WHERE `title`=:img AND `login`=:logi");
		$delete->execute(array(':img' => $img_title, ':logi' => $username));
		$delete = $pdo->prepare("DELETE FROM `comments` WHERE `img_title`=:img");
		$delete->execute(array(':img' => $img_title));
		$delete = $pdo->prepare("DELETE FROM `likes` WHERE `img_title`=:img");
		$delete->execute(array(':img' => $img_title));
	}
	catch(PDOException $e) {"CAN`T DELETE IMG:".$e->getMessage()." Aborting process<br>"; closeConnectDB($pdo);}
}