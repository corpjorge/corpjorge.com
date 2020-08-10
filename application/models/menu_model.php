<?php
class Menu_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
	}
	/*Revisa los permisos y segun el usuario entrega un tipo de menú*/
	public function _getmenu(){
		$controlador = explode('/', uri_string());		
		if(($controlador[0]!='solicitud' && $controlador[0]!='reporte' && $controlador[0]!='bloqueo' && $controlador[0]!='mensajes' && $controlador[0]!='comentarios' && $this->session->userdata('rol')==2) || //Coordinador de Departamento
		($controlador[0]!='solicitud' && $this->session->userdata('rol')==3)) //Estudiante
			redirect('/auth', 'refresh');
		
		$this->load->model('Rol_model','',TRUE);
		$this->load->model('Limite_model','',TRUE);
		$rol_name = $this->Rol_model->get_item($this->session->userdata('rol'));
		$this->load->model('Coordinador_model','',TRUE);
		$coo_data = $this->Coordinador_model->get_item($this->session->userdata('login'), 'coo_login');
		$niv_id = @$coo_data[0]['niv_id'];
		$dep_id = @$coo_data[0]['dep_id'];
		$this->load->model('Nivel_model','',TRUE);
		
		$dep_ids = explode('*', $this->session->userdata('programas'));
		$programas = '';
		$this->load->library('integracion');
		if(is_array($dep_ids)){
			foreach($dep_ids as $dep_id){
				$dep_descripcion = $this->integracion->obtenerPrograma($dep_id);
				if(@$dep_descripcion!=''){
					$programas .= $programas!='' ? ' | ' : '';
					$programas .= @$dep_descripcion;
				}
			}
		}
		else {
			$dep_descripcion = $this->integracion->obtenerPrograma($dep_ids);
			$programas = @$dep_descripcion;
		}
		$bloqueo = "1";
		foreach($dep_ids as $d){
			$_d = $this->Limite_model->get_item($d, "dep_id");
			if(@$_d[0]["sol_creacion"]=="0"){
				$bloqueo = "0";
				break;
			}
		// echo "<pre>";
		// print_r($_d);
		// echo "<pre/>";
		}
		$niv_ids = explode('*', $this->session->userdata('niveles'));
		$niveles = '';
		if(is_array($niv_ids)){
			foreach($niv_ids as $niv_id){
				$niv_descripcion = $this->Nivel_model->get_item($niv_id);
				$niv_descripcion = @$niv_descripcion[0]['niv_descripcion'];
				if(@$niv_descripcion!=''){
					$niveles .= $niveles!='' ? ' | ' : '';
					$niveles .= @$niv_descripcion;
				}
			}
		}
		else {
			$niv_descripcion = $this->Nivel_model->get_item($niv_id);
			$niv_descripcion = @$niv_descripcion[0]['niv_descripcion'];
			$niveles .= @$niv_descripcion;
		}
		
		$menu='';
		$data = array(
			'nombres'=>$this->session->userdata('nombres'),
			'apellidos'=>$this->session->userdata('apellidos'),
			'codigo'=>$this->session->userdata('UACarnetEstudiante'),
			'programa'=>$programas,
			'niveles'=>$niveles,
			'usuario'=>$this->session->userdata('login'),
			'rol_name'=>@$rol_name[0]['rol_descripcion'],
			'rol'=>$this->session->userdata('rol'),
			'bloqueo_crn'=>$bloqueo,
			);
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('rol')==1){
				$menu = $this->load->view('_menu_admin',$data, true);
			}else{
				$menu = $this->load->view('_menu_normal',$data, true);
			}
		}else{
			redirect('/auth');
			return false;
		}
		return $menu;
	}
}
?>