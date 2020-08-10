<?php
class Solicitud extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Solicitud_model','',TRUE);
		$this->load->helper('url');
		$this->load->library('form_validation');
        $this->load->library('Auth_Ldap');
		$this->load->library('session');
		$this->load->library('integracion');
		$this->load->library('email');
		date_default_timezone_set("America/Bogota");
		$this->load->model('Menu_model','',TRUE);
	}
	
	function index(){
		$menu = $this->Menu_model->_getmenu();		
		$this->load->model('Tipo_model','',TRUE);
		$options_tipo = $this->Tipo_model->get_dropdown();
		unset($this->Tipo_model);
		$this->load->model('Motivo_model','',TRUE);
		$options_motivo = $this->Motivo_model->get_dropdown();
		unset($this->Motivo_model);
		$data = array(
		'accion'=>'Crear',
		'sol_login'=>$this->session->userdata('login'),
		'sol_email'=>$this->session->userdata('login').'@uniandes.edu.co',
		'sol_nombre'=>$this->session->userdata('nombres'),
		'sol_apellido'=>$this->session->userdata('apellidos'),
		'sol_pidm'=>$this->session->userdata('pidm'),
		'options_tipo'=>$options_tipo,
		'options_motivo'=>$options_motivo,
		'titulo'=>'crear',
		'menu'=>$menu,
		);
		$this->load->view('solicitud_form', $data);
	}
	
	public function crear(){
		$menu = $this->Menu_model->_getmenu();
		$data = $_POST;	
		
		//$menu = $this->Menu_model->_getmenu();		
		$this->load->model('Tipo_model','',TRUE);
		$tipo = $this->Tipo_model->get_item($this->input->post('tip_id'));
		$options_tipo = $this->Tipo_model->get_dropdown();
		unset($this->Tipo_model);
		$this->load->model('Motivo_model','',TRUE);
		$motivo = $this->Motivo_model->get_item($this->input->post('mov_id'));
		$options_motivo = $this->Motivo_model->get_dropdown();
		unset($this->Motivo_model);
	
$data2 = array(
'accion'=>'Crear',
'sol_login'=>$this->session->userdata('login'),
'sol_email'=>$this->session->userdata('login').'@uniandes.edu.co',
'sol_nombre'=>$this->session->userdata('nombres'),
'sol_apellido'=>$this->session->userdata('apellidos'),
'sol_pidm'=>$this->session->userdata('pidm'),
'options_tipo'=>$options_tipo,
'options_motivo'=>$options_motivo,		
);
$data = array_merge($data, $data2);	
					  
		if($this->validar()){
			$this->enviarCorreo($data);
			$data3 = array(
				'mensaje' => 'Su solicitud se ha almacenado exitosamente',
				'titulo'=>'crear',
				'menu'=>$menu
				);
			$this->load->view('solicitud_form', $data3);
		}
		else{
			$data = array(
				'mensaje' => '',
				'titulo' => 'crear',
				'sol_id' => $this->input->post('sol_id'),
				'sol_descripcion' => $this->input->post('sol_descripcion'),                                      
				'tip_id' => $this->input->post('tip_id'),
				'mov_id' => $this->input->post('mov_id'),
				'sol_disp_crn_ret' => $this->input->post('sol_disp_crn_ret'),						
				'sol_disp_crn_ret_des' => $this->input->post('sol_disp_crn_ret_des'),
				'sol_disp_crn_ins' => $this->input->post('sol_disp_crn_ins'),					
				'sol_disp_crn_ins_des' => $this->input->post('sol_disp_crn_ins_des'),
				'options_tipo'=>$options_tipo,
				      'options_motivo'=>$options_motivo,
					  'menu'=>$menu,
			);
			$this->load->view('solicitud_form', $data);
			
		}
	}	
	public function validar(){
		$this->form_validation->set_rules('sol_login', 'Login', 'required');
		$this->form_validation->set_rules('sol_email', 'Email', 'required|valid_email');		
		$this->form_validation->set_rules('tip_id', 'Tipo', 'required');
		$this->form_validation->set_rules('mov_id', 'Motivo', 'required');
		$this->form_validation->set_rules('sol_disp_crn_ins', 'CRN Curso Inscripción', 'required');
		$this->form_validation->set_rules('sol_disp_crn_ins_des', 'Programa Curso Inscripción', 'required');
		$this->form_validation->set_rules('sol_descripcion', 'Descripción', 'max_length[300]');
		$this->form_validation->set_rules('sol_tyc', 'Acepta términos y condiciones', 'required');
		return $this->form_validation->run();
	}		
	
	public function enviarCorreo($data){
		$data['codigo'] = $this->session->userdata('UACarnetEstudiante')!='' ? $this->session->userdata('UACarnetEstudiante') : $this->session->userdata('uidNumber');
			
		$this->load->model('Tipo_model','Tipo_model_enviarCorreo',TRUE);
		$tipo = $this->Tipo_model_enviarCorreo->get_item($data['tip_id']);
		$tipo = utf8_decode($tipo[0]['tip_descripcion']);			
		unset($this->Tipo_model_enviarCorreo);
		$this->load->model('Motivo_model','Motivo_model_enviarCorreo',TRUE);
		$motivo = $this->Motivo_model_enviarCorreo->get_item($data['mov_id']);
		$motivo = utf8_decode($motivo[0]['mov_descripcion']);
		unset($this->Motivo_model_enviarCorreo);			
		
		$data['tipo'] = $tipo;
		$data['motivo'] = $motivo;
		$data['descripcion'] = utf8_decode($data['sol_descripcion']);

		
		$this->load->model('Parametro_model','Parametro_model_correo',TRUE);
		$correo_from = $this->Parametro_model_correo->get_item('correo_from','par_nombre');
		$nombre_from = $this->Parametro_model_correo->get_item('nombre_from','par_nombre');
		$this->email->from($correo_from[0]['par_valor'], $nombre_from[0]['par_valor']);
		
		//no envia en ambiente de pruebas
		$this->email->to(AMBIENTE_PRUEBAS=='1' ? CORREO_PRUEBAS.',amoncadaifactum@hotmail.com' : $data['sol_email'].',solicitudhorario@uniandes.edu.co');
		//$this->email->cc('solicitudhorario@uniandes.edu.co');
		$this->email->subject($data['sol_disp_crn_ins_des'].' - '.$data['sol_login'].' - '.$tipo);				
		
		$message2 = $this->load->view('solicitud_correo', $data, true);
		$this->email->message($message2);		
		$this->email->send();
		
		
		//echo $this->email->print_debugger();*/
	}
	
	public function condiciones(){
		$this->load->model('Parametro_model','Parametro_model_condiciones',TRUE);
		$condiciones = $this->Parametro_model_condiciones->get_item('condiciones','par_nombre');
		unset($this->Parametro_model);
		$condiciones = $condiciones[0]['par_valor'];
		$data = array('titulo' => 'T&eacute;rminos y condiciones', 'condiciones' => $condiciones);
		$this->load->view('solicitud_condiciones', $data);
	}
}