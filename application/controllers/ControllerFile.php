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
}


