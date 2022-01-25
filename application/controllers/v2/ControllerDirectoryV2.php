<?php

require_once "ControllerElementV2.php";

class ControllerDirectoryV2 extends ControllerElementV2
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index(){
		switch ($_SERVER['REQUEST_METHOD']){
			case "POST" :
				$this->mkdir();
			case "GET" :
				$this->ls();
			case "DELETE" :
				$this->rmdir();
			default :
				ResponseJSON::response("400 Bad Request", array("error"=>"You're using the wrong protocol."));
		}
	}

	/**
	 *
	 */
	private function mkdir(){
		if($_SERVER['REQUEST_METHOD'] != "POST"){
			ResponseJSON::response("406 Not Acceptable", array("error"=>"The protocole methode is not acceptable, you may use POST."));
			die();
		}

		if(!isset($_POST["path"])){
			ResponseJSON::response("400 Bad Request", array("error"=>"The path has not been precised."));
			die();
		}

		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			ResponseJSON::responseErrorConnectFTP();
			die();
		}

		if(!ftp_mkdir($ftp, $_POST["path"])){
			ftp_close($ftp);
			ResponseJSON::response("400 Bad Request", array("error" => "Cannot create this directory, ". $_POST["path"] . " is not found"));
			die();
		}

		ftp_close($ftp);
		ResponseJSON::response("201 Created",null);
		die();
	}

	private function rmdir(){
		if($_SERVER['REQUEST_METHOD'] != "DELETE"){
			ResponseJSON::response("406 Not Acceptable", array("error"=>"The protocole methode is not acceptable, you may use DELETE."));
			die();
		}

		parse_str(file_get_contents("php://input"),$_DELETE);

		if(!isset($_DELETE["path"])){
			ResponseJSON::response("400 Bad Request", array("error"=>" You need to precise the path to delete to the directory"));
			die();
		}

		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			ResponseJSON::response("400 Bad Request", array("error"=>"Error in the connection to the FTP Server."));
			die();
		}

		if(!ftp_rmdir($ftp,$_DELETE["path"])){
			ftp_close($ftp);
			ResponseJSON::response("400 Bad Request", array("error"=>$_DELETE. " is not found."));

			die();
		}
		ftp_close($ftp);
		ResponseJSON::response("204 OK",null);
		die();
	}

	/**
	 * @return void
	 */
	public function pwd(){
		if($_SERVER['REQUEST_METHOD'] != "GET"){
			ResponseJSON::response("406 Not Acceptable", array("error"=>"The protocole methode is not acceptable, you may use GET."));
			die();
		}
		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			ResponseJSON::responseErrorConnectFTP();
			die();
		}
		$pwd = ftp_pwd($ftp);
		if(!ftp_pwd($ftp)){
			ftp_close($ftp);
			ResponseJSON::response("400 Bad Request", array("error"=>"Error, not be able to do this."));
			die();
		}
		ftp_close($ftp);
		ResponseJSON::response("200 OK", array("pwd"=>$pwd));
		die();
	}

	/**
	 * @return void
	 */
	private function ls()
	{
		if($_SERVER['REQUEST_METHOD'] != "GET"){
			ResponseJSON::response("406 Not Acceptable", array("error"=>"The protocole methode is not acceptable, you may use GET."));
			die();
		}
		//Si $_GET["path"] est null, on remplace avec le chemin courrant
		$path = $_GET["path"] ?? ".";
		$path = str_replace("./", "/", $path);
		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			ResponseJSON::responseErrorConnectFTP();
			die();
		}
		//Check si le dossier est vide pour pas renvoyer d'erreur
		$array = explode("/", $path); //.
		$dir = "./";
		for($i = 0; $i<sizeof($array)-1;$i++){
			$dir.=$array[$i];
		}
		$dirTest = ftp_nlist($ftp, $dir);
		if(!$dirTest){
			ftp_close($ftp);
			ResponseJSON::response("404 Not Found", array("error"=>$path." not found"));
			die();
		}
		$lastDir = end($array);

		$list = ftp_nlist($ftp, $path);

		if (!$list && !in_array($lastDir, $dirTest)) {
			ftp_close($ftp);
			ResponseJSON::response("400 Bad Request", array("error"=>$path. " is not a directory or not found"));
			die();
		}
		ftp_close($ftp);

		//Ne pas utiliser ResponseJSON car en cas de liste vide, celle-ci vaut null
		header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
		echo json_encode($list);
		die();
	}


	/**
	 * @return void
	 */
	public function lsl(){
		if($_SERVER['REQUEST_METHOD'] != "GET"){
			ResponseJSON::response("406 Not Acceptable", array("error"=>"The protocole methode is not acceptable, you may use GET."));
			die();
		}
		//Si $_GET["path"] est null, on remplace avec le chemin courrant
		$path = $_GET["path"] ?? ".";
		$path = str_replace("./", "/", $path);

		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			ResponseJSON::responseErrorConnectFTP();
			die();
		}

		//Check si le dossier est vide pour pas renvoyer d'erreur
		$array = explode("/", $path);
		$dir = "./";
		for($i = 0; $i<sizeof($array)-1;$i++){
			$dir.=$array[$i];
		}
		$dirTest = ftp_nlist($ftp, $dir);
		if(!$dirTest){
			ftp_close($ftp);
			ResponseJSON::response("404 Not Found", array("error"=>$path." not found"));
			die();
		}
		$lastDir = end($array);

		$list = ftp_mlsd($ftp, $path);

		if (!$list && !in_array($lastDir, $dirTest)) {
			ftp_close($ftp);
			ResponseJSON::response("400 Bad Request", array("error"=>$path. " is not a directory or not found"));
			die();
		}
		ftp_close($ftp);

		//Ne pas utiliser ResponseJSON car en cas de liste vide, celle-ci vaut null
		header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
		echo json_encode($list);
		die();
	}
}
