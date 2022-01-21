<?php



class ControllerElement extends CI_Controller{

	function __construct()
	{
		parent::__construct();
		$this->load->model("myClass/FTPConnexion");
		$this->load->model("myClass/PathCorrecter");
	}

	/**
	 * A function to rename file or directory to a new name :
	 * "path" the path to the element (without itself)
	 * "fileToRename" the elemnt to rename
	 * "newName" the new name of the element
	 * @return false|string|void
	 */
	function rename(){
		if($_SERVER['REQUEST_METHOD'] != "PUT"){
			header($_SERVER["SERVER_PROTOCOL"] . " 406 Not Acceptable");
			echo json_encode(array("error"=>"The protocole methode is not acceptable, you may use PUT."));
			die();
		}

		parse_str(file_get_contents("php://input"),$_PUT);

		if(isset($_PUT["path"],$_PUT["fileToRename"],$_PUT["newName"])) {
			header($_SERVER["SERVER_PROTOCOL"] . "400 Bad Request");
			echo json_encode(array("error"=>"A arguments is missing, you need to precise : the path, the file to rename and the new name"));
			die();
		}
		$path = PathCorrecter::addFinalSlashIfNotPresent($_POST["path"]);
		$fileToRename = $_POST["fileToRename"];
		$newName = $_POST["newName"];

		if(substr($path,-1)!="/")
			$path .= "/";

		$ftp = FTPConnexion::getFTP();
		if(!$ftp){
			header($_SERVER["SERVER_PROTOCOL"] . "400 Bad Request");
			echo json_encode(array("error"=>"Error in the connection to the FTP Server."));
			die();
		}

		$rename = ftp_rename($ftp,$path.$fileToRename, $path.$newName);
		if($rename){
			ftp_close($ftp);
			header($_SERVER["SERVER_PROTOCOL"] . "404 Not Found");
			echo json_encode(array("error"=>$path.$fileToRename. " doesn't exists."),JSON_UNESCAPED_SLASHES);
			die();
		}
		ftp_close($ftp);
		header($_SERVER["SERVER_PROTOCOL"] . "200 OK");
	}

}
