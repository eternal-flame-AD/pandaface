<?php
	require_once("common/imgprocess.php");
	$name=$_GET['name'];
	$text=$_GET['text'];
	if (!isset($name)) {
		die();
	}
	$img=loadimg($name);
	addtext($img['img'], $text, $img['basey'],$img['ymax'],$img['maxsize'],$_GET['color']);
	output($img['img']);
?>