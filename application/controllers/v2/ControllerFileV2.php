<?php

require_once "ControllerElementV2.php";

class ControllerFileV2 extends ControllerElementV2 {

	public function __construct()
	{
		parent::__construct();
	}

	public function index(){
		switch ($_SERVER['REQUEST_METHOD']){
			case "PUT" :
				$this->put();
			case "GET" :
				$this->get();
			case "DELETE" :
				$this->delete();
			default :
				ResponseJSON::response("406 Not Acceptable", array("error"=>"You're using the wrong protocol verb."));
		}
	}

	/**
	 * GET
	 * @return void
	 */
	private function get(){

		if(!isset($_GET["path"])){
			ResponseJSON::response("400 Bad Request", array("error"=>"The path hasn't be precised."));
			die();
		}

		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			ResponseJSON::responseErrorConnectFTP();
			die();
		}
		$path = PathCorrecter::replaceBackSlashToSlash($_GET["path"]);
		$splitSlash = explode("/", $path);
		$filename = end($splitSlash);
		$file = fopen($_SERVER['DOCUMENT_ROOT']."/uploads/".$filename,"wr");

		if(!$file){
			ftp_close($ftp);
			ResponseJSON::response("400 Bad Request", array("error","File not found "));
			die();
		}
		if(!ftp_fget($ftp,$file,$path,FTP_BINARY)){
			ftp_close($ftp);
			ResponseJSON::response("404 Not found", array("error"=>$path. " has not been found"));
			die();
		}
		ftp_close($ftp);
		$attachment_location = $_SERVER["DOCUMENT_ROOT"] . "/uploads/" . $filename;
		if (file_exists($attachment_location)) {
			header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
			header("Cache-Control: public"); // needed for internet explorer
			header("Content-Type: application/".mime_content_type($attachment_location));
			header("Content-Transfer-Encoding: Binary");
			header("Content-Length:".filesize($attachment_location));
			header("Content-Disposition: attachment; filename=".$filename);
			readfile($attachment_location);
		} else {
			ResponseJSON::response("500 Internal Server Error",array("error"=>"The server can't find the temp file."));
		}
		die();
	}

	/**
	 * @return void
	 */
	private function put(){

		parse_str(file_get_contents("php://input"),$_PUT);

		if(!isset($_PUT["path"],$_FILES["file"])){
			ResponseJSON::response("400 Bad Request",array("error"=>"The path or the file has not been precised."));
			die();
		}

		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			ResponseJSON::responseErrorConnectFTP();
			die();
		}

		$path = PathCorrecter::addFinalSlashIfNotPresent($_PUT['path']);

		if(!ftp_put($ftp,$path.$_FILES['file']['name'],$_FILES['file']['tmp_name'],FTP_BINARY)) {
			ftp_close($ftp);
			ResponseJSON::response("404 Not Found", array("error"=>$path.$_FILES['file']['name']." not found."));
			die();
		}

		//Success
		ftp_close($ftp);
			ResponseJSON::response("201 Created",null);
	}

	private function delete(){

		parse_str(file_get_contents("php://input"),$_DELETE);

		if(!isset($_DELETE["path"])){
			ResponseJSON::response("400 Bad Request",array("error"=>"You need to precise the path"));
			die();
		}

		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			ResponseJSON::response("400 Bad Request",array("error"=>"Error in the connection to the FTP Server."));
			die();
		}

		if (!ftp_delete($ftp, $_DELETE["path"])) {
			ftp_close($ftp);
			ResponseJSON::response("404 Not Found",array("error"=>$_DELETE['path']." is not a file or not found."));
			die();
		}

		//success
		ftp_close($ftp);
		ResponseJSON::response("204 OK",null);
		die();
	}



}
