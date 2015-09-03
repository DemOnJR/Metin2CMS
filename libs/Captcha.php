<?php
/*
	Copyright (C) MeClaud
	Version 1.0
*/
header('Content-type: image/png');

session_start();

$font = 'monofont.TTF';

$image = imagecreatetruecolor(60, 30); 

$alb = imagecolorallocate($image, 255, 255, 255);
$negru = imagecolorallocate($image, 0, 0, 0);
 

$text = rand(1000,9999);
$_SESSION['captcha'] = $text;

  
imagefilledrectangle($image, 0, 0, 232, 44, $negru);

imagettftext($image, 20, -10, 8,18, $alb, $font, $text);

imagepng($image);
imagedestroy($image);
?>