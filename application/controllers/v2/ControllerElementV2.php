<?php

require_once "system/core/Controller.php";

abstract class ControllerElementV2 extends CI_Controller{

	function __construct()
	{
		parent::__construct();
		$this->load->model("myClass/FTPConnexion");
		$this->load->model("myClass/PathCorrecter");
		$this->load->model("myClass/ResponseJSON");
	}

	/**
	 * @return false|string|void
	 */
	public function rename(){
		if($_SERVER['REQUEST_METHOD'] != "POST"){
			ResponseJSON::response("406 Not Acceptable", array("error"=>"The protocol methode is not acceptable, you may use POST."));
			die();
		}

		if(!isset($_POST["path"],$_POST["previousName"],$_POST["newName"])) {
			ResponseJSON::response("400 Bad Request", array("error"=>"A arguments is missing, you need to precise : the path, the previous name of the element to rename and the new name"));
			die();
		}
		$path = PathCorrecter::addFinalSlashIfNotPresent($_POST["path"]);
		$previousName = $_POST["previousName"];
		$newName = $_POST["newName"];


		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			ResponseJSON::responseErrorConnectFTP();
			die();
		}

		$rename = ftp_rename($ftp,$path.$previousName, $path.$newName);
		if(!$rename){
			ftp_close($ftp);
			if($previousName == $newName){
				ResponseJSON::response("200 OK",null);
				die();
			}
			ResponseJSON::response("404 Not Found", array("error"=>$path.$previousName. " doesn't exists."));
			die();
		}
		ftp_close($ftp);
		ResponseJSON::response("200 OK",null);
	}

	public function move(){
		if($_SERVER['REQUEST_METHOD'] != "POST"){
			ResponseJSON::response("406 Not Acceptable", array("error"=>"The protocol methode is not acceptable, you may use POST."));
			die();
		}

		if(!isset($_POST["pathSrc"],$_POST["pathDst"],$_POST["filename"])){
			ResponseJSON::response("400 Bad Request",array("error"=>"You need to precise the path source, the path destination and the file name."));
			die();
		}

		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			ResponseJSON::responseErrorConnectFTP();
			die();
		}

		$pathSrc = PathCorrecter::addFinalSlashIfNotPresent($_POST["pathSrc"]).$_POST["filename"];
		$pathDst = PathCorrecter::addFinalSlashIfNotPresent($_POST["pathDst"]).$_POST["filename"];

		if(!ftp_rename($ftp, $pathSrc, $pathDst)){
			ftp_close($ftp);
			ResponseJSON::response("404 Not Found",array("error"=> $pathSrc. " not found or ". $pathDst . " not found"));
			die();
		}
		ftp_close($ftp);
		ResponseJSON::response("200 OK",null);
		die();
	}

}
