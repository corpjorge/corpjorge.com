<?php

class Mensajes extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Mensaje_model','',TRUE);
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('Parametro_model', '', TRUE);
		$this->load->library('session');
		$this->load->model('Menu_model','',TRUE);
	}
			
	function index()
	{
      	$listadoMensjPeronsal = $this->Mensaje_model->menPersonales($this->session->userdata('login'));

      	$prog = explode('*',$this->session->userdata('programas')) ;	

/*      	echo "<pre>";
      	print_r($prog);
      	exit();*/


      	$programas=$this->session->userdata('programas');
      	$rol=$this->session->userdata('rol');
      	$menu = $this->Menu_model->_getmenu();
		$data = array('titulo' => 'ADMINISTRADOR DE PAR&Aacute;METROS',
					  'menu'=>$menu,
					  'listadoMensjPeronsal'=>$listadoMensjPeronsal,
					  'prog'=>$prog,
					  'rol'=>$rol					  
					  );
		$this->load->view('mensajes_form', $data);
	}

	public function guardarmensaje()
	{

		$crns      				= strip_tags($this->input->post('crns'));
		$mensaje        		= strip_tags($this->input->post('mensaje'));
		$idmensaje       		= (int) $this->input->post('idmensaje');
		$login                 	= $this->session->userdata('login');
		$id_ch_comenpersonales 	= $this->Mensaje_model->agregarMensaje($idmensaje,$crns,$mensaje,$login);
		echo (int) $id_ch_comenpersonales;
	}

	public function eliminarmensaje()
	{
		$idmensaje = $this->input->post('idmensaje');
		$estado          = $this->Mensaje_model->borrarMensaje($idmensaje);
		echo (int) $estado;
	}

	public function ultimomensaje()
	{
		$crns = $this->input->post('idmensaje');
		foreach ($crns as $key => $crn) {
			$id = (int) $crn['value'];
			//echo $id.",";
			$this->Mensaje_model->borrarMensaje($id);
		}
	}

	public function consultacrns()
	{
		$crns = $this->input->post('vcrns');
		$materias = $this->Mensaje_model->consultarmaterias($crns);

		$programas=$this->session->userdata('programas');
		$programas = explode('*',$this->session->userdata('programas')) ;

		$s_crn="ok";
		foreach($materias as $valor)//recorremos el array1 valor por valor 
		{ 
 			if (!in_array($valor['MATERIA'],$programas)) 
 			{
 				//echo "NO ESTA: ".$valor['CRN'];
 				$s_crn=$valor['CRN'];
 				break;
 			}
		}

		echo json_encode($s_crn);
		exit();

	}
}
