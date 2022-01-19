<?php

require_once "ControllerElement.php";

class ControllerFile extends ControllerElement {

	public function __construct()
	{
		parent::__construct();
	}


	function get(){
		$ftp = FTPConnexion::getFTP();
		$path = $_GET["path"];
		$splitSlash = explode("/", $path);
		$splitPoint = explode(".", $path);
		$filename = end($splitSlash);
		$extension = end($splitPoint);
		$file = fopen($_SERVER['DOCUMENT_ROOT']."/".$filename,"wr");


		if(!ftp_fget($ftp,$file,$path,FTP_BINARY)){
			header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
			return;
		}

		ftp_close($ftp);
		$attachment_location = $_SERVER["DOCUMENT_ROOT"] . "/" . $filename;
		if (file_exists($attachment_location)) {
			header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
			header("Cache-Control: public"); // needed for internet explorer
			header("Content-Type: application/".$extension);
			header("Content-Transfer-Encoding: Binary");
			header("Content-Length:".filesize($attachment_location));
			header("Content-Disposition: attachment; filename=".$filename);
			readfile($attachment_location);
			die();
		} else {
			die("Error: File not found.");
		}
	}

	public function put(){
		$path = $_POST['path'];
		$file = $_POST['file'];
		$ftp = FTPConnexion::getFTP();

		if(!ftp_put($ftp,$file,$path.$file)){
			//error
			return;
		}

	}


}


