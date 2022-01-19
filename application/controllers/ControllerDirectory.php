<?php

require_once "ControllerElement.php";

class ControllerDirectory extends ControllerElement
{
	public function __construct()
	{
		parent::__construct();
	}

	public function mkdir(){
		$path = $_POST["path"];
		$ftp = FTPConnexion::getFTP();
		if(!ftp_mkdir($ftp, $path)){
			echo json_encode(array("code_error" => "200", "message" => "Cannot create this directory, the path is incorrect"));
			return;
		}
		ftp_close($ftp);
		//Renvoyer code bon
	}

	public function rmdir(){
		$path = $_POST["path"];
		$array = explode("/",$path);
		$test = "";
		/*for($array as $value){
			if(strpos($path, ' ')){
				$test.="'".$value."'";
			}else{
				$test.=$value;
			}
		}
		*/
		echo $test;
		$ftp = FTPConnexion::getFTP();
		if(!ftp_rmdir($ftp,$path)){
			//error
			return;
		}
		ftp_close($ftp);
	}

	function pwd(){
		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			ErrorJSON::toJson("400","Bad Request","Can't able to connect to the FTP server");
			return;
		}
		$pwd = ftp_pwd($ftp);
		if(!$pwd){
			ErrorJSON::toJson("400","Bad Request","invalid request to PWD");
			return;
		}
		echo json_encode(array("pwd"=>$pwd),JSON_UNESCAPED_SLASHES);
	}

	public function ls(){
		$path = $_GET["path"];
		$ftp = FTPConnexion::getFTP();
		$list = ftp_nlist($ftp,$path);
		if(!$list){
			//return erreur
			return;
		}
		//retourner la liste
		echo json_encode($list);
	}

	public function lsl(){
		$path = $_GET["path"];
		$ftp = FTPConnexion::getFTP();
		$list = ftp_mlsd($ftp,$path);
		if(!$list){
			//return erreur
			return;
		}
		//retourner la liste
		echo json_encode($list);
	}
}
