<?php

class Parametro extends CI_Controller
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
			
	function index(){
        $menu = $this->Menu_model->_getmenu();
		$periodo = $this->Parametro_model->get_item('periodo','par_nombre');
		$dperiodo = $this->Parametro_model->get_item('dperiodo','par_nombre');
		$suspensionesa = $this->Parametro_model->get_item('suspensiones academicas','par_nombre');
		$suspensionesd = $this->Parametro_model->get_item('suspensiones disciplinarias','par_nombre');
		$restricciones = $this->Parametro_model->get_item('restricciones','par_nombre');
		$niveles = $this->Parametro_model->get_item('niveles','par_nombre');
		$galpon = $this->Parametro_model->get_item('turno de galpon','par_nombre');
		$correo_from = $this->Parametro_model->get_item('correo_from','par_nombre');
		$nombre_from = $this->Parametro_model->get_item('nombre_from','par_nombre');
		$link_coordinadores = $this->Parametro_model->get_item('link_coordinadores','par_nombre');
		$condiciones = $this->Parametro_model->get_item('condiciones','par_nombre');
		$comentario_normal = $this->Parametro_model->get_item('comentario normal','par_nombre');
		$comentario_cancelar = $this->Parametro_model->get_item('comentario cancelar','par_nombre');
		$comentario_cambiar_estado = $this->Parametro_model->get_item('comentario cambiar estado','par_nombre');
		$fecha_final = $this->Parametro_model->get_item('fecha final','par_nombre');
		$fecha_inicial = $this->Parametro_model->get_item('fecha inicial','par_nombre');
		
		$data = array('titulo' => 'ADMINISTRADOR DE PAR&Aacute;METROS',
			      'menu'=>$menu,
			      'periodo'=>$periodo[0]['par_valor'],
			      'dperiodo'=>@$dperiodo[0]['par_valor'],
			      'suspensionesa'=>$suspensionesa[0]['par_valor'],
			      'suspensionesd'=>$suspensionesd[0]['par_valor'],
			      'restricciones'=>$restricciones[0]['par_valor'],
			      'niveles'=>$niveles[0]['par_valor'],
			      'galpon'=>$galpon[0]['par_valor'],			      
				  'correo_from'=>$correo_from[0]['par_valor'],
				  'nombre_from'=>$nombre_from[0]['par_valor'],
				  'link_coordinadores'=>$link_coordinadores[0]['par_valor'],
				  'condiciones'=>$condiciones[0]['par_valor'],
				'comentario_normal'=>$comentario_normal[0]['par_valor'],
				'comentario_cancelar'=>$comentario_cancelar[0]['par_valor'],
				'comentario_cambiar_estado'=>$comentario_cambiar_estado[0]['par_valor'],
				'fecha_final'=>/*substr($fecha_final[0]['par_valor'], 0, -3),*/$fecha_final[0]['par_valor'],
				'fecha_inicial'=>/*substr($fecha_final[0]['par_valor'], 0, -3),*/$fecha_inicial[0]['par_valor'],
				  'mensaje'=>'',
			      );		
		$this->load->view('parametro_form', $data);
	}
	
	private function _getmenu(){
		$this->load->model('Rol_model','',TRUE);
		$rol_name = $this->Rol_model->get_item($this->session->userdata('rol'));
		$this->load->model('Coordinador_model','',TRUE);
		$coo_data = $this->Coordinador_model->get_item($this->session->userdata('login'), 'coo_login');
		$niv_id = @$coo_data[0]['niv_id'];
		$dep_id = @$coo_data[0]['dep_id'];
		$this->load->model('Nivel_model','',TRUE);
		$niv_descripcion = $this->Nivel_model->get_item($niv_id);		
		
		$dep_ids = explode('*', $this->session->userdata('programas'));
		$programas = '';
		$this->load->library('integracion');
		if(is_array($dep_ids)){
			foreach($dep_ids as $dep_id){
				$dep_descripcion = $this->integracion->obtenerPrograma($dep_id);
				if(@$dep_descripcion!=''){
					$programas .= $programas!='' ? '-' : '';
					$programas .= @$dep_descripcion;
				}
			}
		}
		else {
			$dep_descripcion = $this->integracion->obtenerPrograma($dep_ids);
			$programas = @$dep_descripcion;
		}			
		$menu='';
		$data = array(
			'nombres'=>$this->session->userdata('nombres'),
			'apellidos'=>$this->session->userdata('apellidos'),
			'codigo'=>$this->session->userdata('UACarnetEstudiante'),
			'programa'=>$programas,
			'niveles'=>@$niv_descripcion[0]['niv_descripcion'],
			'usuario'=>$this->session->userdata('login'),
			'rol_name'=>@$rol_name[0]['rol_descripcion']
			);
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('rol')==1){
				$menu = $this->load->view('_menu_admin',$data, true);
			}else{
				redirect('/auth');
			}
		}else{
			redirect('/auth');
			return false;
		}
		return $menu;
	}
	
	public function actualizar(){
		$menu = $this->Menu_model->_getmenu();
		$mensaje = '';
		if($this->validar()) {
			$datos = array('par_valor' => implode(",",$this->input->post('periodo')));
			$mensaje = $this->Parametro_model->update('periodo',$datos,'par_nombre') ? 'Se ha actualizado  con \u00e9xito' : 'No se pudo actualizar';
			$datos = array('par_valor' => implode(":=:",$this->input->post('dperiodo')));
			$mensaje = $this->Parametro_model->update('dperiodo',$datos,'par_nombre') ? 'Se ha actualizado  con \u00e9xito' : 'No se pudo actualizar';
			$datos = array('par_valor' => $this->input->post('suspensionesa'));
			$mensaje = $this->Parametro_model->update('suspensiones academicas',$datos,'par_nombre') ? 'Se ha actualizado  con \u00e9xito' : 'No se pudo actualizar';
			$datos = array('par_valor' => $this->input->post('suspensionesd'));
			$mensaje = $this->Parametro_model->update('suspensiones disciplinarias',$datos,'par_nombre') ? 'Se ha actualizado  con \u00e9xito' : 'No se pudo actualizar';
			$datos = array('par_valor' => $this->input->post('restricciones'));
			$mensaje = $this->Parametro_model->update('restricciones',$datos,'par_nombre') ? 'Se ha actualizado  con \u00e9xito' : 'No se pudo actualizar';
			$datos = array('par_valor' => $this->input->post('niveles'));
			$mensaje = $this->Parametro_model->update('niveles',$datos,'par_nombre') ? 'Se ha actualizado  con \u00e9xito' : 'No se pudo actualizar';
			$datos = array('par_valor' => $this->input->post('galpon'));
			$mensaje = $this->Parametro_model->update('turno de galpon',$datos,'par_nombre') ? 'Se ha actualizado  con \u00e9xito' : 'No se pudo actualizar';			
			$datos = array('par_valor' => $this->input->post('correo_from'));
			$mensaje = $this->Parametro_model->update('correo_from',$datos,'par_nombre') ? 'Se ha actualizado  con \u00e9xito' : 'No se pudo actualizar';
			$datos = array('par_valor' => $this->input->post('nombre_from'));
			$mensaje = $this->Parametro_model->update('nombre_from',$datos,'par_nombre') ? 'Se ha actualizado  con \u00e9xito' : 'No se pudo actualizar';
			$datos = array('par_valor' => $this->input->post('link_coordinadores'));
			$mensaje = $this->Parametro_model->update('link_coordinadores',$datos,'par_nombre') ? 'Se ha actualizado  con \u00e9xito' : 'No se pudo actualizar';
			$datos = array('par_valor' => $this->input->post('condiciones'));
			$mensaje = $this->Parametro_model->update('condiciones',$datos,'par_nombre') ? 'Se ha actualizado  con \u00e9xito' : 'No se pudo actualizar';
			$datos = array('par_valor' => $this->input->post('comentario_normal'));
			$mensaje = $this->Parametro_model->update('comentario normal',$datos,'par_nombre') ? 'Se ha actualizado  con \u00e9xito' : 'No se pudo actualizar';
			$datos = array('par_valor' => $this->input->post('comentario_cancelar'));
			$mensaje = $this->Parametro_model->update('comentario cancelar',$datos,'par_nombre') ? 'Se ha actualizado  con \u00e9xito' : 'No se pudo actualizar';
			$datos = array('par_valor' => $this->input->post('comentario_cambiar_estado'));
			$mensaje = $this->Parametro_model->update('comentario cambiar estado',$datos,'par_nombre') ? 'Se ha actualizado  con \u00e9xito' : 'No se pudo actualizar';
			$datos = array('par_valor' => $this->input->post('fecha_final'));
			$mensaje = $this->Parametro_model->update('fecha final',$datos,'par_nombre') ? 'Se ha actualizado  con \u00e9xito' : 'No se pudo actualizar';
			$datos = array('par_valor' => $this->input->post('fecha_inicial'));
			$mensaje = $this->Parametro_model->update('fecha inicial',$datos,'par_nombre') ? 'Se ha actualizado  con \u00e9xito' : 'No se pudo actualizar';
			
			$periodo = $this->Parametro_model->get_item('periodo','par_nombre');
			$dperiodo = $this->Parametro_model->get_item('dperiodo','par_nombre');
			$suspensionesa = $this->Parametro_model->get_item('suspensiones academicas','par_nombre');
			$suspensionesd = $this->Parametro_model->get_item('suspensiones disciplinarias','par_nombre');
			$restricciones = $this->Parametro_model->get_item('restricciones','par_nombre');
			$niveles = $this->Parametro_model->get_item('niveles','par_nombre');
			$galpon = $this->Parametro_model->get_item('turno de galpon','par_nombre');
			$correo_from = $this->Parametro_model->get_item('correo_from','par_nombre');
			$nombre_from = $this->Parametro_model->get_item('nombre_from','par_nombre');
			$link_coordinadores = $this->Parametro_model->get_item('link_coordinadores','par_nombre');
			$condiciones = $this->Parametro_model->get_item('condiciones','par_nombre');
			$comentario_normal = $this->Parametro_model->get_item('comentario normal','par_nombre');
			$comentario_cancelar = $this->Parametro_model->get_item('comentario cancelar','par_nombre');
			$comentario_cambiar_estado = $this->Parametro_model->get_item('comentario cambiar estado','par_nombre');
			$fecha_final = $this->Parametro_model->get_item('fecha final','par_nombre');
			$fecha_inicial = $this->Parametro_model->get_item('fecha inicial','par_nombre');
			
			$data = array('titulo' => 'ADMINISTRADOR DE PAR&Aacute;METROS',
					  'menu'=>$menu,
					  'periodo'=>$periodo[0]['par_valor'],
					  'dperiodo'=>$dperiodo[0]['par_valor'],
					  'suspensionesa'=>$suspensionesa[0]['par_valor'],
					  'suspensionesd'=>$suspensionesd[0]['par_valor'],
					  'restricciones'=>$restricciones[0]['par_valor'],
					  'niveles'=>$niveles[0]['par_valor'],
					  'galpon'=>$galpon[0]['par_valor'],			      
					  'correo_from'=>$correo_from[0]['par_valor'],
					  'nombre_from'=>$nombre_from[0]['par_valor'],
					  'link_coordinadores'=>$link_coordinadores[0]['par_valor'],
					  'condiciones'=>$condiciones[0]['par_valor'],
					  'comentario_normal'=>$comentario_normal[0]['par_valor'],
					  'comentario_cancelar'=>$comentario_cancelar[0]['par_valor'],
					  'comentario_cambiar_estado'=>$comentario_cambiar_estado[0]['par_valor'],
					  'fecha_final'=>/*substr($fecha_final[0]['par_valor'], 0, -3),*/$fecha_final[0]['par_valor'],
					  'fecha_inicial'=>/*substr($fecha_final[0]['par_valor'], 0, -3),*/$fecha_inicial[0]['par_valor'],
					  'mensaje'=>$mensaje,					  
					  );
		}
		else {			
			$data = array('titulo' => 'ADMINISTRADOR DE PAR&Aacute;METROS',
					  'menu'=>$menu,
					  'periodo'=>$this->input->post('periodo'),
					  'suspensionesa'=>$this->input->post('suspensionesa'),
					  'suspensionesd'=>$this->input->post('suspensionesd'),
					  'restricciones'=>$this->input->post('restricciones'),
					  'niveles'=>$this->input->post('niveles'),
					  'galpon'=>$this->input->post('galpon'),					  
					  'correo_from'=>$this->input->post('correo_from'),
					  'nombre_from'=>$this->input->post('nombre_from'),
					  'link_coordinadores'=>$this->input->post('link_coordinadores'),
					  'condiciones'=>$this->input->post('condiciones'),
					  'comentario_normal'=>$this->input->post('comentario_normal'),
					  'comentario_cancelar'=>$this->input->post('comentario_cancelar'),
					  'comentario_cambiar_estado'=>$this->input->post('comentario_cambiar_estado'),
					  'fecha_final'=>$this->input->post('fecha_final'),
					  'fecha_inicial'=>$this->input->post('fecha_inicial'),
					  'mensaje'=>$mensaje,
					  );
		}		
		$this->load->view('parametro_form', $data);		
	}
	
	public function validar()
	{
		$this->form_validation->set_rules('periodo', 'Periodo', 'required');
		$this->form_validation->set_rules('correo_from', 'Correo', 'required|valid_email');
		$this->form_validation->set_rules('nombre_from', 'Nombre', 'required');
		$this->form_validation->set_rules('condiciones', 'Términos y condiciones', 'required');
		$this->form_validation->set_rules('comentario_normal', 'Comentario estándar', 'max_length[300]');
		$this->form_validation->set_rules('comentario_cancelar', 'Comentario estándar (cancelar)', 'max_length[300]');
		$this->form_validation->set_rules('comentario_cambiar_estado', 'Comentario estándar (cambiar estado)', 'max_length[300]');
		//$this->form_validation->set_rules('fecha_final', 'Fecha final', 'required');
		return $this->form_validation->run();
	}	
	
}
