<?php

class FTPConnexion extends CI_Model{

	static function getFTP()
	{
		$ftp = ftp_connect("ftp.drivehq.com");
		if(ftp_login($ftp, "oulahoop","AZERTYuiop1"))
			return $ftp;
		return false;
	}
}


