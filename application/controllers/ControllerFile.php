<?php

class ControllerFile extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("myClass/FTPConnexion");
	}


	function index(){
		print "test";
		$this->load->view("welcome_message");
	}

	function pwd(){
		$ftp = FTPConnexion::getFTP();
		echo ftp_pwd($ftp);
		ftp_close($ftp);
	}

	function ls(){
		$ftp = FTPConnexion::getFTP();
		print_r (ftp_nlist($ftp, "./test"));
		ftp_close($ftp);
	}

	function get($path){
		$ftp = FTPConnexion::getFTP();
		ftp_get($ftp,"/Users/maelc/Documents/test.txt",$path,FTP_BINARY);
		ftp_close($ftp);
	}

	function rename(){
		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			ErrorJSON::toJson("400","Bad Request","Can't able to connect to the FTP server");
			return false;
		}
		$rename = ftp_rename($ftp,$_POST['pathSrc'],$_POST['newName']);
		if($rename){
			ErrorJSON::toJson("400","Bad Request", "Can't rename the file at ".$_POST['pathSrc']);
			return false;
		}
		ftp_close($ftp);
		return json_encode(array("code" =>"200","message"=>"OK","information"=>"The file as been renamed"));
	}
}


