<?php

require_once "system/core/Controller.php";

abstract class ControllerElementV3 extends CI_Controller{

	function __construct()
	{
		parent::__construct();
		$this->load->model("myClass/FTPConnexion");
		$this->load->model("myClass/PathCorrecter");
		$this->load->model("myClass2/RespJSON");
		$this->load->model("myClass2/PathCorrecter2");
	}

	/**
	 * @return false|string|void
	 */
	public function rename(){
		if($_SERVER['REQUEST_METHOD'] != "POST"){
			RespJSON::response("406" ,array("message"=>"Wrong protocol used."));
			die();
		}

		if(!isset($_POST["path"],$_POST["previousName"],$_POST["newName"])) {
			RespJSON::response("400", array("message"=>"path, previousName or newName is missing"));
			die();
		}

		$path = PathCorrecter2::addFinalSlashIfNotPresent(PathCorrecter2::reparePath($_POST["path"]));
		$previousName = $_POST["previousName"];
		$newName = $_POST["newName"];


		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			RespJSON::responseErrorConnectFTP();
			die();
		}

		$rename = ftp_rename($ftp,$path.$previousName, $path.$newName);

		if(!$rename){
			ftp_close($ftp);

			if($previousName == $newName){
				RespJSON::response("200",array("message"=>"previousName is the same as the newName"));
				die();
			}
			RespJSON::response("404", array("error"=>$path.$previousName. " doesn't exists."));
			die();
		}
		ftp_close($ftp);
		RespJSON::response("200",array("message"=>"File successfully renamed","file"=>array("path"=>$path.$newName, "previousName"=>$previousName,"newName"=>$newName)));
		die();
	}

	public function move(){
		if($_SERVER['REQUEST_METHOD'] != "POST"){
			RespJSON::response("406", array("message"=>"Wrong protocol used"));
			die();
		}

		if(!isset($_POST["pathSrc"],$_POST["pathDst"],$_POST["filename"])){
			RespJSON::response("400",array("message"=>"pathSrc, pathDst or filename is missing"));
			die();
		}

		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			RespJSON::responseErrorConnectFTP();
			die();
		}
		$filename = $_POST["filename"];
		$pathSrc = PathCorrecter2::addFinalSlashIfNotPresent(PathCorrecter2::reparePath($_POST["pathSrc"])).$filename;
		$pathDst = PathCorrecter2::addFinalSlashIfNotPresent(PathCorrecter2::reparePath($_POST["pathDst"])).$filename;

		if(!ftp_rename($ftp, $pathSrc, $pathDst)){
			ftp_close($ftp);
			RespJSON::response("404",array("message"=> $pathSrc." not found or ". $pathDst. " not found"));
			die();
		}
		ftp_close($ftp);
		RespJSON::response("200",array("message"=>"File successfully moved","file"=>array("path"=>$pathDst,"previousPath"=>$pathSrc)));
		die();
	}

}
