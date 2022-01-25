<?php



class ControllerElement extends CI_Controller{

	function __construct()
	{
		parent::__construct();
		$this->load->model("myClass/FTPConnexion");
		$this->load->model("myClass/PathCorrecter");
		$this->load->model("myClass/ResponseJSON");
	}

	/**
	 * A function to rename file or directory to a new name :
	 * "path" the path to the element (without itself)
	 * "fileToRename" the elemnt to rename
	 * "newName" the new name of the element
	 * @return false|string|void
	 */
	function rename(){
		if($_SERVER['REQUEST_METHOD'] != "POST"){
			ResponseJSON::response("406 Not Acceptable", array("error"=>"The protocol methode is not acceptable, you may use POST."));
			die();
		}

		if(!isset($_POST["path"],$_POST["fileToRename"],$_POST["newName"])) {
			ResponseJSON::response("400 Bad Request", array("error"=>"A arguments is missing, you need to precise : the path, the file to rename and the new name"));
			die();
		}
		$path = PathCorrecter::addFinalSlashIfNotPresent($_POST["path"]);
		$fileToRename = $_POST["fileToRename"];
		$newName = $_POST["newName"];

		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			ResponseJSON::responseErrorConnectFTP();
			die();
		}

		$rename = ftp_rename($ftp,$path.$fileToRename, $path.$newName);
		if(!$rename){
			ftp_close($ftp);
			ResponseJSON::response("404 Not Found", array("error"=>$path.$fileToRename. " doesn't exists."));
			die();
		}
		ftp_close($ftp);
		ResponseJSON::response("200 OK",null);
	}

}
