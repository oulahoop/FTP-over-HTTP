<?php



class ControllerElement extends CI_Controller{

	function __construct()
	{
		parent::__construct();
		$this->load->model("myClass/FTPConnexion");
		$this->load->model("myClass/ErrorJSON");
	}

	function rename(){
		$ftp = FTPConnexion::getFTP();
		$path = $_POST["path"];
		$fileToRename = $_POST["fileToRename"];
		$newName = $_POST["newName"];
		if(!$ftp){
			ErrorJSON::toJson("400","Bad Request","Can't able to connect to the FTP server");
			return false;
		}
		$rename = ftp_rename($ftp,$path.$fileToRename, $path.$newName);
		if($rename){
			ErrorJSON::toJson("400","Bad Request", "Can't rename the file at ".$path);
			return false;
		}
		ftp_close($ftp);
		return json_encode(array("code" =>"200","message"=>"OK","information"=>"The file as been renamed"));
	}


}
