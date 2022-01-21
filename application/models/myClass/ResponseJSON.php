<?php

class ResponseJSON{

	static function response($code,$body){
		ob_clean();
		header($_SERVER["SERVER_PROTOCOL"]. " " . $code);
		if(!$body == null){
			echo json_encode($body,JSON_UNESCAPED_SLASHES);
		}
	}

	static function responseErrorConnectFTP(){
		ob_clean();
		header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
		echo json_encode(array("error" => "Error in the connection to the FTP Server."));
	}

}
