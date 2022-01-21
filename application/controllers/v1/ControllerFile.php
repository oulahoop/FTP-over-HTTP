<?php

require_once "ControllerElement.php";

class ControllerFile extends ControllerElement {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * GET
	 * @return void
	 */
	function get(){
		if($_SERVER['REQUEST_METHOD'] != "GET"){
			header($_SERVER["SERVER_PROTOCOL"] . " 406 Not Acceptable");
			echo json_encode(array("error"=>"The protocole methode is not acceptable, you may use GET."));
			die();
		}

		if(!isset($_GET["path"])){
			header($_SERVER["SERVER_PROTOCOL"]."400 Bad Request");
			echo json_encode(array("error"=>"The path hasn't be precised."));
			die();
		}

		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			header($_SERVER["SERVER_PROTOCOL"] . "400 Bad Request");
			echo json_encode(array("error"=>"Error in the connection to the FTP Server."));
			die();
		}
		$path = PathCorrecter::addFinalSlashIfNotPresent($_GET["path"]);
		$splitSlash = explode("/", $path);
		$splitPoint = explode(".", $path);
		$filename = end($splitSlash);
		$extension = end($splitPoint);
		$file = fopen($_SERVER['DOCUMENT_ROOT']."/uploads/".$filename,"wr");


		if(!ftp_fget($ftp,$file,$path,FTP_BINARY)){
			ftp_close($ftp);
			header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
			echo json_encode(array("error"=>$path. " has not been found"),JSON_UNESCAPED_SLASHES);
			die();
		}

		ftp_close($ftp);
		$attachment_location = $_SERVER["DOCUMENT_ROOT"] . "/uploads/" . $filename;
		if (file_exists($attachment_location)) {
			header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
			header("Cache-Control: public"); // needed for internet explorer
			header("Content-Type: application/".$extension);
			header("Content-Transfer-Encoding: Binary");
			header("Content-Length:".filesize($attachment_location));
			header("Content-Disposition: attachment; filename=".$filename);
			readfile($attachment_location);
		} else {
			header($_SERVER["SERVER_PROTOCOL"] . "500 Internal Server Error");
			json_encode(array("error"=>"The server can't find the temp file."));
		}
		die();
	}

	/**
	 * @return void
	 */
	function put(){
		if($_SERVER['REQUEST_METHOD'] != "POST"){
			header($_SERVER["SERVER_PROTOCOL"] . " 406 Not Acceptable");
			echo json_encode(array("error"=>"The protocole methode is not acceptable, you may use POST."));
			die();
		}

		if(!isset($_POST["path"],$_FILES["fileToUpload"])){
			//error
			header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
			echo json_encode(array("error"=>"The path or the file has not been precised."));
			die();
		}

		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			header($_SERVER["SERVER_PROTOCOL"] . "400 Bad Request");
			echo json_encode(array("error"=>"Error in the connection to the FTP Server."));
			die();
		}

		$path = PathCorrecter::addFinalSlashIfNotPresent($_POST['path']);

		if(!ftp_put($ftp,$path.$_FILES['fileToUpload']['name'],$_FILES['fileToUpload']['tmp_name'],FTP_BINARY)) {
			//error
			ftp_close($ftp);
			header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
			echo json_encode(array("error"=>$path.$_FILES['fileToUpload']['name']." not found."),JSON_UNESCAPED_SLASHES);
			die();
		}

		//Success
		ftp_close($ftp);
		header($_SERVER["SERVER_PROTOCOL"]. " 201 Created");
	}

	function delete(){
		if($_SERVER['REQUEST_METHOD'] != "DELETE"){
			header($_SERVER["SERVER_PROTOCOL"] . " 406 Not Acceptable");
			echo json_encode(array("error"=>"The protocole methode is not acceptable, you may use DELETE."));
			die();
		}

		parse_str(file_get_contents("php://input"),$_DELETE);

		if(!isset($_DELETE["path"])){
			header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
			echo json_encode(array("error"=>"You need to precise the path"));
			die();
		}

		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
			echo json_encode(array("error"=>"Error in the connection to the FTP Server."));
			die();
		}

		if (!ftp_delete($ftp, $_DELETE["path"])) {
			//error
			ftp_close($ftp);
			header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
			echo json_encode(array("error"=>$_DELETE['path']." not found."),JSON_UNESCAPED_SLASHES);
			return;
		}

		//success
		ftp_close($ftp);
		header($_SERVER["SERVER_PROTOCOL"] . " 204 OK");
	}

	/**
	 *
	 * @return void
	 */
	function move(){
		if(!isset($_POST["pathSrc"],$_POST["pathDst"],$_POST["filename"])){
			header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
			echo json_encode(array("error"=>"You need to precise the path source, the path destination and the file name."));
			die();
		}
		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
			echo json_encode(array("error"=>"Error in the connection to the FTP Server."));
			die();
		}
		$pathSrc = PathCorrecter::addFinalSlashIfNotPresent($_POST["pathSrc"]).$_POST["filename"];
		$pathDst = PathCorrecter::addFinalSlashIfNotPresent($_POST["pathDst"]).$_POST["filename"];
		if(!ftp_rename($ftp, $pathSrc, $pathDst)){
			ftp_close($ftp);
			header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
			echo json_encode(array("error"=> $pathSrc. " not found or ". $pathDst . " not found/already exists"));
			die();
		}
		ftp_close($ftp);
		header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
		die();
	}
}
