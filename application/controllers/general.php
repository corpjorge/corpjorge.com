<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General extends CI_Controller {

	
	public function saveOrderColumns(){
		$test[0]["abbr"] = "test0";
		$test[0]["axis"] = "test00";
		$test[1]["abbr"] = "test1";
		$test[1]["axis"] = "test11";
		echo json_encode($test);
		//$this->load->view('welcome_message');
	}
}

