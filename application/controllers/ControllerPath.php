<?php

class ControllerPath extends CI_Controller{

	function __construct()
	{
		parent::__construct();
		$this->load->model("myClass/FTPConnexion");
		$this->load->model("myClass/ErrorJSON");
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



}
