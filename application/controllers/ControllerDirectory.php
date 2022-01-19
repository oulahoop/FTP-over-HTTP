<?php

class ControllerDirectory extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("myClass/FTPConnexion");
	}

	public function mkdir(...$nom){
		$path = "";
		foreach ($nom as $value){
			$path .= $value."/";
		}
		$ftp = FTPConnexion::getFTP();
		if(!ftp_mkdir($ftp, $path)){
			echo json_encode(array("code_error" => "200", "message" => "Cannot create this directory, the path is incorrect"));
		}

		ftp_close($ftp);
	}

}
