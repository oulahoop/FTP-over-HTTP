<?php

class PathCorrecter{

	static function addFinalSlashIfNotPresent($path) : string
	{
		if(substr($path,-1)!="/")
			$path .= "/";
		return $path;
	}

	static function replaceBackSlashToSlash($path) : string
	{
		return str_replace('\\', '/', $path);
	}
}
