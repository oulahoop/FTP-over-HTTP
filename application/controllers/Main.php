<?php
class Main extends CI_Controller {
	function index(){
		$test = array();
		if($test==null){
			print "oui c'est de la merde ça";
		}
		$this->load->view('form.html');
	}
}
