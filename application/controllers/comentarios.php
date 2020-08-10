<?php

class Comentarios extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('Parametro_model', '', TRUE);
		$this->load->library('session');
		$this->load->model('Menu_model','',TRUE);
	}
			
	function index()
	{
		$this->load->model('Comentario_model','',TRUE);
      	$listadoComenPeronsal = $this->Comentario_model->comenPersonales($this->session->userdata('login'));
      	$menu = $this->Menu_model->_getmenu();
		$data = array('titulo' => 'ADMINISTRADOR DE PAR&Aacute;METROS',
					  'menu'=>$menu,
					  'listadoComenPeronsal'=>$listadoComenPeronsal					  
					  );
		$this->load->view('comentarios_form', $data);
	}
}
