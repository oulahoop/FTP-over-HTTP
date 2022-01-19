<?php

class FTPConnexion extends CI_Model{

	static function getFTP()
	{
		$ftp = ftp_connect("ftp.drivehq.com");
		if(!$ftp){
			echo "Error Connexion";
			return false;
		}
		if(ftp_login($ftp, "oulahoop","AZERTYuiop1"))
			return $ftp;
		echo "Error Connexion";
		return false;
	}
}


