<?php

class PathCorrecter2{

	static function addFinalSlashIfNotPresent($path) : string
	{
		$path = self::replaceBackSlashToSlash($path);
		if(substr($path,-1)!="/")
			$path .= "/";
		return $path;
	}

	static function removeFinalSlashIfNotPresent($path) : string
	{
		$path = self::replaceBackSlashToSlash($path);
		if(substr($path,-1)=="/")
			$path = substr($path,0,-1);
		return $path;
	}


	static function replaceBackSlashToSlash($path) : string
	{
		return str_replace('\\', '/', $path);
	}

	public static function reparePath($path) : string
	{
		$path = self::replaceBackSlashToSlash($path);
		if(strlen($path)==1 && (substr($path,0,1) == '.' || substr($path,0,1) == '/')){
			return "./";
		}

		if(substr($path, 0,2) != './'){
			if(substr($path,0,1) != '/'){
				return "./".$path;
			}
			return '.'.$path;
		}
		return $path;
	}
}
