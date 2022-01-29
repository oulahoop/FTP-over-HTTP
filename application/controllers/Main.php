<?php

class Main extends CI_Controller {
	function index(){
		header("Location: docs/build/html/index.html");
	}
}
