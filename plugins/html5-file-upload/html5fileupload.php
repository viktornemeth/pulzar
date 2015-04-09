<?php 

if (!empty($_POST)) {

	$error					= false;
	
	$absolutedir			= dirname(__FILE__);
	$dir					= '/tmp/';
	$serverdir				= $absolutedir.$dir;
	
	$tmp					= explode(',',$_POST['file']);
	$file	 				= base64_decode($tmp[1]);
	
	$extension				= strtolower(end(explode('.',$_POST['filename'])));
	$filename				= $_POST['name'].'.'.$extension;
	//$filename				= $file.'.'.substr(sha1(time()),0,6).'.'.$extension;
	
	$handle					= fopen($serverdir.$filename,'w');
	fwrite($handle, $file);
	fclose($handle);
	
	$response = array(
			"result" 		=> true,
			"url" 			=> $dir.$filename.'?'.time(), //added the time to force update when editting multiple times
			"filename" 		=> $filename
	);
	
	echo json_encode($response);
	
	//echo json_encode(array('result'=>true));
	
} else {
	$filename			= basename($_SERVER['QUERY_STRING']);
	$file_url 			= dirname(__FILE__).'/tmp/'.$filename;
	header('Content-Type: 				application/octet-stream');
	header("Content-Transfer-Encoding: 	Binary");
	header("Content-disposition: 		attachment; filename=\"" . basename($file_url) . "\"");
	readfile($file_url); 
	exit();
}



?>