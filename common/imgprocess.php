<?php
class PandaImage {
	private $img;
	private $config;
	function hex2col($hexColor){
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
		return imagecolorallocate($this->img, $r, $g, $b);
	}
	public function loadimg($fn) {
		if (strpos($fn,"..") or strpos($fn,"/")) {
			echo "error:invalid name";
			http_response_code(403);
			die();
		}
		$this->img=imagecreatefromjpeg("img/".$fn.".jpg");
		if ($this->img==false) {
			echo "error:invalid name";
			http_response_code(404);
			die();
		}
		$this->config=json_decode(fread(fopen("img/".$fn.".json","r"),filesize("img/".$fn.".json")),true);
	}
	public function addtext($text,$col) {
		$basey=$this->config['basey'];
		$ymax=$this->config['ymax'];
		$maxsize=$this->config['maxsize'];
		$color = $this->hex2col($col, $this->img);
		putenv('GDFONTPATH=' . realpath('./font/'));
		$size=$maxsize;
		$ylen=999;
		while (($ylen>$ymax) or ($x<0)) {
			$size-=5;
			$bbox=imageftbbox($size, 0, "HYH3GJM.TTF", $text);
			$ylen=$bbox[3]-$bbox[5];
			$x = $bbox[0] + (imagesx($this->img) / 2) - ($bbox[4] / 2);
			$y = $basey-($ylen/2);
		}
		$result=imagefttext($this->img, $size, 0, $x, $y, $color, "STXINWEI.TTF", $text);
	}
	public function output() {
		header('Content-Type: image/jpeg');
		imagejpeg($this->img);
	}
}
?>