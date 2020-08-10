<?php
class Menu_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
	}
	/*Revisa los permisos y segun el usuario entrega un tipo de menú*/
	public function _getmenu(){
		$controlador = explode('/', uri_string());		
		if(($controlador[0]!='solicitud' && $controlador[0]!='reporte' && $this->session->userdata('rol')==2) || //Coordinador de Departamento
		($controlador[0]!='solicitud' && $this->session->userdata('rol')==3)) //Estudiante
			redirect('/auth', 'refresh');
		
		$this->load->model('Rol_model','',TRUE);
		$rol_name = $this->Rol_model->get_item($this->session->userdata('rol'));
		$this->load->model('Coordinador_model','',TRUE);
		$coo_data = $this->Coordinador_model->get_item($this->session->userdata('login'), 'coo_login');
		$niv_id = @$coo_data[0]['niv_id'];
		$dep_id = @$coo_data[0]['dep_id'];
		$this->load->model('Nivel_model','',TRUE);
		
		$dep_ids = explode('*', $this->session->userdata('programas'));
		$programas = '';
		$this->load->library('integracion');
		
		$menu='';
		$data = array(
			'nombres'=>$this->session->userdata('nombres'),
			'apellidos'=>$this->session->userdata('apellidos'),
			'codigo'=>$this->session->userdata('UACarnetEstudiante'),
			//'programa'=>$programas,
			//'niveles'=>$niveles,
			'usuario'=>$this->session->userdata('login'),
			'rol_name'=>@$rol_name[0]['rol_descripcion'],
			'rol'=>$this->session->userdata('rol'),
			);
		if($this->session->userdata('logged_in')){
		//////////////////////////////////////////prueba solo para JMETER/////////////////////////////////////////////////////////////
		//if(TRUE){
			
				$menu = $this->load->view('_menu_normal',$data, true);
			
		}else{
			redirect('/auth');
			return false;
		}
		return $menu;
	}
}
?>