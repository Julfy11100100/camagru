<?php
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

$maket = LoadPNG("../img/emptymaketx2.png");

$sourse = imagecreatefrompng($_POST["main_img"]);
list($width, $height) = getimagesize($_POST["main_img"]);

$newwidth = 600;
$newheight = 336;

$image = imagecreatetruecolor($newwidth, $newheight);
imagecopyresampled($image, $sourse, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

imagecopy($maket, $image, 30, 148, 0, 0, 600, 336);

//print_r($_POST);


$overlaybuf = explode(",", $_POST["overlay"]);
$overlay = array_filter($overlaybuf);
$overlay_img;

$id;
$left;
$top;
$info;
$width;
$height;


/*if (!empty($overlay)) {
	print_r($overlay);
}*/

if (!empty($overlay)) {
	for ($i = 0; $i < count($overlay); $i++) {
		$overlaybuf = explode("/", $overlay[$i]);
		//print_r($overlaybuf);
		$id = $overlaybuf[0];
		$left = str_replace("px","",$overlaybuf[1]);
		$top = str_replace("px","",$overlaybuf[2]);
		$info = getimagesize("../img/overlay/".$id.".png");
		$width = $info[0];
		$height = $info[1];
		$overlay_img = LoadPNG("../img/overlay/".$id.".png");
		imagecopy($maket, $overlay_img, $left*2, $top*2, 0, 0, $width, $height);
		imagedestroy($overlay_img);
		//echo ("id ".$id."\n");
		//echo ("left ".$left."\n");
		//echo ("top ".$top."\n");
		//echo ("width ".$width."\n");
		//echo ("height ".$height."\n");

	}
}

header('Content-Type: image/png;');
imagepng($maket);
imagepng($maket, './testphoto.png');
imagedestroy($image);
imagedestroy($maket);


?>