<?php

$num=4;//number
$height=38;//image height
$width=105;//image width
$move_x=5;//_x
$move_y=27;//_y
$font_size=18;//font size
$count = 100;// confulls
function getAuthImage($text,$im_x,$im_y,$move_x,$move_y,$font_size,$count) {

	$im = imagecreatetruecolor($im_x,$im_y);
	$text_c = ImageColorAllocate($im, mt_rand(0,100),mt_rand(0,100),mt_rand(0,100));
	$tmpC0=mt_rand(100,255);
	$tmpC1=mt_rand(100,255);
	$tmpC2=mt_rand(100,255);
	$buttum_c = ImageColorAllocate($im,$tmpC0,$tmpC1,$tmpC2);
	imagefill($im, 16, 13, $buttum_c);

	$font = '../font/Airbus.ttf';

	for ($i=0;$i<strlen($text);$i++)
	{
		$tmp =substr($text,$i,1);
		$array = array(-1,1);
		$p = array_rand($array);
		$an = $array[$p]*mt_rand(1,10);
		$size =$font_size;
		imagettftext($im, $size, $an, $i*$size+$move_x,$move_y, $text_c, $font, $tmp);
	}


	$distortion_im = imagecreatetruecolor ($im_x, $im_y);

	imagefill($distortion_im, 16, 13, $buttum_c);
	for ( $i=0; $i<$im_x; $i++) {
		for ( $j=0; $j<$im_y; $j++) {
			$rgb = imagecolorat($im, $i , $j);
			if( (int)($i+20+sin($j/$im_y*2*M_PI)*10) <= imagesx($distortion_im)&& (int)($i+20+sin($j/$im_y*2*M_PI)*10) >=0 ) {
				imagesetpixel ($distortion_im, (int)($i+10+sin($j/$im_y*1*M_PI-M_PI*0.1)*1) , $j , $rgb);
			}
		}
	}
	for($i=0; $i<$count; $i++){
		$randcolor = ImageColorallocate($distortion_im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
		imagesetpixel($distortion_im, mt_rand()%$im_x , mt_rand()%$im_y , $randcolor);
	}

	$rand = mt_rand(5,30);
	$rand1 = mt_rand(1,25);
	$rand2 = mt_rand(5,10);
	for ($yy=$rand; $yy<=+$rand+2; $yy++){
		for ($px=-80;$px<=80;$px=$px+0.1)
		{
			$x=$px/$rand1;
			if ($x!=0)
			{
				$y=sin($x);
			}
			$py=$y*$rand2;

		//imagesetpixel($distortion_im, $px+80, $py+$yy, $text_c);
		}
	}

	Header("Content-type: image/JPEG");

	ImagePNG($distortion_im);

	ImageDestroy($distortion_im);
	ImageDestroy($im);
}

function make_rand($length="36"){
	$str="abcdefghijklmnopqrstuvwxyz0123456789";
	$result="";
	for($i=0;$i<$length;$i++){
		$num[$i]=rand(0,35);
		$result.=$str[$num[$i]];
	}
	return $result;
}


$checkcode = make_rand($num);
session_start();
$_SESSION['coupon_submit_code']=strtolower($checkcode);
getAuthImage($checkcode,$width,$height,$move_x,$move_y,$font_size,$count);
?>
