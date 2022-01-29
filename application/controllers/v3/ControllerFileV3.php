<?php

require_once "ControllerElementV3.php";

class ControllerFileV3 extends ControllerElementV3 {

	public function __construct()
	{
		parent::__construct();
	}

	public function index(){
		switch ($_SERVER['REQUEST_METHOD']){
			case "POST" :
				$this->post();
			case "GET" :
				$this->get();
			case "DELETE" :
				$this->delete();
			default :
				RespJSON::response("406", array("message"=>"Wrong protocol used"));
		}
	}

	private function get(){

		if(!isset($_GET["path"])){
			RespJSON::response("400", array("message"=>"Path need to be precised"));
			die();
		}

		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			RespJSON::responseErrorConnectFTP();
			die();
		}
		$path = PathCorrecter2::reparePath($_GET["path"]);
		$splitSlash = explode("/", $path);
		$filename = end($splitSlash);

		$file = fopen($_SERVER['DOCUMENT_ROOT']."/uploads/".$filename,"wr");

		if(!$file){
			ftp_close($ftp);
			RespJSON::response("400", array("message","File not found"));
			die();
		}
		if(!ftp_fget($ftp,$file,$path,FTP_BINARY)){
			unlink($filename);
			ftp_close($ftp);
			RespJSON::response("404", array("message"=>$path. " not found"));
			die();
		}
		ftp_close($ftp);

		$attachment_location = $_SERVER["DOCUMENT_ROOT"] . "/uploads/" . $filename;
		if (file_exists($attachment_location)) {
			header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
			header("Cache-Control: public"); // needed for internet explorer
			header("Content-Type: application/json");
			header("Content-Transfer-Encoding: Binary");
			header("Content-Disposition: attachment; filename=".$filename);
			echo json_encode(array("code"=>"200","message"=>"File successfully get","status"=>"SUCCESS","file"=>array("name"=>$filename,"content"=>file_get_contents($attachment_location))));
		} else {
			RespJSON::response("500",null);
		}
		die();
	}

	/**
	 * @return void
	 */
	private function post(){

		if(!isset($_POST["path"],$_FILES["file"])) {
			RespJSON::response("400", array("message" => "Path or file need to be precised"));
			die();
		}

		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			RespJSON::responseErrorConnectFTP();
			die();
		}

		$path = PathCorrecter2::addFinalSlashIfNotPresent(PathCorrecter2::reparePath($_POST['path']));

		if(!ftp_put($ftp,$path.$_FILES['file']['name'],$_FILES['file']['tmp_name'],FTP_BINARY)) {
			ftp_close($ftp);
			RespJSON::response("400", array("message"=>$path." not exists or ".$path.$_FILES['file']['name']." already exists"));
			die();
		}

		//Success
		ftp_close($ftp);
		$content = explode("/",mime_content_type($_FILES['file']['tmp_name']))[0];
		$content = $content == "text" ? file_get_contents($_FILES['file']['tmp_name']) : mime_content_type($_FILES['file']['name']);
		RespJSON::response("201",array(
						"message"=>"File successfully posted",
						"file"=>array(
								"path"=>$path.$_FILES['file']['name'],
								"content"=>$content
						)));
		die();
	}

	private function delete(){

		parse_str(file_get_contents("php://input"),$_DELETE);

		if(!isset($_DELETE["path"])){
			RespJSON::response("400",array("message"=>"Path need to be precised"));
			die();
		}

		$path = PathCorrecter2::reparePath($_DELETE['path']);
		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			RespJSON::responseErrorConnectFTP();
			die();
		}

		if (!ftp_delete($ftp, $path)) {
			ftp_close($ftp);
			RespJSON::response("404",array("message"=>$path." is not a file or not found."));
			die();
		}

		//success
		ftp_close($ftp);
		RespJSON::response("204",array("message"=>"File successfully delete","file"=>array("path"=>$path)));
		die();
	}

}
