<?php

class RespJSON{

	const listError = array(200 => "OK", 201=> "CREATED", 204=> "OK",
							400 => "Bad Request", 404=>"Not Found", 406 => "Not Acceptable",
							500 => "Internal Error");


	static function response($code,$body){
		ob_clean();
		//header
		header($_SERVER["SERVER_PROTOCOL"]. " " . $code. " " . RespJSON::listError[$code]);
		header("Content-Type: application/json");

		//body
		$json = array("code"=>$code,"message"=>RespJSON::listError[$code],"status"=>($code<300?"SUCCESS":"ERROR"));

		if($body != null) {
			$json = array_merge($json, $body);
		}
		echo json_encode($json,JSON_UNESCAPED_SLASHES);
		die();
	}

	static function responseErrorConnectFTP(){
		ob_clean();
		header($_SERVER["SERVER_PROTOCOL"] . " 400 " . RespJSON::listError[400]);
		header("Content-Type: application/json");

		$json = array("code"=>"400","message"=>"Error in the connection to the FTP Server.","status"=>"ERROR");

		echo json_encode($json);
	}

}

