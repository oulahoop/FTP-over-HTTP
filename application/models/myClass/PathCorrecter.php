<?php

class PathCorrecter{

	static function addFinalSlashIfNotPresent($path) : string
	{
		if(substr($path,-1)!="/")
			$path .= "/";
		return $path;
	}
}
