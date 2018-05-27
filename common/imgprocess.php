<?php
	function hex2rgb($hexColor,$img){
		$color=str_replace('#','',$hexColor);
		if (strlen($color)> 3){
			$r=hexdec(substr($color,0,2));
			$g=hexdec(substr($color,2,2));
			$b=hexdec(substr($color,4,2));
		}else{
			$color=str_replace('#','',$hexColor);
			$r=hexdec(substr($color,0,1).substr($color,0,1));
			$g=hexdec(substr($color,1,1).substr($color,1,1));
			$b=hexdec(substr($color,2,1).substr($color,2,1));
		}
		return imagecolorallocate($img, $r, $g, $b);
	}
	function loadimg($fn) {
		if (strpos($fn,"..") or strpos($fn,"/")) {
			echo "error:invalid name";
			die();
		}
		$img=imagecreatefromjpeg("img/".$fn.".jpg");
		if ($img==false) {
			echo "error:invalid name";
			die();
		}
		$config=json_decode(fread(fopen("img/".$fn.".json","r"),filesize("img/".$fn.".json")),true);
		$result=[
			"img" => $img,
			"basey" => $config['basey'],
			"ymax" => $config['ymax'],
			"maxsize" => $config['maxsize']
		];
		return $result;
	}
	function addtext($img,$text,$basey,$ymax,$sizemax,$col) {
		$color = hex2rgb($col, $img);
		putenv('GDFONTPATH=' . realpath('./font/'));
		$size=$sizemax;
		$ylen=999;
		while (($ylen>$ymax) or ($x<0)) {
			$size-=5;
			$bbox=imageftbbox($size, 0, "HYH3GJM.TTF", $text);
			$ylen=$bbox[3]-$bbox[5];
			$x = $bbox[0] + (imagesx($img) / 2) - ($bbox[4] / 2);
			$y = $basey-($ylen/2);
		}
		$result=imagefttext($img, $size, 0, $x, $y, $color, "STXINWEI.TTF", $text);
	}
	function output($img) {
		header('Content-Type: image/jpeg');
		imagejpeg($img);
	}
?>