<?php

require_once "ControllerElement.php";

class ControllerDirectory extends ControllerElement
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @return void
	 */
	public function mkdir(){
		if(!isset($_POST["path"])){
			header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
			echo json_encode(array("error"=>"the Path has not been precised"));
			die();
		}

		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
			echo json_encode(array("error"=>"Error in the connection to the FTP Server."));
			die();
		}

		if(!ftp_mkdir($ftp, $_POST["path"])){
			ftp_close($ftp);
			header($_SERVER["SERVER_PROTOCOL"]. " 400 Bad Request");
			echo json_encode(array("error" => "Cannot create this directory, ". $_POST["path"] . " is not found"),JSON_UNESCAPED_SLASHES);
			die();
		}

		ftp_close($ftp);
		header($_SERVER["SERVER_PROTOCOL"] . " 201 Created");
		die();
	}

	public function rmdir(){
		if($_SERVER['REQUEST_METHOD'] != "DELETE"){
			header($_SERVER["SERVER_PROTOCOL"] . " 406 Not Acceptable");
			echo json_encode(array("error"=>"The protocole methode is not acceptable, you may use DELETE."));
			die();
		}

		parse_str(file_get_contents("php://input"),$_DELETE);

		if(!isset($_DELETE["path"])){
			header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
			echo json_encode(array("error"=>" You need to precise the path to delete to the directory"));
			die();
		}

		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
			echo json_encode(array("error"=>"Error in the connection to the FTP Server."));
			die();
		}

		if(!ftp_rmdir($ftp,$_DELETE["path"])){
			//error
			ftp_close($ftp);
			header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
			echo json_encode(array("error"=>$_DELETE. " is not found."),JSON_UNESCAPED_SLASHES);
			die();
		}
		ftp_close($ftp);
		header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
		die();
	}

	/**
	 * @return void
	 */
	function pwd(){
		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
			echo json_encode(array("error"=>"Error in the connection to the FTP Server."));
			die();
		}
		$pwd = ftp_pwd($ftp);
		if(!ftp_pwd($ftp)){
			ftp_close($ftp);
			header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
			echo json_encode(array("error"=>"Error, not be able to do this."));
			die();
		}
		ftp_close($ftp);
		header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
		echo json_encode(array("pwd"=>$pwd),JSON_UNESCAPED_SLASHES);
		die();
	}

	/**
	 * @return void
	 */
	public function ls()
	{
		$path = $_GET["path"] ?? ".";

		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
			echo json_encode(array("error"=>"Error in the connection to the FTP Server."));
			die();
		}
		$list = ftp_nlist($ftp, $path);
		if (!$list) {
			ftp_close($ftp);
			header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
			echo json_encode(array("error"=>$path. " is not a directory or not found"),JSON_UNESCAPED_SLASHES);
			die();
		}
		ftp_close($ftp);
		header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
		echo json_encode($list);
		die();
	}


	/**
	 * @return void
	 */
	public function lsl(){
		$path = $_GET["path"] ?? ".";

		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
			echo json_encode(array("error"=>"Error in the connection to the FTP Server."));
			die();
		}

		$list = ftp_mlsd($ftp,$path);
		if(!$list){
			header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
			echo json_encode(array("error"=>$path." is not a directory or not found"),JSON_UNESCAPED_SLASHES);
			die();
		}
		//retourner la liste
		header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
		echo json_encode($list);
		die();
	}
}
