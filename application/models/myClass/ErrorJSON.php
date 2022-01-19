<?php

class ErrorJSON extends CI_Model{
	static function toJson($code,$message,$error){
		header($code);
		return json_encode(array("code"=>$code,
								"message"=>$message,
								"error"=>$error));
	}

}
