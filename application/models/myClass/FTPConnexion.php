<?php

class FTPConnexion extends CI_Model{
	static function getFTP()
	{
		$JSONConnexion = json_decode(file_get_contents("application/models/myClass/ConfigConnexion.json"));
		$ftp = ftp_connect($JSONConnexion->{'url'});
		if(ftp_login($ftp, $JSONConnexion->{'login'},$JSONConnexion->{'password'}))
			return $ftp;
		return false;
	}
}


