<?php
	require_once("common/imgprocess.php");
	$name=$_GET['name'];
	$text=$_GET['text'];
	if (!isset($name)) {
		http_response_code(404);
		die();
	}
	$img=new PandaImage();
	$img->loadimg($name);
	$img->addtext($text, $_GET['color']);
	$img->output();
?>