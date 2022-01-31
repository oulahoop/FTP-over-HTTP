<?php

require_once "ControllerElementV3.php";

class ControllerDirectoryV3 extends ControllerElementV3
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index(){
		switch ($_SERVER['REQUEST_METHOD']){
			case "POST" :
				$this->mkdir();
			case "DELETE" :
				$this->rmdir();
			default :
				RespJSON::response("406", array("error"=>"Wrong protocol used"));
		}
	}

	/**
	 * FAIT
	 * @return void
	 */

	private function mkdir(){
		if(!isset($_POST["path"])){
			RespJSON::response("400", array("message"=>"The path has not been precised."));
			die();
		}

		$path = PathCorrecter2::reparePath($_POST["path"]);
		$ftp = FTPConnexion::getFTP();

		//FTP Problem
		if(!$ftp){
			RespJSON::responseErrorConnectFTP();
			die();
		}

		//Bad Request
		if(!ftp_mkdir($ftp, $path)){
			ftp_close($ftp);
			RespJSON::response("400", array("message" => "Cannot create this directory here (". $path .")"));
			die();
		}

		ftp_close($ftp);
		$pathSplit = explode('/', PathCorrecter2::removeFinalSlashIfNotPresent($path));
		RespJSON::response("201",array("message"=>"Directory created","directory"=>array("path"=>$path,"directoryName"=>end($pathSplit))));
		die();
	}



	private function rmdir(){

		parse_str(file_get_contents("php://input"),$_DELETE);

		if(!isset($_DELETE["path"])){
			RespJSON::response("400", array("message"=>" You need to precise the path to delete to the directory."));
			die();
		}

		$path = PathCorrecter2::reparePath($_DELETE["path"]);
		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			RespJSON::responseErrorConnectFTP();
			die();
		}

		if(!ftp_rmdir($ftp,$path)){
			ftp_close($ftp);
			RespJSON::response("404", array("message"=>$path. " not found."));
			die();
		}
		ftp_close($ftp);
		$dirsName = explode("/",PathCorrecter2::removeFinalSlashIfNotPresent($path));
		//useless, no body in delete ? :sadge:
		RespJSON::response("200",array("message"=>"Directory successfully deleted","directory"=>array("path"=>$path,"directoryName"=>end($dirsName))));
		die();
	}

	/**
	 * @return void
	 */
	public function pwd(){
		if($_SERVER['REQUEST_METHOD'] != "GET"){
			RespJSON::response("406", array("message"=>"Wrong protocol used."));
			die();
		}
		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			RespJSON::responseErrorConnectFTP();
			die();
		}
		$pwd = ftp_pwd($ftp);

		if(!ftp_pwd($ftp)){
			ftp_close($ftp);
			RespJSON::response("400", array("message"=>"Can't use pwd here."));
			die();
		}
		ftp_close($ftp);
		RespJSON::response("200", array("pwd"=>$pwd));
		die();
	}

	/**
	 * @return void
	 */
	public function ls()
	{
		if($_SERVER['REQUEST_METHOD'] != "GET"){
			RespJSON::response("406", array("message"=>"Wrong protocol used"));
			die();
		}
		//Si $_GET["path"] est null, on remplace avec le chemin courrant
		$path = $_GET["path"] ?? ".";
		$path = PathCorrecter2::reparePath($path);
		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			RespJSON::responseErrorConnectFTP();
			die();
		}

		$mlsd = ftp_mlsd($ftp,$path);
		ftp_close($ftp);
		if(is_bool($mlsd)){
			RespJSON::response("404", array("message"=>$path." not found"));
			die();
		}

		$json = array("code"=>"200","message"=>"ls successfully executed","status"=>"SUCCESS");
		$dirsArray = array();
		foreach($mlsd as $dir){
			$dir = array("name" => $dir["name"], "type" => $dir["type"]);
			$dirsArray[] = $dir;
		}
		$json["ls"] = $dirsArray;

		header($_SERVER["SERVER_PROTOCOL"] . "200");
		header("Content-Type: application/json");
		echo json_encode($json);
		die();

	}



	/**
	 *
	 * @return void
	 */
	public function lsl(){
		if($_SERVER['REQUEST_METHOD'] != "GET"){
			RespJSON::response("406", array("message"=>"Wrong protocol used"));
			die();
		}
		//Si $_GET["path"] est null, on remplace avec le chemin courrant
		$path = $_GET["path"] ?? ".";
		$path = str_replace("./", "/", $path);

		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			RespJSON::responseErrorConnectFTP();
			die();
		}

		//Check si le dossier est vide pour pas renvoyer d'erreur
		$mlsd = ftp_mlsd($ftp,$path);
		ftp_close($ftp);
		if(is_bool($mlsd)){
			RespJSON::response("404", array("message"=>$path." not found"));
			die();
		}

		$json = array("code"=>"200","message"=>"ls -l successfully executed","status"=>"SUCCESS");

		$json["ls"] = $mlsd;

		header($_SERVER["SERVER_PROTOCOL"] . "200");
		header("Content-Type: application/json");
		echo json_encode($json);
		die();
	}
}
