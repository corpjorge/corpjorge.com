<?php

class crnSelector extends CI_Controller {

	function __construct(){
		parent::__construct();
		//$this->load->model('crnSelector_model','',FALSE);		
		//$this->load->library('conflictos');
	}
        
        function index(){           
		$data = array('titulo' => 'Hola mundito prueba 1');
//		$this->_prepare_list($data);
//		print_r($data);
		//$this->load->view('crnSelector', $data);
                $this->load->library('integracion');                
                //$retorno= $this->integracion->programasActivos();
                $retorno= $this->integracion->esComplementaria(31758,'201120');
                echo "<pre>";
                var_dump($retorno);
                echo "</pre>";
            	}
}
?>
