<?php
include ("model_connectDB.php");

function LoadPNG($imgname)
{
    /* Пытаемся открыть */
    $im = @imagecreatefrompng($imgname);

    /* Если не удалось */
    if(!$im)
    {
        /* Создаем пустое изображение */
        $im  = imagecreatetruecolor(150, 30);
        $bgc = imagecolorallocate($im, 255, 255, 255);
        $tc  = imagecolorallocate($im, 0, 0, 0);

        imagefilledrectangle($im, 0, 0, 150, 30, $bgc);

        /* Выводим сообщение об ошибке */
        imagestring($im, 1, 5, 5, 'Ошибка загрузки ' . $imgname, $tc);
    }

    return $im;
}

function createImage($main_img, $overlay_mass, $user_name){
	//макетх2
	$maket = LoadPNG("../img/emptymaketx2.png");
	//основное изображение realsize;
	$sourse = imagecreatefrompng($main_img);

	//resize
	list($width, $height) = getimagesize($_POST["main_img"]);
	$new_width = 600;
	$new_height = 336;
	//основное изображение
	$image = imagecreatetruecolor($new_width, $new_height);
	imagecopyresampled($image, $sourse, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

	//объединение макета и основного изображения
	imagecopy($maket, $image, 30, 148, 0, 0, 600, 336);

	//наложение второстепенных изображений
	$overlaybuf = explode(",", $overlay_mass);
	$overlay = array_filter($overlaybuf);
	$width = 0;
	$height = 0;

	if (!empty($overlay)) {
		for ($i = 0; $i < count($overlay); $i++) {
			$overlaybuf = explode("/", $overlay[$i]);
			$id = $overlaybuf[0];
			$left = str_replace("px","",$overlaybuf[1]);
			$top = str_replace("px","",$overlaybuf[2]);
			$info = getimagesize("../img/overlay/".$id.".png");
			$width = $info[0];
			$height = $info[1];
			$overlay_img = LoadPNG("../img/overlay/".$id.".png");
			imagecopy($maket, $overlay_img, $left*2, $top*2, 0, 0, $width, $height);
			imagedestroy($overlay_img);
		}
	}

	//сохраняем изображение в папку
	if (!file_exists("../img/user_img/".$user_name."/")) {
		mkdir("../img/user_img/".$user_name."/", 0700);
	}
	$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$img_title = substr(str_shuffle($permitted_chars), 0, 16).".png";
	imagepng($maket, "../img/user_img/".$user_name."/".$img_title);
	imagedestroy($image);
	imagedestroy($maket);

	//добавляем в БД
	date_default_timezone_set('Europe/Moscow');
	$today = date("d.m.y");
	$pdo = connectDB();
	try {
		$add = $pdo->prepare("INSERT INTO `images` (`login`,`title`,`date`) VALUES (?,?,?)");
		$add->execute([$user_name,$img_title,$today]);
		closeConnectDB($pdo);
		return true;
	}
	catch(PDOException $e) {"CAN`T ADD NEW IMAGE:".$e->getMessage()." Aborting process<br>"; closeConnectDB($pdo);}
	return (1);
}