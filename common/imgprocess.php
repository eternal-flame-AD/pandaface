<?php
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
	function addtext($img,$text,$basey,$ymax,$sizemax) {
		$black = imagecolorallocate($img, 0x00, 0x00, 0x00);
		putenv('GDFONTPATH=' . realpath('./font/'));
		$size=$sizemax;
		$ylen=999;
		while (($ylen>$ymax) or ($x<0)) {
			$size-=10;
			$bbox=imageftbbox($size, 0, "HYH3GJM.TTF", $text);
			$ylen=$bbox[3]-$bbox[5];
			$x = $bbox[0] + (imagesx($img) / 2) - ($bbox[4] / 2) - 5;
			$y = $basey-($ylen/2);
		}
		$result=imagefttext($img, $size, 0, $x, $y, $black, "HYH3GJM.TTF", $text);
	}
	function output($img) {
		header('Content-Type: image/png');
		imagejpeg($img);
	}
?>