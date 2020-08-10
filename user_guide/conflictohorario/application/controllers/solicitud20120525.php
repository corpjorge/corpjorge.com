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
		$data = array('titulo' => 'ADMINISTRADOR DE SOLICITUDES','menu'=>$menu);
		
		$data['otro'] = 'n';
		if(!$this->session->userdata('cantpag')){
			$datos_sesion = array('cantpag'=>20);
			$this->session->set_userdata($datos_sesion);
		}
		if(!$this->session->userdata('numpag')){
			$datos_sesion = array('numpag'=>1);
			$this->session->set_userdata($datos_sesion);
		}else{			
			$data['otro'] = 's';
		}
				
		
		
		//$this->_prepare_list($data);
		if($this->session->userdata('rol')==3){
			$this->load->view('solicitud_listado', $data);	
		}else{
			//var_dump($this->session->userdata('numpag'));
			$columnas = $this->session->userdata('colocultas');
			if($columnas){
				$data['ocultas'] = explode(';',$columnas);
			}else{
				$data['ocultas'] = array();
			}
			$data['rp'] = $this->session->userdata('cantpag');
			
			$data['ordencol'] = $this->session->userdata('ordencol');
			$data['ordencol_label'] = $this->session->userdata('ordencol_label');
			$data['ordencol_width'] = $this->session->userdata('ordencol_width');
			$data['sortname'] = $this->session->userdata('sortname');
			$data['sortorder'] = $this->session->userdata('sortorder');
		
			$data['qtype'] = $this->session->userdata('qtype');
			$data['query'] = $this->session->userdata('query');
			$data['qtype2'] = $this->session->userdata('qtype2');
			$data['query2'] = $this->session->userdata('query2');
			//print_r($data);
			$this->load->view('solicitud_listado_admin', $data);				
		}
		
		
	}		
	public function crearadm(){
		$menu = $this->Menu_model->_getmenu();	
		$data = array('titulo' => 'Crear',
					'accion' => 'crear',
					'menu' => $menu
					);
		$this->load->view('solicitud_form_admin', $data);
	}
	public function crear($no_validar=''){ //para usuarios no estudiantes la primera vez no debe validar
		$menu = $this->Menu_model->_getmenu();		
		$this->load->model('Tipo_model','',TRUE);
		$options_tipo = $this->Tipo_model->get_dropdown();
		unset($this->Tipo_model);
		$this->load->model('Motivo_model','',TRUE);
		$options_motivo = $this->Motivo_model->get_dropdown();
		unset($this->Motivo_model);
		
		if($no_validar=='')
			$validacion = $this->validar();
		else
			$validacion = false;
		
		if($validacion){			
			//si tipo es Inscribir Materia en los campos ins se guarda el valor de los post ret
			$sol_ins_crn = $this->input->post('tip_id')!='1' ? $this->input->post('sol_disp_crn_ins') : $this->input->post('sol_disp_crn_ret');
			$sol_ret_crn = $this->input->post('tip_id')!='1' ? $this->input->post('sol_disp_crn_ret') : '';
			$sol_ins_des = $this->input->post('tip_id')!='1' ? $this->input->post('sol_disp_crn_ins_des') : $this->input->post('sol_disp_crn_ret_des');
			$sol_ret_des = $this->input->post('tip_id')!='1' ? $this->input->post('sol_disp_crn_ret_des') : '';
			$sol_ins_mat = $this->input->post('tip_id')!='1' ? $this->input->post('sol_disp_crn_ins_materia') : $this->input->post('sol_disp_crn_ret_materia');
			$sol_ret_mat = $this->input->post('tip_id')!='1' ? $this->input->post('sol_disp_crn_ret_materia') : '';
			$sol_sug_ins_crn = $this->input->post('tip_id')!='1' ? $this->input->post('sol_sug_crn_ins') : $this->input->post('sol_sug_crn_ret');
			$sol_sug_ret_crn = $this->input->post('tip_id')!='1' ? $this->input->post('sol_sug_crn_ret') : '';
			$sol_sug_ins_des = $this->input->post('tip_id')!='1' ? $this->input->post('sol_sug_crn_ins_des') : $this->input->post('sol_sug_crn_ret_des');
			$sol_sug_ret_des = $this->input->post('tip_id')!='1' ? $this->input->post('sol_sug_crn_ret_des') : '';
			$sol_sug_ins_mat = $this->input->post('tip_id')!='1' ? $this->input->post('sol_sug_crn_ins_materia') : $this->input->post('sol_sug_crn_ret_materia');
			$sol_sug_ret_mat = $this->input->post('tip_id')!='1' ? $this->input->post('sol_sug_crn_ret_materia') : '';
			
			$sol_ins_seccion = $this->input->post('tip_id')!='1' ? $this->input->post('sol_disp_crn_ins_seccion') : $this->input->post('sol_disp_crn_ret_seccion');
			$sol_ins_instructor = $this->input->post('tip_id')!='1' ? $this->input->post('sol_disp_crn_ins_instructor') : $this->input->post('sol_disp_crn_ret_instructor');
			$sol_ins_tipo = $this->input->post('tip_id')!='1' ? $this->input->post('sol_disp_crn_ins_tipo') : $this->input->post('sol_disp_crn_ret_tipo');
			
			$sol_ret_seccion = $this->input->post('tip_id')!='1' ? $this->input->post('sol_disp_crn_ret_seccion') : '';
			$sol_ret_instructor = $this->input->post('tip_id')!='1' ? $this->input->post('sol_disp_crn_ret_instructor') : '';
			$sol_ret_tipo = $this->input->post('tip_id')!='1' ? $this->input->post('sol_disp_crn_ret_tipo') : '';
			
			$sol_sug_ins_seccion = $this->input->post('tip_id')!='1' ? $this->input->post('sol_sug_crn_ins_seccion') : $this->input->post('sol_sug_crn_ret_seccion');
			$sol_sug_ins_instructor = $this->input->post('tip_id')!='1' ? $this->input->post('sol_sug_crn_ins_instructor') : $this->input->post('sol_sug_crn_ret_instructor');
			$sol_sug_ins_tipo = $this->input->post('tip_id')!='1' ? $this->input->post('sol_sug_crn_ins_tipo') : $this->input->post('sol_sug_crn_ret_tipo');
			
			$sol_sug_ret_seccion = $this->input->post('tip_id')!='1' ? $this->input->post('sol_sug_crn_ret_seccion') : '';
			$sol_sug_ret_instructor = $this->input->post('tip_id')!='1' ? $this->input->post('sol_sug_crn_ret_instructor') : '';
			$sol_sug_ret_tipo = $this->input->post('tip_id')!='1' ? $this->input->post('sol_sug_crn_ret_tipo') : '';
			
			
			$prog = substr($sol_ins_mat,0,4);			
			if(!$this->_validar_crear($prog)){			
				redirect('solicitud/mensaje/1');
			}
			
			/*obtengo el nivel de la materia de inscripcion*/
			$nivel_ins_mat = substr($sol_ins_mat,4,1);
			$sol_uidnumber = $this->session->userdata('UACarnetEstudiante')!='' ? $this->session->userdata('UACarnetEstudiante') : $this->session->userdata('uidNumber');
			
			$datos = array('sol_descripcion' => $this->input->post('sol_descripcion'),
						'sol_nivel'=>$nivel_ins_mat,
						'tip_id' => $this->input->post('tip_id'),
						'mov_id' => $this->input->post('mov_id'),
						'sol_login'=>$this->session->userdata('login'),
						'sol_ip'=>$this->session->userdata('ip_address'),
						'sol_fec_creacion'=>date("Y-m-d h:i:s"),
						'sol_ticket'=>time().'-'.$this->session->userdata('programas'),
						'dep_id'=>$prog,/*$this->session->userdata('programas'),*/
						'dep_id_sec'=>$this->session->userdata('programa_sec'),
						'sol_email'=>$this->session->userdata('login').'@uniandes.edu.co',
						'sol_nombre'=>$this->session->userdata('nombres'),
						'sol_apellido'=>$this->session->userdata('apellidos'),
						'sol_pidm'=>$this->session->userdata('pidm'),
						'sol_uidnumber'=>$sol_uidnumber,
						'sol_ins_crn' => trim($sol_ins_crn),
						'sol_ret_crn' => trim($sol_ret_crn),
						'sol_ins_des' => trim($sol_ins_des),
						'sol_ret_des' => trim($sol_ret_des),
						'sol_ins_mat' => trim($sol_ins_mat),
						'sol_ret_mat' => trim($sol_ret_mat),
						'sol_sug_ins_crn' => trim($sol_sug_ins_crn),
						'sol_sug_ret_crn' => trim($sol_sug_ret_crn),
						'sol_sug_ins_des' => trim($sol_sug_ins_des),
						'sol_sug_ret_des' => trim($sol_sug_ret_des),
						'sol_sug_ins_mat' => trim($sol_sug_ins_mat),
						'sol_sug_ret_mat' => trim($sol_sug_ret_mat),
						
						'sol_ins_seccion' => trim($sol_ins_seccion),
						'sol_ins_instructor' => trim($sol_ins_instructor),
						'sol_ins_tipo' => trim($sol_ins_tipo),
						'sol_ret_seccion' => trim($sol_ret_seccion),
						'sol_ret_instructor' => trim($sol_ret_instructor),
						'sol_ret_tipo' => trim($sol_ret_tipo),
						'sol_sug_ins_seccion' => trim($sol_sug_ins_seccion),
						'sol_sug_ins_instructor' => trim($sol_sug_ins_instructor),
						'sol_sug_ins_tipo' => trim($sol_sug_ins_tipo),
						'sol_sug_ret_seccion' => trim($sol_sug_ret_seccion),
						'sol_sug_ret_instructor' => trim($sol_sug_ret_instructor),
						'sol_sug_ret_tipo' => trim($sol_sug_ret_tipo),
						);				
			if($this->session->userdata('rol')!=3){ //si no es estudiante obtiene los datos del formulario y no de la sesion
				//$datos['dep_id'] = $this->input->post('dep_id');
				//$datos['dep_id_sec'] = $this->input->post('dep_id_sec');
				$datos['sol_email'] = $this->input->post('sol_email');
				$datos['sol_login'] = $this->input->post('sol_login');
				$datos['sol_nombre'] = $this->input->post('sol_nombre');
				$datos['sol_apellido'] = $this->input->post('sol_apellido');
				$datos['sol_uidnumber'] = $this->input->post('sol_uidnumber');
				$datos['sol_pidm'] = $this->input->post('sol_pidm');
				$datos['sol_ticket'] .= '-C'; //indica que fue creada por un coordinador
			}		   
			$this->Solicitud_model->insert($datos);
			$this->enviarCorreo('crear', $datos['sol_email'], 'Creación solicitud', $this->Solicitud_model->insert_id());
			
			/*if($this->session->userdata('rol')!=3){ //si no es estudiante destruye el pidm en la sesion
				$dato_sesion = array('pidm' => '');
				$this->session->unset_userdata($dato_sesion);
			}*/
			$data = array('titulo' => 'ADMINISTRADOR DE Solicitudes','mensaje'=>'Su solicitud de conflicto de Horario se ha enviado con \u00e9xito','menu'=>$menu);
			
			if($this->session->userdata('rol')!=3)
				//echo $data['mensaje'];
				echo 'OK';
			else
			$this->load->view('solicitud_listado', $data);
		}else{
			$data = array('sol_id' => $this->input->post('sol_id'),
				      'sol_descripcion' => $this->input->post('sol_descripcion'),                                      
				      'tip_id' => $this->input->post('tip_id'),
				      'mov_id' => $this->input->post('mov_id'),
				      'accion'=>'crear',
				      'mensaje'=>'Su solicitud de conflicto de Horario se ha enviado con \u00e9xito',
				      'titulo' => 'Crear',
				      'options_tipo'=>$options_tipo,
				      'options_motivo'=>$options_motivo,
					'pidm'=>$this->session->userdata('pidm'),
					'sol_pidm'=>$this->session->userdata('pidm'),
					'rol'=>$this->session->userdata('rol'),
					'menu'=>$menu,
					'sol_disp_crn_ret' => $this->input->post('sol_disp_crn_ret'),						
					'sol_disp_crn_ret_tipo' => $this->input->post('sol_disp_crn_ret_tipo'),
					'sol_disp_crn_ret_des' => $this->input->post('sol_disp_crn_ret_des'),
					'sol_disp_crn_ret_materia' => $this->input->post('sol_disp_crn_ret_materia'),
					'sol_disp_crn_ret_instructor' => $this->input->post('sol_disp_crn_ret_instructor'),
					'sol_disp_crn_ret_seccion' => $this->input->post('sol_disp_crn_ret_seccion'),
					
					'sol_disp_crn_ins' => $this->input->post('sol_disp_crn_ins'),
					'sol_disp_crn_ins_tipo' => $this->input->post('sol_disp_crn_ins_tipo'),
					'sol_disp_crn_ins_des' => $this->input->post('sol_disp_crn_ins_des'),
					'sol_disp_crn_ins_materia' => $this->input->post('sol_disp_crn_ins_materia'),
					'sol_disp_crn_ins_instructor' => $this->input->post('sol_disp_crn_ins_instructor'),
					'sol_disp_crn_ins_seccion' => $this->input->post('sol_disp_crn_ins_seccion'),						
					
					'sol_sug_crn_ret' => $this->input->post('sol_sug_crn_ret'),
					'sol_sug_crn_ret_tipo' => $this->input->post('sol_sug_crn_ret_tipo'),
					'sol_sug_crn_ret_des' => $this->input->post('sol_sug_crn_ret_des'),
					'sol_sug_crn_ret_materia' => $this->input->post('sol_sug_crn_ret_materia'),
					'sol_sug_crn_ret_instructor' => $this->input->post('sol_sug_crn_ret_instructor'),
					'sol_sug_crn_ret_seccion' => $this->input->post('sol_sug_crn_ret_seccion'),						
					
					'sol_sug_crn_ins' => $this->input->post('sol_sug_crn_ins'),
					'sol_sug_crn_ins_tipo' => $this->input->post('sol_sug_crn_ins_tipo'),
					'sol_sug_crn_ins_des' => $this->input->post('sol_sug_crn_ins_des'),
					'sol_sug_crn_ins_materia' => $this->input->post('sol_sug_crn_ins_materia'),
					'sol_sug_crn_ins_instructor' => $this->input->post('sol_sug_crn_ins_instructor'),
					'sol_sug_crn_ins_seccion' => $this->input->post('sol_sug_crn_ins_seccion'),						
					
					'sol_sug_crn_ins' => $this->input->post('sol_sug_crn_ins')
				);
			if($this->session->userdata('rol')!=3){ //si no es estudiante obtiene los datos del formulario y no de la sesion
				$data['dep_id'] = $this->input->post('dep_id');
				$data['dep_id_sec'] = $this->input->post('dep_id_sec');
				$data['sol_email'] = $this->input->post('sol_email');
				$data['sol_login'] = $this->input->post('sol_login');
				$data['sol_nombre'] = $this->input->post('sol_nombre');
				$data['sol_apellido'] = $this->input->post('sol_apellido');
				$data['sol_uidnumber'] = $this->input->post('sol_uidnumber');
				$data['sol_pidm'] = $this->input->post('sol_pidm');
				$data['sol_nivel'] = $this->input->post('sol_nivel');					
			}
			$this->load->view('solicitud_form', $data);
			//echo 'NO';
		}		
	}					
	
	
	public function actualizar($id){
		$menu = $this->Menu_model->_getmenu();
		$this->load->model('Tipo_model','',TRUE);
		$options_tipo = $this->Tipo_model->get_dropdown();
		$this->load->model('Motivo_model','',TRUE);
		$options_motivo = $this->Motivo_model->get_dropdown();
		$this->load->model('Estado_model','',TRUE);				
				
		if($this->validar()) {
			$datos = array('sol_descripcion' => $this->input->post('sol_descripcion'),
				       'tip_id' => $this->input->post('tip_id'),
				       'mov_id' => $this->input->post('mov_id'),
				       'sol_fec_actualizacion'=>date("Y-m-d h:i:s"),
				       'sol_mag_crn_ret_des' => $this->input->post('sol_mag_crn_ret_des'),
				       'sol_mag_crn_ret' => $this->input->post('sol_mag_crn_ret'),
				       'sol_mag_crn_ins_des' => $this->input->post('sol_mag_crn_ins_des'),
				       'sol_mag_crn_ins' => $this->input->post('sol_mag_crn_ins'),
				       'sol_com_crn_ret_des' => $this->input->post('sol_com_crn_ret_des'),
				       'sol_com_crn_ret' => $this->input->post('sol_com_crn_ret'),
				       'sol_com_crn_ins_des' => $this->input->post('sol_com_crn_ins_des'),
				       'sol_com_crn_ins' => $this->input->post('sol_com_crn_ins'),
					   'sol_fec_actualizacion' => date("Y-m-d H:i:s")
				      );
			$this->Solicitud_model->update($id,$datos);
			$data = array('titulo' => 'ADMINISTRADOR DE SOLICITUDES','mensaje'=>'Se ha actualizado con \u00e9xito','menu'=>$menu);
			//$this->_prepare_list($data);
			$this->load->view('solicitud_listado', $data);
		}	
		else {
			$item = $this->Solicitud_model->get_item($id);
			//obtengo los comentarios si los hay
			$this->load->model('Comentario_model','',TRUE);
			$comentario = $this->Comentario_model->get_item($id,'sol_id');
			$this->_prepare_list_comentario($datac, $id, $this->Comentario_model);
			$comentario_listado = $this->load->view('comentario_listado', $datac, true);			
		        unset($this->Comentario_model);
			
			$data_comentario = array('sol_id'=>$id,
					'com_texto'=>@$comentario[0]['com_texto'],
					'com_nombre'=>$this->session->userdata('nombres'),
					'rol_id'=>$this->session->userdata('rol')
					);

			$comentario_form = $this->load->view('comentario_form',$data_comentario, true);
			
			$rol_login='coordinador'; //PRUEBA
			if((($item[0]['est_id']=='1' || $item[0]['est_id']=='5') && $rol_login=='coordinador') || //en revisión o En espera de respuesta del coordinador
			(($item[0]['est_id']=='4') && $rol_login=='estudiante'))//En espera de respuesta del estudiante
				$puede_comentar = true;
			else
				$puede_comentar = false;			
			
			$sol_ins_tipo = ($item[0]['sol_ins_tipo']=='mag' || $item[0]['sol_ins_tipo']=='com') ? $item[0]['sol_ins_tipo'] : 'NORMAL';
			if($sol_ins_tipo!='NORMAL')
				$sol_ins_tipo = ($item[0]['sol_ins_tipo']=='mag') ? 'MAGISTRAL' : 'COMPLEMENTARIA';
			else
				$sol_ins_tipo = $item[0]['sol_ins_crn']!='' ? $sol_ins_tipo : '';
			$sol_ret_tipo = ($item[0]['sol_ret_tipo']=='mag' || $item[0]['sol_ret_tipo']=='com') ? $item[0]['sol_ret_tipo'] : 'NORMAL';
			if($sol_ret_tipo!='NORMAL')
				$sol_ret_tipo = ($item[0]['sol_ret_tipo']=='mag') ? 'MAGISTRAL' : 'COMPLEMENTARIA';
			else
				$sol_ret_tipo = $item[0]['sol_ret_crn']!='' ? $sol_ret_tipo : '';
			$sol_sug_ins_tipo = ($item[0]['sol_sug_ins_tipo']=='mag' || $item[0]['sol_sug_ins_tipo']=='com') ? $item[0]['sol_sug_ins_tipo'] : 'NORMAL';
			if($sol_sug_ins_tipo!='NORMAL')
				$sol_sug_ins_tipo = ($item[0]['sol_sug_ins_tipo']=='mag') ? 'MAGISTRAL' : 'COMPLEMENTARIA';
			else
				$sol_sug_ins_tipo = $item[0]['sol_sug_ins_crn']!='' ? $sol_sug_ins_tipo : '';
			$sol_sug_ret_tipo = ($item[0]['sol_sug_ret_tipo']=='mag' || $item[0]['sol_sug_ret_tipo']=='com') ? $item[0]['sol_sug_ret_tipo'] : 'NORMAL';
			if($sol_sug_ret_tipo!='NORMAL')
				$sol_sug_ret_tipo = ($item[0]['sol_sug_ret_tipo']=='mag') ? 'MAGISTRAL' : 'COMPLEMENTARIA';
			else
				$sol_sug_ret_tipo = $item[0]['sol_sug_ret_crn']!='' ? $sol_sug_ret_tipo : '';
			$item[0]['sol_ins_tipo'] = $sol_ins_tipo;
			$item[0]['sol_ret_tipo'] = $sol_ret_tipo;
			$item[0]['sol_sug_ins_tipo'] = $sol_sug_ins_tipo;
			$item[0]['sol_sug_ret_tipo'] = $sol_sug_ret_tipo;
			$data = array(
				'sol_id' => $item[0]['sol_id'],
				'sol_descripcion' => $item[0]['sol_descripcion'],                                      
				'tip_id' => $item[0]['tip_id'],
				'mov_id' => $item[0]['mov_id'],
				'est_id' => $item[0]['est_id'],
				'dep_id_sec'=>$item[0]['dep_id_sec'],
				'sol_email'=>$item[0]['sol_email'],
				'sol_nombre'=>$item[0]['sol_nombre'],
				'sol_pidm'=>$item[0]['sol_pidm'],
				'sol_uidnumber'=>$item[0]['sol_uidnumber'],
				/*'sol_mag_crn_ret_des' => $item[0]['sol_mag_crn_ret_des'],
				'sol_mag_crn_ret' => $item[0]['sol_mag_crn_ret'],
				'sol_mag_crn_ins_des' => $item[0]['sol_mag_crn_ins_des'],
				'sol_mag_crn_ins' => $item[0]['sol_mag_crn_ins'],
				'sol_com_crn_ret_des' => $item[0]['sol_com_crn_ret_des'],
				'sol_com_crn_ret' => $item[0]['sol_com_crn_ret'],
				'sol_com_crn_ins_des' => $item[0]['sol_com_crn_ins_des'],
				'sol_com_crn_ins' => $item[0]['sol_com_crn_ins'],*/
				'sol_ins_crn' => $item[0]['sol_ins_crn'],
				'sol_ret_crn' => $item[0]['sol_ret_crn'],
				'sol_ins_des' => $item[0]['sol_ins_des'],
				'sol_ret_des' => $item[0]['sol_ret_des'],
				'sol_ins_mat' => $item[0]['sol_ins_mat'],
				'sol_ret_mat' => $item[0]['sol_ret_mat'],
				'sol_sug_ins_crn' => $item[0]['sol_sug_ins_crn'],
				'sol_sug_ret_crn' => $item[0]['sol_sug_ret_crn'],
				'sol_sug_ins_des' => $item[0]['sol_sug_ins_des'],
				'sol_sug_ret_des' => $item[0]['sol_sug_ret_des'],
				'sol_sug_ins_mat' => $item[0]['sol_sug_ins_mat'],
				'sol_sug_ret_mat' => $item[0]['sol_sug_ret_mat'],
				'sol_ins_seccion' => $item[0]['sol_ins_seccion'],
				'sol_ins_instructor' => $item[0]['sol_ins_instructor'],
				'sol_ins_tipo' => $item[0]['sol_ins_tipo'],
				'sol_ret_seccion' => $item[0]['sol_ret_seccion'],
				'sol_ret_instructor' => $item[0]['sol_ret_instructor'],
				'sol_ret_tipo' => $item[0]['sol_ret_tipo'],
				'sol_sug_ins_seccion' => $item[0]['sol_sug_ins_seccion'],
				'sol_sug_ins_instructor' => $item[0]['sol_sug_ins_instructor'],
				'sol_sug_ins_tipo' => $item[0]['sol_sug_ins_tipo'],
				'sol_sug_ret_seccion' => $item[0]['sol_sug_ret_seccion'],
				'sol_sug_ret_instructor' => $item[0]['sol_sug_ret_instructor'],
				'sol_sug_ret_tipo' => $item[0]['sol_sug_ret_tipo'],
				'accion'=>'actualizar',
				'titulo' => 'Actualizar',
				'options_tipo'=>$options_tipo,
				'options_motivo'=>$options_motivo,
				'comentario_form' => $comentario_form,
				'comentario_listado' => $comentario_listado,
				'puede_comentar' => $puede_comentar,
				'menu'=>$menu
				);
			$this->_adicionar_foraneas($data, $this->Tipo_model, $this->Motivo_model, $this->Estado_model, false);
			$this->load->view('solicitud_form', $data);			
		}
		unset($this->Tipo_model);
		unset($this->Motivo_model);
		unset($this->Estado_model);
	}	
	public function comentario($id=''){
		$menu = $this->Menu_model->_getmenu();
		//$this->load->model('Rol_model','',TRUE);			
		$sol_id = $this->input->post('sol_id');
		if($id==''){			
			$data = array('titulo' => 'ADMINISTRADOR DE SOLICITUDES','mensaje'=>'Se ha adicionado el comentario con \u00e9xito ','menu'=>$menu);
			if($this->session->userdata('rol')=='3'){ //estudiante
				//$this->load->view('solicitud_listado', $data);
			}else{
				$columnas = $this->session->userdata('colocultas');
				if($columnas){
					$data['ocultas'] = explode(';',$columnas);
				}else{
					$data['ocultas'] = array();
				}
				//$this->load->view('solicitud_listado_admin', $data);				
			}
			$this->index();
		}	
		else {
			$item = $this->Solicitud_model->get_item($id);
			if(!$this->_validar_gestion($item[0]['dep_id'])){			
				$this->load->view('solicitud_aviso', array('aviso'=>/*'Recuerde que con esta aplicaci&oacute;n solo se reciben solicitudes para las facultades de <strong>Derecho</strong> y <strong>Econom&iacute;a</strong>.'*/ 'El Periodo de gesti&oacute;n de solicitudes ha finalizado.','menu'=>$menu,'titulo'=>'AVISO','no_header'=>'no','rol'=>$this->session->userdata('rol')));
			}else{
			
				$this->load->model('Tipo_model','',TRUE);
				$tipo = $this->Tipo_model->get_item($item[0]['tip_id']);
				unset($this->Tipo_model);
				$this->load->model('Motivo_model','',TRUE);
				$motivo = $this->Motivo_model->get_item($item[0]['mov_id']);
				unset($this->Motivo_model);
				$this->load->model('Estado_model','',TRUE);
				$estado = $this->Estado_model->get_item($item[0]['est_id']);
				$options_estado = $this->Estado_model->get_dropdown();			
				unset($this->Estado_model);
				$this->load->model('Comentario_model','',TRUE);
				$this->load->model('Rol_model','',TRUE);
				$comentario = $this->Comentario_model->get_item($id,'sol_id');
				$this->_prepare_list_comentario($datac, $id, $this->Comentario_model);
				$comentario_listado = $this->load->view('comentario_listado', $datac, true);

				$this->load->model('Parametro_model','',TRUE);
				$comentario_normal = $this->Parametro_model->get_item('comentario normal','par_nombre');
				$comentario_cancelar = $this->Parametro_model->get_item('comentario cancelar','par_nombre');
				$comentario_cambiar_estado = $this->Parametro_model->get_item('comentario cambiar estado','par_nombre');
				//unset($this->Parametro_model);
				$datac = array('sol_id'=>$id,
					'com_texto'=>@$comentario[0]['com_texto'],
					'com_nombre'=>$this->session->userdata('nombres'),
					'rol_id'=>$this->session->userdata('rol'),
					'accion'=>'comentario',
					'comentario_normal' => $comentario_normal[0]['par_valor'],
					'comentario_cancelar' => $comentario_cancelar[0]['par_valor'],
					'comentario_cambiar_estado' => $comentario_cambiar_estado[0]['par_valor'],						
					);
				$this->_prepare_list_comentario($datac, $id, $this->Comentario_model, false);			
				unset($this->Comentario_model);
				unset($this->Rol_model);
				//$this->_adicionar_foraneas_comentario($datac, $this->Rol_model, false);
				//unset($this->Rol_model);
				$comentario_form = $this->load->view('comentario_form',$datac, true);
			
				if((($item[0]['est_id']=='1'/*En revisión*/ || $item[0]['est_id']=='5'/*En espera de respuesta del coordinador*/) && ($this->session->userdata('rol')=='2'/*Coordinador*/ || $this->session->userdata('rol')=='1'/*Administrador*/)) ||
				($item[0]['est_id']=='4'/*En espera de respuesta del estudiante*/ && $this->session->userdata('rol')=='3'/*Estudiante*/))
					$puede_comentar = true;
				else
					$puede_comentar = false;
				
				$sol_ins_tipo = ($item[0]['sol_ins_tipo']=='mag' || $item[0]['sol_ins_tipo']=='com') ? $item[0]['sol_ins_tipo'] : 'NORMAL';
				if($sol_ins_tipo!='NORMAL')
					$sol_ins_tipo = ($item[0]['sol_ins_tipo']=='mag') ? 'MAGISTRAL' : 'COMPLEMENTARIA';
				else
					$sol_ins_tipo = $item[0]['sol_ins_crn']!='' ? $sol_ins_tipo : '';
				$sol_ret_tipo = ($item[0]['sol_ret_tipo']=='mag' || $item[0]['sol_ret_tipo']=='com') ? $item[0]['sol_ret_tipo'] : 'NORMAL';
				if($sol_ret_tipo!='NORMAL')
					$sol_ret_tipo = ($item[0]['sol_ret_tipo']=='mag') ? 'MAGISTRAL' : 'COMPLEMENTARIA';
				else
					$sol_ret_tipo = $item[0]['sol_ret_crn']!='' ? $sol_ret_tipo : '';
				$sol_sug_ins_tipo = ($item[0]['sol_sug_ins_tipo']=='mag' || $item[0]['sol_sug_ins_tipo']=='com') ? $item[0]['sol_sug_ins_tipo'] : 'NORMAL';
				if($sol_sug_ins_tipo!='NORMAL')
					$sol_sug_ins_tipo = ($item[0]['sol_sug_ins_tipo']=='mag') ? 'MAGISTRAL' : 'COMPLEMENTARIA';
				else
					$sol_sug_ins_tipo = $item[0]['sol_sug_ins_crn']!='' ? $sol_sug_ins_tipo : '';
				$sol_sug_ret_tipo = ($item[0]['sol_sug_ret_tipo']=='mag' || $item[0]['sol_sug_ret_tipo']=='com') ? $item[0]['sol_sug_ret_tipo'] : 'NORMAL';
				if($sol_sug_ret_tipo!='NORMAL')
					$sol_sug_ret_tipo = ($item[0]['sol_sug_ret_tipo']=='mag') ? 'MAGISTRAL' : 'COMPLEMENTARIA';
				else
					$sol_sug_ret_tipo = $item[0]['sol_sug_ret_crn']!='' ? $sol_sug_ret_tipo : '';
				$item[0]['sol_ins_tipo'] = $sol_ins_tipo;
				$item[0]['sol_ret_tipo'] = $sol_ret_tipo;
				$item[0]['sol_sug_ins_tipo'] = $sol_sug_ins_tipo;
				$item[0]['sol_sug_ret_tipo'] = $sol_sug_ret_tipo;
				$data = array(
					'sol_id' => $item[0]['sol_id'],
					'sol_descripcion' => $item[0]['sol_descripcion'],                                      
					'tip_id' => $item[0]['tip_id'],
					'mov_id' => $item[0]['mov_id'],
					'est_id' => $item[0]['est_id'],
					'dep_id_sec'=>$item[0]['dep_id_sec'],
					'sol_email'=>$item[0]['sol_email'],
					'sol_nombre'=>$item[0]['sol_nombre'],
					'sol_apellido'=>$item[0]['sol_apellido'],
					'sol_fec_creacion'=>$item[0]['sol_fec_creacion'],
					'sol_pidm'=>$item[0]['sol_pidm'],
					'sol_uidnumber'=>$item[0]['sol_uidnumber'],
					/*'sol_mag_crn_ret_des' => $item[0]['sol_mag_crn_ret_des'],
					'sol_mag_crn_ret' => $item[0]['sol_mag_crn_ret'],
					'sol_mag_crn_ins_des' => $item[0]['sol_mag_crn_ins_des'],
					'sol_mag_crn_ins' => $item[0]['sol_mag_crn_ins'],
					'sol_com_crn_ret_des' => $item[0]['sol_com_crn_ret_des'],
					'sol_com_crn_ret' => $item[0]['sol_com_crn_ret'],
					'sol_com_crn_ins_des' => $item[0]['sol_com_crn_ins_des'],
					'sol_com_crn_ins' => $item[0]['sol_com_crn_ins'],*/
					'sol_ins_crn' => $item[0]['sol_ins_crn'],
					'sol_ret_crn' => $item[0]['sol_ret_crn'],
					'sol_ins_des' => $item[0]['sol_ins_des'],
					'sol_ret_des' => $item[0]['sol_ret_des'],
					'sol_ins_mat' => $item[0]['sol_ins_mat'],
					'sol_ret_mat' => $item[0]['sol_ret_mat'],
					'sol_sug_ins_crn' => $item[0]['sol_sug_ins_crn'],
					'sol_sug_ret_crn' => $item[0]['sol_sug_ret_crn'],
					'sol_sug_ins_des' => $item[0]['sol_sug_ins_des'],
					'sol_sug_ret_des' => $item[0]['sol_sug_ret_des'],
					'sol_sug_ins_mat' => $item[0]['sol_sug_ins_mat'],
					'sol_sug_ret_mat' => $item[0]['sol_sug_ret_mat'],
					'sol_ins_seccion' => $item[0]['sol_ins_seccion'],
					'sol_ins_instructor' => $item[0]['sol_ins_instructor'],
					'sol_ins_tipo' => $item[0]['sol_ins_tipo'],
					'sol_ret_seccion' => $item[0]['sol_ret_seccion'],
					'sol_ret_instructor' => $item[0]['sol_ret_instructor'],
					'sol_ret_tipo' => $item[0]['sol_ret_tipo'],
					'sol_sug_ins_seccion' => $item[0]['sol_sug_ins_seccion'],
					'sol_sug_ins_instructor' => $item[0]['sol_sug_ins_instructor'],
					'sol_sug_ins_tipo' => $item[0]['sol_sug_ins_tipo'],
					'sol_sug_ret_seccion' => $item[0]['sol_sug_ret_seccion'],
					'sol_sug_ret_instructor' => $item[0]['sol_sug_ret_instructor'],
					'sol_sug_ret_tipo' => $item[0]['sol_sug_ret_tipo'],
					'accion'=>'comentario',
					'titulo' => 'Comentarios',
					'tipo'=>$tipo[0]['tip_descripcion'],
					'motivo'=>$motivo[0]['mov_descripcion'],
					'estado'=>$estado[0]['est_descripcion'],
					'options_estado'=>$options_estado,
					'comentario_form' => $comentario_form,
					'comentario_listado' => $comentario_listado,
					'puede_comentar' => $puede_comentar,						
					'menu'=>$menu,
					'rol_id'=>$this->session->userdata('rol'),
					);
				//otros datos estudiante
				//obtengo el periodo actual
				$this->load->model('Parametro_model','',TRUE);
				$periodo = $this->Parametro_model->get_item('periodo','par_nombre');
				$periodo = $periodo[0]['par_valor'];        
				//
				$datos_estudiante = $this->integracion->datosEstudiante($item[0]['sol_pidm'],$periodo);
				$data['prog'] = $datos_estudiante['PROGRAMA'];  				
				$data['doble_prog'] = $datos_estudiante['DOBLE_PROGRAMA'];  				
				$data['creditos']= $datos_estudiante['CRED_INS'];
				$data['opcion']= $datos_estudiante['OPCION'];
				$data['ssc']= $datos_estudiante['SSC'];
				//$data['sol_id'] = $sol_id;				
				//obtiene una cadena 'anterior,actual,siguiente'-----------------------------------------------
				$filtros['sortorder'] = $this->session->userdata('sortorder');
				$filtros['sortname'] = $this->session->userdata('sortname');
				$filtros['qtype'] = $this->session->userdata('qtype');
				$filtros['query'] = $this->session->userdata('query');
				$filtros['qtype2'] = $this->session->userdata('qtype2');
				$filtros['query2'] = $this->session->userdata('query2');
				
				$ordenadas = $this->_get_filas($this->session->userdata('rol'),
									0, 0, //$inicio,$this->session->userdata('cantpag'),
									$filtros['sortorder'],
									$filtros['sortname'],
									$filtros['qtype'],
									$filtros['query'],
									$filtros['qtype2'],
									$filtros['query2'],
									true);//imprimir

				$ordenfilas = '';
				/*echo 'sortorder '.$filtros['sortorder'].' sortname '.$filtros['sortname'];
				echo $filtros['qtype'].'<br>';
				echo $filtros['query'].'<br>';
				echo $filtros['qtype2'].'<br>';
				echo $filtros['query2'].'<br>';*/
				
				//print_r($ordenadas);
				foreach($ordenadas as $indice=>$fila){
				//echo $fila['sol_id'].'<-<br>';
					if($fila['sol_id']==str_replace('-', '', $id)){	
						
						$anterior = $indice == 0 ? $ordenadas[count($ordenadas) - 1]['sol_id'] : $ordenadas[$indice - 1]['sol_id'];
						$siguiente = $indice == count($ordenadas) - 1 ? $ordenadas[0]['sol_id'] : $ordenadas[$indice + 1]['sol_id'];
				
						$ordenfilas = $anterior.';'.$fila['sol_id'].';'.$siguiente; //cadena 'anterior,actual,siguiente'
					
					}
				}				
				//-----------------------------------------------------------------------------------------------
				$data['ordenfilas'] = $ordenfilas;
				$data['ordenfilas_paginado'] = $this->session->userdata('ordenfilas');
				$data['rol_botones'] = $this->session->userdata('rol');
				$this->load->view('solicitud_form_comentario', $data);
			}
		}	
	}				
	
	public function borrar($id){
		if($this->Solicitud_model->delete($id)) {
			$data = array('titulo' => 'ADMINISTRADOR DE SOLICITUDES','mensaje'=>'Se ha borrado con \u00e9xito');
			//$this->_prepare_list($data);
			$this->load->view('solicitud_listado', $data);
		}
	}
	
	public function cancelar(){
		$this->load->model('Comentario_model','',TRUE);
		$this->load->model('Rol_model','',TRUE);
		$res = '';
		$sol_id = $this->input->post('sol_id');
		if($sol_id){
			$lista = trim($sol_id,',');
			$lista = explode(',',$sol_id);			
			foreach($lista as $item){
				if(!empty($item)){
					$data = array('est_id'=>6, 'sol_fec_actualizacion' => date("Y-m-d H:i:s"));
					if($this->Solicitud_model->update($item,$data)) {						
						$res = 'OK';
					}
					//asocio el comentario					
					$datac = array(					
						'com_texto'=>$this->input->post('com_texto'),
						'com_login'=>$this->session->userdata('login'),
						'com_nombre'=>$this->session->userdata('nombres'),
						'sol_id'=>$item,
						'rol_id'=>$this->session->userdata('rol'),			
					);
					if($datac['com_texto']!='')
						$this->Comentario_model->insert($datac);
					$datos = $this->Solicitud_model->get_item($item,'sol_id');
					$this->enviarCorreo('cancelar', $datos[0]['sol_email'], 'Cancelación solicitud', $item);					
				}								
			}
		}
		$this->index();
	}
	
	public function estado(){
		$this->load->model('Comentario_model','',TRUE);
		$this->load->model('Rol_model','',TRUE);
		$res = '';
		$sol_id = $this->input->post('sol_id');
		$est_id = $this->input->post('est_id');
		if($sol_id&&$est_id){
			$lista = trim($sol_id,',');
			$lista = explode(',',$sol_id);			
			foreach($lista as $item){
				if(!empty($item)){
					$data = array('est_id'=>$est_id, 'sol_fec_actualizacion' => date("Y-m-d H:i:s"));
					if($this->Solicitud_model->update($item,$data)) {						
						$res = 'OK';
					}
					//asocio el comentario					
					$datac = array(					
						'com_texto'=>$this->input->post('com_texto'),
						'com_login'=>$this->session->userdata('login'),
						'com_nombre'=>$this->session->userdata('nombres'),
						'sol_id'=>$item,
						'rol_id'=>$this->session->userdata('rol'),			
					);
					if($datac['com_texto']!='')
						$this->Comentario_model->insert($datac);
					$datos = $this->Solicitud_model->get_item($item,'sol_id');
					$this->enviarCorreo('estado', $datos[0]['sol_email'], 'Cambio de estado solicitud', $item);
				}						
			}
		}
		$this->index();
	}
	
	/*Relaciona comentarios a una solicitud*/
	public function relate($sol_id){
		$this->load->model('Comentario_model','',TRUE);
		$this->load->model('Rol_model','',TRUE);
		
		$this->load->model('Parametro_model','',TRUE);
		$comentario_normal = $this->Parametro_model->get_item('comentario normal','par_nombre');
		$comentario_cancelar = $this->Parametro_model->get_item('comentario cancelar','par_nombre');
		$comentario_cambiar_estado = $this->Parametro_model->get_item('comentario cambiar estado','par_nombre');
		unset($this->Parametro_model);
		$datac = array(
			'com_login'=>$this->input->post('com_login'),
			'com_texto'=>$this->input->post('com_texto'),
			'com_login'=>$this->session->userdata('login'),
			'com_nombre'=>$this->session->userdata('nombres'),
			'sol_id'=>$sol_id,
			'rol_id'=>$this->session->userdata('rol'),						
			);
		if($this->validar_comentario()){
			if($datac['com_texto']!='')
				$this->Comentario_model->insert($datac);
			$est_id = $this->session->userdata('rol')=='3'/*estudiante*/ ? '5'/*En espera de respuesta del coordinador*/ : '4';//En espera de respuesta del estudiante
			$datos = array('est_id'=>$est_id, 'sol_fec_actualizacion' => date("Y-m-d H:i:s"));
			$this->Solicitud_model->update($sol_id,$datos);
			
			$datos = $this->Solicitud_model->get_item($sol_id,'sol_id');
			$this->enviarCorreo('comentario', $datos[0]['sol_email'], 'Comentario solicitud', $sol_id);
			echo 'OK';
		}else {
			$accion = array(
				'accion'=>$this->input->post('accion'),
				'comentario_normal' => $comentario_normal[0]['par_valor'],
				'comentario_cancelar' => $comentario_cancelar[0]['par_valor'],
				'comentario_cambiar_estado' => $comentario_cambiar_estado[0]['par_valor'],
				);
			$this->_prepare_list_comentario($datac, $sol_id, $this->Comentario_model, false);
			$datac = array_merge((array)$datac, $accion);
			$comentario = $this->Comentario_model->get_item($sol_id,'sol_id');			
			$this->load->view('comentario_form',$datac);			
		}
		unset($this->Comentario_model);
		unset($this->Rol_model);
	}
	
	public function validar(){
		if($this->session->userdata('rol')!=3){
			$this->form_validation->set_rules('sol_login', 'Login', 'required');
			$this->form_validation->set_rules('sol_email', 'Email', 'required|valid_email');
		}
		$this->form_validation->set_rules('sol_descripcion', 'Descripción', 'max_length[300]');
		$this->form_validation->set_rules('tip_id', 'Tipo', 'required');
		$this->form_validation->set_rules('mov_id', 'Motivo', 'required');
		$this->form_validation->set_rules('sol_tyc', 'Acepta términos y condiciones', 'required');
		
		if($this->input->post('tip_id')=='1') //inscribir materia
			$this->form_validation->set_rules('sol_disp_crn_ret_des', 'Curso Inscripción', 'required');
		elseif($this->input->post('tip_id')!=''){
			$this->form_validation->set_rules('sol_disp_crn_ins_des', 'Curso Inscripción', 'required');
			$this->form_validation->set_rules('sol_disp_crn_ret_des', 'Curso Retiro', 'required');
		}
		return $this->form_validation->run();
	}	
	
	public function validar_comentario(){
		$this->form_validation->set_rules('com_texto', 'Texto', 'required|max_length[300]');		
		return $this->form_validation->run();
	}
	
	public function page(){
		//recordar el orden---------------------------------					
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		$datos_sesion= array('sortname'=>$sortname, 'sortorder'=>$sortorder);
		$this->session->set_userdata($datos_sesion);
		//si viene algo por sesion en qtype lo pasa al post y lo elimina de la sesion		
		$qtype = $this->session->userdata('qtype')!='' ? $this->session->userdata('qtype') : $this->input->post('qtype');
		$query = $this->session->userdata('qtype')!='' ? $this->session->userdata('query') : $this->input->post('query');
		$qtype2 = $this->session->userdata('qtype')!='' ? $this->session->userdata('qtype2') : $this->input->post('qtype2');
		$query2 = $this->session->userdata('qtype')!='' ? $this->session->userdata('query2') : $this->input->post('query2');
		$datos_sesion= array(
			'qtype'=>'',
			'query'=>'',
			'qtype2'=>'',
			'query2'=>'',
			);
		$this->session->set_userdata($datos_sesion);
		//--------------------------------------------------
	
		$datos = array();		
		$datos_sesion = array('cantpag'=>$this->input->post('rp'));		
		$this->session->set_userdata($datos_sesion);
		if($this->input->post('otro')=='n'){			
			$datos_sesion = array('numpag'=>$this->input->post('page'));
			$this->session->set_userdata($datos_sesion);			
			$datos['page'] = $this->input->post('page');
			
		}else{			
			$datos['page'] = $this->session->userdata('numpag');	
		}
		
		$datos['otro'] = 'n';
		$this->load->model('Tipo_model','',TRUE);
		$this->load->model('Motivo_model','',TRUE);
		$this->load->model('Estado_model','',TRUE);		
			
		$datos['sortname'] = ($this->input->post('sortname')!='')?$this->input->post('sortname'):$this->Solicitud_model->tableLlave();
		$datos['sortorder'] = ($this->input->post('sortorder')!='')?$this->input->post('sortorder'):'ASC';
		/*$datos['qtype'] = ($this->input->post('qtype')!='')?$this->input->post('qtype'):'';
        $datos['query'] = ($this->input->post('query')!='')?$this->input->post('query'):'';
        $datos['qtype2'] = ($this->input->post('qtype2')!='')?$this->input->post('qtype2'):'';
        $datos['query2'] = ($this->input->post('query2')!='')?$this->input->post('query2'):'';*/
		
		$datos['qtype'] = $qtype!='' ? $qtype : '';
        $datos['query'] = $query!='' ? $query : '';
        $datos['qtype2'] = $qtype2!='' ? $qtype2 : '';
        $datos['query2'] = $query2!='' ? $query2 : '';
		
		$datos['total'] = $this->_get_count($this->session->userdata('rol'),$datos['qtype'],$datos['query'],$datos['qtype2'],$datos['query2']);
		
		$inicio = ((int)($datos['page'])-1)*(int)$this->session->userdata('cantpag');
		
		
		$filas = $this->_get_filas($this->session->userdata('rol'),
							    $inicio,$this->session->userdata('cantpag'),
							    $datos['sortorder'],
							    $datos['sortname'],
                                $datos['qtype'],
                                $datos['query'],
                                $datos['qtype2'],
                                $datos['query2']);
		//relaciona fila anterior y siguiente--------------------------------------
		$ordenfilas = '';
		foreach($filas as $indice=>$fila){
			$ordenfilas .= $ordenfilas!='' ? ';' : '';
			$ordenfilas .= $fila['sol_id'];
			$datos_sesion= array('ordenfilas'=>$ordenfilas);
			$this->session->set_userdata($datos_sesion);		
			$filas[$indice]['sol_id_anterior'] = $indice == 0 ? $filas[count($filas) - 1]['sol_id'] : $filas[$indice - 1]['sol_id'];
			$filas[$indice]['sol_id_siguiente'] = $indice == count($filas) - 1 ? $filas[0]['sol_id'] : $filas[$indice + 1]['sol_id'];
		}
		//-------------------------------------------------------------------------	
		
		foreach($filas as $item){
			$item['sol_fec_creacion'] = substr($item['sol_fec_creacion'], 0, -3);			
			$profesores = '';
			$instructor = explode(',',$item['sol_ins_instructor']);
			foreach($instructor as $unp){
				$profesores .= $unp.'<br>';
			}
			$columnas = array();
			$ocultas = $this->session->userdata('colocultas');
			if($ocultas){
				$columnas = explode(';',$ocultas);
			}
			$this->_adicionar_foraneas($item, $this->Tipo_model, $this->Motivo_model, $this->Estado_model, false);
			$color = $this->_get_color($item['est_id']);
			$celda = array();
			
			$ordencols = explode(';', $this->session->userdata('ordencol'));
			if(is_array($ordencols) && count($ordencols)>0 && $this->session->userdata('ordencol')!=''){
				foreach($ordencols as $ordencol){
					switch ($ordencol) {
						case 'est_id':
							$contenidocelda = "<div title='".$item['est_descripcion']."' style='cursor: default'>".$color.( ((($item['est_id']=='1')||($item['est_id']=='5')) && $this->session->userdata('rol')!=3) ? "<img src='http://".$_SERVER['SERVER_NAME']."/conflictohorario/application/core/advertencia.png' style='width: 13px !important; position: absolute; margin-left: -23px;margin-top: 1px; ' />" : "")."</div>";
							break;
						case 'tip_id':
							$contenidocelda = $item['tip_descripcion'];
							break;
						case 'mov_id':
							$contenidocelda = $item['mov_descripcion'];
							break;
						case 'sol_ins_instructor':
							$contenidocelda = $profesores;						
						default:
							$contenidocelda = array_key_exists($ordencol, $item) ? $item[$ordencol]: 'contenidocelda';
					}
					//if(!in_array($ordencol, $columnas))
						$celda[] = $contenidocelda;
				}
			}
			else {
			//se deben enviar TODOS los datos en $celda ya que luego se ocultan las columnas
			
				//if(!in_array('sol_id',$columnas))
				$celda[] = $item['sol_id'];
				//if(!in_array('est_id',$columnas))
				$celda[] = "<div title='".$item['est_descripcion']."' style='cursor: default'>".$color.( ((($item['est_id']=='1')||($item['est_id']=='5')) && $this->session->userdata('rol')!=3) ? "<img src='http://".$_SERVER['SERVER_NAME']."/conflictohorario/application/core/advertencia.png' style='width: 13px !important; position: absolute; margin-left: -23px;margin-top: 1px; ' />" : "")."</div>";
				//if(!in_array('sol_fec_creacion',$columnas))
				$celda[] = $item['sol_fec_creacion'];
				//if(!in_array('sol_uidnumber',$columnas))
				$celda[] = $item['sol_uidnumber'];
				//if(!in_array('sol_login',$columnas))
				$celda[] = $item['sol_login'];
				//if(!in_array('sol_nombre',$columnas))
				$celda[] = $item['sol_nombre'];
				//if(!in_array('sol_apellido',$columnas))
				$celda[] = $item['sol_apellido'];
				//if(!in_array('sol_ins_mat',$columnas))
				$celda[] = $item['sol_ins_mat'];
				//if(!in_array('sol_ins_crn',$columnas))
				$celda[] = $item['sol_ins_crn'];
				//if(!in_array('sol_ins_des',$columnas))
				$celda[] = $item['sol_ins_des'];
				//if(!in_array('sol_ins_seccion',$columnas))
				$celda[] = $item['sol_ins_seccion'];
				//if(!in_array('tip_id',$columnas))
				$celda[] = $item['tip_descripcion'];
				//if(!in_array('mov_id',$columnas))
				$celda[] = $item['mov_descripcion'];
				//if(!in_array('sol_descripcion',$columnas))
				$celda[] = $item['sol_descripcion'];
				//if(!in_array('sol_ins_instructor',$columnas))
				$celda[] = $profesores;
			}
			$datos['rows'][] = array(
				'id' => $item['sol_id'],				
				'cell' => $celda
			);			
		}
		echo json_encode($datos);
		unset($this->Tipo_model);
		unset($this->Motivo_model);
		unset($this->Estado_model);		
	}
	
	private function _prepare_list(&$data){
		$this->load->model('Tipo_model','',TRUE);		
		$this->load->model('Motivo_model','',TRUE);
		$this->load->model('Estado_model','',TRUE);		
		$data['total_rows'] = $this->Solicitud_model->get_count();                
		$filas = $this->Solicitud_model->get_all();
		$datos = array();
		foreach($filas as $item){
			$this->_adicionar_foraneas($item, $this->Tipo_model, $this->Motivo_model, $this->Estado_model, false);
			$datos['rows'][] = array(
				'id' => $item['sol_id'],
				'cell' => array($item['sol_id'], $item['sol_descripcion'], $item['tip_descripcion'], $item['mov_descripcion'], $item['est_descripcion'])
			);
		}
		$data['$filas'] = json_encode($datos);		
		unset($this->Tipo_model);
		unset($this->Motivo_model);
		unset($this->Estado_model);
	}

	private function _prepare_list_comentario(&$datac, $id, $comentario_model, $filas=true){
		$this->load->library('pagination');
                $config_page['base_url'] = '/index.php/comentario/page/';
                $config_page['total_rows'] = $this->Comentario_model->get_count();
                $config_page['per_page'] = 20;			
                $this->pagination->initialize($config_page);
		$datac['filas'] = $this->Comentario_model->get_item($id,'sol_id');
		$this->_adicionar_foraneas_comentario($datac, $this->Rol_model, $filas);		
		$datac['paginacion'] = $this->pagination->create_links();
	}
	
	public function ayuda($id_input){
		$data['secciones'] = array('3131823'=>'seccion 1','3131923'=>'seccion 2','3131423'=>'seccion 3','3133123'=>'seccion 4','31311	23'=>'seccion 5');
		$data['id_input']= $id_input;
		$this->load->view('ayuda', $data);
	}
	
	public function ayudaMinicartelera($tip_id, $id_input, $valor='', $tipo='', $pidm=''){
		$this->load->model('Parametro_model','Parametro_model_crn',TRUE);
		$periodo = $this->Parametro_model_crn->get_item('periodo','par_nombre');
        $periodo = $periodo[0]['par_valor'];		
		
		//print "tip_id $tip_id, id_input $id_input, valor $valor, tipo $tipo, pidm $pidm<br>";
		$data['titulo'] = 'Minicartelera';
		$data['tip_id'] = $tip_id;
		//$data['id_input'] = $id_input;
		$data['valor'] = $valor;
		$data['tipo'] = $tipo;
		$data['pidm'] = $pidm;
		$data['option_prog']= array();
		//$data['secciones'] = array('19603'=>'seccion 1','18461'=>'seccion 2','3131423'=>'seccion 3','3133123'=>'seccion 4','3131123'=>'seccion 5');		
		// si el tipo es complementaria solo muestra las de su magistral
		$data['secciones'] = ($tipo=='com' && strpos($id_input, '_sug_')!==false) ? $this->integracion->esMagistral($valor,$periodo) : $this->integracion->materiasInscritas($pidm,$periodo);		
		$data['secciones'] = ($tipo=='com' && strpos($id_input, '_sug_')!==false && $id_input=='sol_sug_crn_ret' && $tip_id!='1') ? array_intersect_assoc($this->integracion->esMagistral($valor,$periodo), $this->integracion->materiasInscritas($pidm,$periodo)) : $data['secciones'];
				
		$data['tiposSecciones']=array();
		if(is_array($data['secciones'])){
			foreach ($data['secciones'] as $id=>$dato){
				$data['secciones'][$id] = $dato['TITULO'];
				$data['materias'][$id] = $dato['MATERIA'];
				$data['las_secciones'][$id] = $dato['SECCION'];
				$data['titulos'][$id] = $dato['TITULO'];
				$data['profesores'][$id] = $dato['PROFESORES'];
				
				$data['tiposSecciones'][$id]=$this->validar_crn($id);
				if(($data['tiposSecciones'][$id]=='com' || $data['tiposSecciones'][$id]=='mag') && strpos($id_input, '_disp_')!==false) { //si es disparador complementaria se adicionan los datos de su magistral key2 y seccion2
					$secciones2 = $data['tiposSecciones'][$id]=='com' ? $this->integracion->esComplementaria($id,$periodo) : array_intersect_assoc($this->integracion->esMagistral($id,$periodo), (array)$this->integracion->materiasInscritas($pidm,$periodo));						
					if(is_array($secciones2)){
						foreach($secciones2 as $key2 => $valor2){
							$data['key2'][$id]=$key2;
							$data['seccion2'][$id]=$valor2;
							$magistral = $this->integracion->vistaMinicartelera(array(OPCION1=>$key2)); //busca todos los datos de la magistral
							$data['materias2'][$id] = $magistral[1]['MATERIA'];
							$data['las_secciones2'][$id] = $magistral[1]['SECCION'];
							$data['profesores2'][$id] = $magistral[1]['PROFESORES'];
							if($data['tiposSecciones'][$id]=='mag')
								$data['seccion2'][$id] = $magistral[1]['TITULO'];
						}
					}
				}
			}
		}
		$data['id_input']= $id_input;
		/*$programas_activos = @$this->integracion->programasActivos();
		foreach($programas_activos as $llave => $valor) {
				$data['option_prog'] = array('dep_id'=>$llave, 'dep_nombre'=>utf8_encode($valor));
		}*/
		$data['option_prog']= @$this->integracion->programasActivos();		
		array_unshift($data['option_prog'], "Seleccione Programa");
		$this->load->view('mini_cartelera', $data);	
	}
        
        public function busquedaMinicartelera(){
			$this->load->model('Parametro_model','Parametro_model_crn',TRUE);
			$periodo = $this->Parametro_model_crn->get_item('periodo','par_nombre');
			$periodo = $periodo[0]['par_valor'];
			
            $btn=$this->input->post('busqueda');            
            $actual=$this->input->post('actual');
            $filas=$this->input->post('filas');
            if (empty($actual))$actual=0;
            if (empty($filas))$filas=PAGINAS;
               
            $parametros['busqueda']=array();
			
			//Para cambio de sección CRN Inscripción debe tener el mismo t?tulo que CRN Retiro
			if($this->input->post('valor')!='' && $this->input->post('tip_id')=='2' && $this->input->post('id_input')=='sol_disp_crn_ins'){
				$titulos = $this->integracion->obtenerTituloMateria($this->input->post('valor'));				
				$parametros['busqueda']['TITULO_RET'] = $titulos[0]['TITULO'];
			}
			
            if($btn=='buscar1')$parametros['busqueda'][OPCION1]=$crn=$this->input->post('crn');
            if($btn=='buscar2'){
                $parametros['busqueda'][OPCION21]=$programa=$this->input->post('programa_id');
                $parametros['busqueda'][OPCION22]=$materia1=$this->input->post('materia1');
                $parametros['busqueda'][OPCION23]=$seccion1=$this->input->post('seccion1');
            }
            if($btn=='buscar3'){
                $parametros['busqueda'][OPCION31]=$this->input->post('materia2');
                $parametros['busqueda'][OPCION32]=$this->input->post('seccion2');
            }
			if($btn=='buscar4'){
                $parametros['busqueda'][OPCION41]=$this->input->post('profesor');
				$parametros['busqueda'][OPCION42]=$this->input->post('profesor');
				$parametros['busqueda'][OPCION43]=$this->input->post('profesor');
			}
            $datos['boton']=$btn;
            $datos['actual']=$actual;
            $datos['filas']=$filas;
			
			switch($this->input->post('campo_orden')){
				case 'CRN';
					$campo_orden = 'crn';
				break;
				case 'MATERIA':			 
					$campo_orden = 'materia||curso';
				break;
				case 'SECCION':
					$campo_orden = 'seccion';
				break;
				case 'TITULO':
					$campo_orden = 'titulo';
				break;
				case 'PROFESORES':
					$campo_orden = "profesor_1||','||profesor_2||','||profesor_3";//'profesores';
				break;
				default:
					$campo_orden = 'titulo';
			}
			$orden = $this->input->post('orden')!='' ? $this->input->post('orden') : 'asc';
            $registros=$this->integracion->vistaMinicartelera($parametros['busqueda'],$actual,$filas,$campo_orden,$orden);            
            $total=array_shift($registros);
            $datos['total']=$total;
			
			$orden_crn = $orden_materia = $orden_seccion = $orden_titulo = $orden_profesores = $ordenados = $crn_ordenados = array();
			foreach($registros as $indice => $regisro){
				$orden_crn[$regisro['CRN']] = $regisro['CRN'];
				$orden_materia[$regisro['CRN']] = $regisro['MATERIA'];
				$orden_seccion[$regisro['CRN']] = $regisro['SECCION'];
				$orden_titulo[$regisro['CRN']] = $regisro['TITULO'];
				$orden_profesores[$regisro['CRN']] = $regisro['PROFESORES'];
				$regisro['tipo'] = $this->validar_crn($regisro['CRN']);
				if($regisro['tipo']=='com' && strpos($this->input->post('id_input'), '_disp_')!==false){ //si es disparador complementaria se adicionan los datos de su magistral key2 y seccion2
					$secciones2 = $this->integracion->esComplementaria($regisro['CRN'], $periodo);
					if(is_array($secciones2)){
						foreach($secciones2 as $key2 => $valor2){
							$regisro['key2']=$key2;
							$regisro['seccion2']=$valor2;
							$magistral = $this->integracion->vistaMinicartelera(array(OPCION1=>$key2)); //busca todos los datos de la magistral
							$regisro['materias2'] = $magistral[1]['MATERIA'];
							$regisro['las_secciones2'] = $magistral[1]['SECCION'];
							$regisro['profesores2'] = $magistral[1]['PROFESORES'];
						}
					}
				}
				$registros[$indice] = array_merge((array)$registros[$indice], $regisro);
			}
            $datos['registros']=$registros;
            $datos['id_input']=  $this->input->post('id_input');
            $this->load->view('resultados_mini_cartelera',$datos);
        }

        public function ajaxsearch(){
		$function_name = $this->input->post('function_name');
		$description = $this->input->post('description');
		echo $this->function_model->getSearchResults($function_name, $description);
	}

	public function search(){
		$data['title'] = "Code Igniter Search Results";
		$function_name = $this->input->post('function_name');
		$data['search_results'] = $this->function_model->getSearchResults($function_name);
		$this->load->view('application/search', $data);
	}
	
	private function _adicionar_foraneas(&$item, $tipo_model, $motivo_model, $estado_model, $filas=true){		
		if($filas) { //con filas para listado
			if(is_array($item['filas'])) {
				$n = 0;
				foreach($item['filas'] as $fila) {
					$tipo = $tipo_model->get_item($fila['tip_id']);
					$motivo = $motivo_model->get_item($fila['mov_id']);
					$estado = $estado_model->get_item($fila['est_id']);
					$filanueva = array_merge($fila, (array)$tipo[0], (array)$motivo[0], (array)$estado[0]);
					$item['filas'][$n] = $filanueva;
					$n++;
				}
			}
		}
		else { //sin filas para formulario
			$tipo = $tipo_model->get_item($item['tip_id']);
			$motivo = $motivo_model->get_item($item['mov_id']);
			$estado = $estado_model->get_item($item['est_id']);
			$datanueva = array_merge($item, (array)$tipo[0], (array)$motivo[0], (array)$estado[0]);
			$item = $datanueva;
		}
	}
	
	private function _adicionar_foraneas_comentario(&$datac, $rol_model, $filas=true){		
		if($filas) { //con filas para listado
			if(is_array($datac['filas'])) {
				$n = 0;
				foreach($datac['filas'] as $fila) {
					$rol = $rol_model->get_item($fila['rol_id']);
					$filanueva = array_merge($fila, (array)$rol[0]);
					$datac['filas'][$n] = $filanueva;
					$n++;
				}
			}
		}
		else { //sin filas para formulario
			$rol = $rol_model->get_item($datac['rol_id']);
			$datanueva = array_merge($datac, (array)$rol[0]);
			$datac = $datanueva;
		}
	}
	
	/*Revisa los permisos y segun el usuario entrega un tipo de men?*/
	private function _getmenu(){
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

		$niv_ids = explode('*', $this->session->userdata('niveles'));
		$niveles = '';
		if(is_array($niv_ids)){
			foreach($niv_ids as $niv_id){
				$niv_descripcion = $this->Nivel_model->get_item($niv_id);
				$niv_descripcion = @$niv_descripcion[0]['niv_descripcion'];
				if(@$niv_descripcion!=''){
					$niveles .= $niveles!='' ? '-' : '';
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
			'rol_name'=>@$rol_name[0]['rol_descripcion']
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
	/*Obtiene las filas segun*/
	private function _get_filas($rol,$inicio,$pr,$order,$sortname,$qtype,$query,$qtype2,$query2, $imprimir=false){
		//if($imprimir)echo "<br>rol $rol, qtype $qtype, query $query, qtype2 $qtype2, query2 $query2";
		$filas = array();
		switch($rol){
			case 1:
			 $filas = $this->Solicitud_model->get_all($inicio,$pr,$order,$sortname,$qtype,$query,'','',$qtype2,$query2, $imprimir);		
			break;
			case 2:			 
			 $programas = explode('*',$this->session->userdata('programas'));
			 $niveles = explode('*',$this->session->userdata('niveles'));
			 $filas = $this->Solicitud_model->get_all_coordinador($inicio,$pr,$order,$sortname,$qtype,$query,$programas,'dep_id',$programas,$niveles,$qtype2,$query2);		 
			break;
			case 3:
			 $login = $this->session->userdata('login');
			 $filas = $this->Solicitud_model->get_all($inicio,$pr,$order,$sortname,$qtype,$query,$login,'sol_login');
			break;
		}
		return $filas;
		
	}
	private function _get_count($rol,$qtype,$query,$qtype2,$query2){
		
		$filas = array();
		switch($rol){
			case 1:
			 $filas = $this->Solicitud_model->get_count($qtype,$query,'','',$qtype2,$query2);		
			break;
			case 2:			 
			 $programas = explode('*',$this->session->userdata('programas'));
			 $niveles = explode('*',$this->session->userdata('niveles'));
			 $filas = $this->Solicitud_model->get_count_coordinador($qtype,$query,$programas,'dep_id',$programas,$niveles,$qtype2,$query2);			
			break;
			case 3:
			 $login = $this->session->userdata('login');
			 $filas = $this->Solicitud_model->get_count($qtype,$query,$login,'sol_login',$qtype2,$query2);
			break;
		}
		return $filas;
		
	}
	
	private function _get_color($id){
		$color = '';		
		$height='10px';
		switch($id){
			case 1 ://En revisión
				$color = '#CC0000';//'#5B86EA';
			break;
			case 2 ://	Finalizado sin solución
				$color = '#7030A0';//'#339933';
			break;
			case 3 ://Finalizado con solución
				$color = '#00B050';//'#66CC66';
			break;
			case 4 ://En espera de respuesta del estudiante 
				$color = '#FFC000';//'#CC9900';
			break;
			case 5 ://En espera de respuesta del coordinador
				$color = '#FF3300';//'#CC6600';
			break;
			case 6 ://Cancelado
				$color = '#000000';//'#333333';
			break;
			case 7 ://No corresponde 
				$color = '#0070C0';//'#CC3300';
			break;				
		}
		//debe ser span y no div porque el width interfiere con la redimensi?n de las columnas a la derecha de la columna estado
		return '<span style="background-color:'.$color.';height:'.$height.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';		
	}
	
	public function validar_crn($crn, $val='') {	
		$this->load->library('integracion');
		$this->load->model('Parametro_model','Parametro_model_crn',TRUE);
		$periodo = $this->Parametro_model_crn->get_item('periodo','par_nombre');
		$periodo = $periodo[0]['par_valor'];
		//unset($this->Parametro_model_crn);
				
		if($val=='') { //saber si es magistral o complementaria
			$rta = ($this->integracion->esMagistral($crn, $periodo)!==false) ? 'mag' : 'no';
			//print_r($this->integracion->esMagistral($crn,));
			if($rta==='no')
				$rta = ($this->integracion->esComplementaria($crn, $periodo)!==false) ? 'com' : 'no';
		}
		else { //comprobar si es magistral o complementaria pasando su valor
			switch($val){
				case 'mag' :
					$rta = ($this->integracion->esMagistral($crn, $periodo)!==false) ? 1 : 0;
				break;
				case 'com' :
					$rta = ($this->integracion->esComplementaria($crn, $periodo)!==false) ? 1: 0;
				break;
			}			
		}
		$rta = $rta==='no' ? 0 : $rta;
		return $rta;
	}
	/*obtiene datos segun el numero de carn?*/
	public function carne(){
		$carne = $this->input->post('carne');
		if($carne){
			//$carne = trim($carne);
			$pidm = $this->integracion->obtenerPidm($carne);
			if($pidm){
				//obtengo el periodo actual
				$this->load->model('Parametro_model','',TRUE);
				$periodo = $this->Parametro_model->get_item('periodo','par_nombre');
				$periodo = $periodo[0]['par_valor'];
				$datos_estudiante = $this->integracion->datosEstudiante($pidm,$periodo);
                $aux = $this->auth_ldap->cargarDatos($carne);
                $datos_estudiante['LOGIN'] = $aux['login'];
                $datos_estudiante['CORREOU'] = $aux['correouniandes'];
				
				//print_r($datos_estudiante);
				
				$retorno_carne = array(
				               'sol_pidm'=>$pidm,
						       'sol_uidnumber'=>$carne,
						       'sol_nombre'=>ucwords(strtolower($datos_estudiante["NOMBRES"])),
						       'sol_apellido'=>ucwords(strtolower($datos_estudiante["APELLIDOS"])),
						       'dep_id'=>$datos_estudiante["CODIGO_PROGRAMA"],
						       'dep_id_sec'=>$datos_estudiante["DOBLE_PROGRAMA"],
						       'sol_nivel'=>$datos_estudiante["NIVEL"],
						       'sol_login'=>$datos_estudiante["LOGIN"],
						       'sol_email'=>$datos_estudiante["CORREOU"]
					);
					
				//obtengo el nivel
				$niveles = $this->Parametro_model->get_item('niveles','par_nombre');
				$niveles = $niveles[0]['par_valor'];
				if($niveles=='1'){
					if($datos_estudiante['NIVEL']!=PREGRADO && $datos_estudiante['NIVEL']!=MAESTRIA){
						echo 'nivel_no_permitido';
					}
					else
						echo json_encode($retorno_carne);
				}
				else
					echo json_encode($retorno_carne);
			}
			else
				echo 'NO';
		}
		else
			echo 'NO';
	}
	/*valida si es posible la creacion segun las fechas de apertura*/
	private function _validar_crear($prog=''){
		/*filtro de limite de creacion  segun el programa principal del estudiante*/
		$programa = $prog!='' ? $prog : $this->session->userdata('programas');		
		//el programa no se pasa por parametro ni esta en la sesi?n para usuario administrador, no validar? limites
		if(empty($prog) || $prog==''){
			return true;
		}
		$this->load->model('Limite_model','',TRUE);
		$limites = $this->Limite_model->get_item($programa,'dep_id');
		//print $programa;
		//var_dump($limites);
		$res = $this->Limite_model->validar_rango_fechas($limites[0]["lim_fec_a_sol"],$limites[0]["lim_fec_c_sol"],date("Y-m-d H:i:s"));
		//var_dump($res);		
		unset($this->Limite_model);
		return $res;
		/**/		
	}
	
	/*valida si es posible la creacion segun las fechas de gestion si pasa el id del
	departamento lo valida para este sino del que haya en sesion*/
	private function _validar_gestion($id_programa=''){
		/*filtro de limite de creacion  segun el programa principal del estudiante*/
		if(empty($id_programa) || $id_programa==''){
			$id_programa = $this->session->userdata('programas');
		}
		//el programa no se pasa por parametro ni esta en la sesi?n para usuario administrador, no validar? limites
		if(empty($id_programa) || $id_programa==''){
			return true;
		}		
		$this->load->model('Limite_model','',TRUE);
		$limites = $this->Limite_model->get_item($id_programa,'dep_id');					 
		//var_dump($limites);
		$res = $this->Limite_model->validar_rango_fechas($limites[0]["lim_fec_a_ges"],$limites[0]["lim_fec_c_ges"],date("Y-m-d H:i:s"));
		//var_dump($res);		
		//unset($this->Limite_model);
		return $res;
		/**/		
	}
	
	public  function ver($sol_id){		
		$menu = $this->Menu_model->_getmenu();
		$data = array();
		if($sol_id){			
			$item = $this->Solicitud_model->get_item($sol_id);				
			$this->load->model('Tipo_model','',TRUE);
			$tipo = $this->Tipo_model->get_item($item[0]['tip_id']);
			unset($this->Tipo_model);
			$this->load->model('Motivo_model','',TRUE);
			$motivo = $this->Motivo_model->get_item($item[0]['mov_id']);
			unset($this->Motivo_model);
			$this->load->model('Estado_model','',TRUE);
			$estado = $this->Estado_model->get_item($item[0]['est_id']);
			$options_estado = $this->Estado_model->get_dropdown();			
			unset($this->Estado_model);
			
			$sol_ins_tipo = ($item[0]['sol_ins_tipo']=='mag' || $item[0]['sol_ins_tipo']=='com') ? $item[0]['sol_ins_tipo'] : 'NORMAL';
			if($sol_ins_tipo!='NORMAL')
				$sol_ins_tipo = ($item[0]['sol_ins_tipo']=='mag') ? 'MAGISTRAL' : 'COMPLEMENTARIA';
			else
				$sol_ins_tipo = $item[0]['sol_ins_crn']!='' ? $sol_ins_tipo : '';
			$sol_ret_tipo = ($item[0]['sol_ret_tipo']=='mag' || $item[0]['sol_ret_tipo']=='com') ? $item[0]['sol_ret_tipo'] : 'NORMAL';
			if($sol_ret_tipo!='NORMAL')
				$sol_ret_tipo = ($item[0]['sol_ret_tipo']=='mag') ? 'MAGISTRAL' : 'COMPLEMENTARIA';
			else
				$sol_ret_tipo = $item[0]['sol_ret_crn']!='' ? $sol_ret_tipo : '';
			$sol_sug_ins_tipo = ($item[0]['sol_sug_ins_tipo']=='mag' || $item[0]['sol_sug_ins_tipo']=='com') ? $item[0]['sol_sug_ins_tipo'] : 'NORMAL';
			if($sol_sug_ins_tipo!='NORMAL')
				$sol_sug_ins_tipo = ($item[0]['sol_sug_ins_tipo']=='mag') ? 'MAGISTRAL' : 'COMPLEMENTARIA';
			else
				$sol_sug_ins_tipo = $item[0]['sol_sug_ins_crn']!='' ? $sol_sug_ins_tipo : '';
			$sol_sug_ret_tipo = ($item[0]['sol_sug_ret_tipo']=='mag' || $item[0]['sol_sug_ret_tipo']=='com') ? $item[0]['sol_sug_ret_tipo'] : 'NORMAL';
			if($sol_sug_ret_tipo!='NORMAL')
				$sol_sug_ret_tipo = ($item[0]['sol_sug_ret_tipo']=='mag') ? 'MAGISTRAL' : 'COMPLEMENTARIA';
			else
				$sol_sug_ret_tipo = $item[0]['sol_sug_ret_crn']!='' ? $sol_sug_ret_tipo : '';
			$item[0]['sol_ins_tipo'] = $sol_ins_tipo;
			$item[0]['sol_ret_tipo'] = $sol_ret_tipo;
			$item[0]['sol_sug_ins_tipo'] = $sol_sug_ins_tipo;
			$item[0]['sol_sug_ret_tipo'] = $sol_sug_ret_tipo;
			$data = array('sol_id' => $item[0]['sol_id'],
				'sol_descripcion' => $item[0]['sol_descripcion'],                                      
				'tip_id' => $item[0]['tip_id'],
				'mov_id' => $item[0]['mov_id'],
				'est_id' => $item[0]['est_id'],
				'dep_id_sec'=>$item[0]['dep_id_sec'],
				'sol_email'=>$item[0]['sol_email'],
				'sol_nombre'=>$item[0]['sol_nombre'],
				'sol_apellido'=>$item[0]['sol_apellido'],
				'sol_fec_creacion'=>$item[0]['sol_fec_creacion'],
				'sol_pidm'=>$item[0]['sol_pidm'],
				'sol_uidnumber'=>$item[0]['sol_uidnumber'],
				
				'sol_login'=>$item[0]['sol_login'],
				
				/*'sol_mag_crn_ret_des' => $item[0]['sol_mag_crn_ret_des'],
				'sol_mag_crn_ret' => $item[0]['sol_mag_crn_ret'],
				'sol_mag_crn_ins_des' => $item[0]['sol_mag_crn_ins_des'],
				'sol_mag_crn_ins' => $item[0]['sol_mag_crn_ins'],
				'sol_com_crn_ret_des' => $item[0]['sol_com_crn_ret_des'],
				'sol_com_crn_ret' => $item[0]['sol_com_crn_ret'],
				'sol_com_crn_ins_des' => $item[0]['sol_com_crn_ins_des'],
				'sol_com_crn_ins' => $item[0]['sol_com_crn_ins'],*/
				'sol_ins_crn' => $item[0]['sol_ins_crn'],
				'sol_ret_crn' => $item[0]['sol_ret_crn'],
				'sol_ins_des' => $item[0]['sol_ins_des'],
				'sol_ret_des' => $item[0]['sol_ret_des'],
				'sol_ins_mat' => $item[0]['sol_ins_mat'],
				'sol_ret_mat' => $item[0]['sol_ret_mat'],
				'sol_sug_ins_crn' => $item[0]['sol_sug_ins_crn'],
				'sol_sug_ret_crn' => $item[0]['sol_sug_ret_crn'],
				'sol_sug_ins_des' => $item[0]['sol_sug_ins_des'],
				'sol_sug_ret_des' => $item[0]['sol_sug_ret_des'],
				'sol_sug_ins_mat' => $item[0]['sol_sug_ins_mat'],
				'sol_sug_ret_mat' => $item[0]['sol_sug_ret_mat'],
				'sol_ins_seccion' => $item[0]['sol_ins_seccion'],
				'sol_ins_instructor' => $item[0]['sol_ins_instructor'],
				'sol_ins_tipo' => $item[0]['sol_ins_tipo'],
				'sol_ret_seccion' => $item[0]['sol_ret_seccion'],
				'sol_ret_instructor' => $item[0]['sol_ret_instructor'],
				'sol_ret_tipo' => $item[0]['sol_ret_tipo'],
				'sol_sug_ins_seccion' => $item[0]['sol_sug_ins_seccion'],
				'sol_sug_ins_instructor' => $item[0]['sol_sug_ins_instructor'],
				'sol_sug_ins_tipo' => $item[0]['sol_sug_ins_tipo'],
				'sol_sug_ret_seccion' => $item[0]['sol_sug_ret_seccion'],
				'sol_sug_ret_instructor' => $item[0]['sol_sug_ret_instructor'],
				'sol_sug_ret_tipo' => $item[0]['sol_sug_ret_tipo'],
				'tipo'=>$tipo[0]['tip_descripcion'],
				'motivo'=>$motivo[0]['mov_descripcion'],
				'estado'=>$estado[0]['est_descripcion'],
				'options_estado'=>$options_estado				
			);
					
			
			$this->load->model('Comentario_model','',TRUE);
			$this->load->model('Rol_model','',TRUE);

			$this->load->model('Parametro_model','',TRUE);
			$comentario_normal = $this->Parametro_model->get_item('comentario normal','par_nombre');
			$comentario_cancelar = $this->Parametro_model->get_item('comentario cancelar','par_nombre');
			$comentario_cambiar_estado = $this->Parametro_model->get_item('comentario cambiar estado','par_nombre');
			//unset($this->Parametro_model);			
			$datac = array('sol_id'=>$sol_id,					
				'com_nombre'=>$this->session->userdata('nombres'),
				'rol_id'=>$this->session->userdata('rol'),
				'accion'=>'',
				'comentario_normal' => $comentario_normal[0]['par_valor'],
				'comentario_cancelar' => $comentario_cancelar[0]['par_valor'],
				'comentario_cambiar_estado' => $comentario_cambiar_estado[0]['par_valor'],
				 );
			unset($this->Comentario_model);
			unset($this->Rol_model);
			$comentario_form = $this->load->view('comentario_form',$datac, true);
			$data['sol_id']=$sol_id;
			$data['accion']='estado';
			$data['titulo'] = 'Detalle';  				
			$data['comentario_form']=$comentario_form;
			$data['menu']=$menu;			
			//otros datos estudiante
			//obtengo el periodo actual
			$this->load->model('Parametro_model','',TRUE);
			$periodo = $this->Parametro_model->get_item('periodo','par_nombre');
			$periodo = $periodo[0]['par_valor'];        
			//
			$datos_estudiante = $this->integracion->datosEstudiante($item[0]['sol_pidm'],$periodo);
			$data['prog'] = $datos_estudiante['PROGRAMA'];  				
			$data['doble_prog'] = $datos_estudiante['DOBLE_PROGRAMA'];  				
			$data['creditos']= $datos_estudiante['CRED_INS'];
			$data['opcion']= $datos_estudiante['OPCION'];
			$data['ssc']= $datos_estudiante['SSC'];
			$data['sol_id'] = $sol_id;
			//obtiene una cadena 'anterior,actual,siguiente'-----------------------------------------------
			$filtros['sortorder'] = $this->session->userdata('sortorder');
			$filtros['sortname'] = $this->session->userdata('sortname');
			$filtros['qtype'] = $this->session->userdata('qtype');
			$filtros['query'] = $this->session->userdata('query');
			$filtros['qtype2'] = $this->session->userdata('qtype2');
			$filtros['query2'] = $this->session->userdata('query2');
			
			$ordenadas = $this->_get_filas($this->session->userdata('rol'),
							    0, 0, //$inicio,$this->session->userdata('cantpag'),
							    $filtros['sortorder'],
							    $filtros['sortname'],
                                $filtros['qtype'],
                                $filtros['query'],
                                $filtros['qtype2'],
                                $filtros['query2'],
								true);//imprimir

			$ordenfilas = '';
			/*echo 'sortorder '.$filtros['sortorder'].' sortname '.$filtros['sortname'];
			echo $filtros['qtype'].'<br>';
			echo $filtros['query'].'<br>';
			echo $filtros['qtype2'].'<br>';
			echo $filtros['query2'].'<br>';*/
			
			//print_r($ordenadas);
			foreach($ordenadas as $indice=>$fila){
			//echo $fila['sol_id'].'<-<br>';
				if($fila['sol_id']==str_replace('-', '', $sol_id)){	
					
					$anterior = $indice == 0 ? $ordenadas[count($ordenadas) - 1]['sol_id'] : $ordenadas[$indice - 1]['sol_id'];
					$siguiente = $indice == count($ordenadas) - 1 ? $ordenadas[0]['sol_id'] : $ordenadas[$indice + 1]['sol_id'];
			
					$ordenfilas = $anterior.';'.$fila['sol_id'].';'.$siguiente; //cadena 'anterior,actual,siguiente'
				
				}
			}				
			//-----------------------------------------------------------------------------------------------
			$data['ordenfilas'] = $ordenfilas;
			$data['ordenfilas_paginado'] = $this->session->userdata('ordenfilas');
			$data['rol_botones'] = $this->session->userdata('rol');			
			$this->load->view('solicitud_form_ver', $data);
		}			
	}
	
	public  function formacancelar($sol_id){		
		$mensaje = '';
		$mensaje_varios = '';
		$ids_habilitados ='';
		$ids_cancelados ='';
		$mensaje_cancelados='';
		$contador=0;
		$contador_c=0;
		$menu = $this->Menu_model->_getmenu();
		$data = array();
		if($sol_id){			
			$lista = trim($sol_id,'-');			
			$lista = explode('-',$lista);			
			foreach($lista as $id_c){				
				$item = $this->Solicitud_model->get_item($id_c);				
				if(!$this->_validar_gestion($item[0]['dep_id'])){			
					$mensaje .= 'El Periodo de gesti&oacute;n de la solicitud de id:'.$id_c.' ha finalizado.<br>';
					$contador++;
				
				//se quita validación para que siempre se pueda cancelar
				}elseif((int)$item[0]['est_id']==0 /*(int)$item[0]['est_id']==6 ||(int)$item[0]['est_id']==2 || (int)$item[0]['est_id']==3*/){
					$ids_cancelados .= $id_c.',';
				}else{
					$mensaje_varios .= $id_c.',';
					$ids_habilitados .= $id_c.',';
				}				
			}			
			if($contador == count($lista)){
				$this->load->view('solicitud_aviso', array('aviso'=>/*'Recuerde que con esta aplicaci&oacute;n solo se reciben solicitudes para las facultades de <strong>Derecho</strong> y <strong>Econom&iacute;a</strong>.'*/ 'El Periodo de gesti&oacute;n de solicitudes ha finalizado.','menu'=>$menu,'titulo'=>'AVISO','no_header'=>'no','rol'=>$this->session->userdata('rol')));
			}elseif($contador_c == count($lista)){
				$this->load->view('solicitud_aviso', array('aviso'=>'Las solicitudes ya han sido canceladas o finalizadas.','menu'=>$menu,'titulo'=>'AVISO','no_header'=>'no','rol'=>$this->session->userdata('rol')));
				
			}else{
				if(count($lista)===1){
					$item = $this->Solicitud_model->get_item($lista[0]);			
					$this->load->model('Tipo_model','',TRUE);
					$tipo = $this->Tipo_model->get_item($item[0]['tip_id']);
					unset($this->Tipo_model);
					$this->load->model('Motivo_model','',TRUE);
					$motivo = $this->Motivo_model->get_item($item[0]['mov_id']);
					unset($this->Motivo_model);
					$this->load->model('Estado_model','',TRUE);
					$estado = $this->Estado_model->get_item($item[0]['est_id']);
					$options_estado = $this->Estado_model->get_dropdown();			
					unset($this->Estado_model);
					
					$sol_ins_tipo = ($item[0]['sol_ins_tipo']=='mag' || $item[0]['sol_ins_tipo']=='com') ? $item[0]['sol_ins_tipo'] : 'NORMAL';
					if($sol_ins_tipo!='NORMAL')
						$sol_ins_tipo = ($item[0]['sol_ins_tipo']=='mag') ? 'MAGISTRAL' : 'COMPLEMENTARIA';
					else
						$sol_ins_tipo = $item[0]['sol_ins_crn']!='' ? $sol_ins_tipo : '';
					$sol_ret_tipo = ($item[0]['sol_ret_tipo']=='mag' || $item[0]['sol_ret_tipo']=='com') ? $item[0]['sol_ret_tipo'] : 'NORMAL';
					if($sol_ret_tipo!='NORMAL')
						$sol_ret_tipo = ($item[0]['sol_ret_tipo']=='mag') ? 'MAGISTRAL' : 'COMPLEMENTARIA';
					else
						$sol_ret_tipo = $item[0]['sol_ret_crn']!='' ? $sol_ret_tipo : '';
					$sol_sug_ins_tipo = ($item[0]['sol_sug_ins_tipo']=='mag' || $item[0]['sol_sug_ins_tipo']=='com') ? $item[0]['sol_sug_ins_tipo'] : 'NORMAL';
					if($sol_sug_ins_tipo!='NORMAL')
						$sol_sug_ins_tipo = ($item[0]['sol_sug_ins_tipo']=='mag') ? 'MAGISTRAL' : 'COMPLEMENTARIA';
					else
						$sol_sug_ins_tipo = $item[0]['sol_sug_ins_crn']!='' ? $sol_sug_ins_tipo : '';
					$sol_sug_ret_tipo = ($item[0]['sol_sug_ret_tipo']=='mag' || $item[0]['sol_sug_ret_tipo']=='com') ? $item[0]['sol_sug_ret_tipo'] : 'NORMAL';
					if($sol_sug_ret_tipo!='NORMAL')
						$sol_sug_ret_tipo = ($item[0]['sol_sug_ret_tipo']=='mag') ? 'MAGISTRAL' : 'COMPLEMENTARIA';
					else
						$sol_sug_ret_tipo = $item[0]['sol_sug_ret_crn']!='' ? $sol_sug_ret_tipo : '';
					$item[0]['sol_ins_tipo'] = $sol_ins_tipo;
					$item[0]['sol_ret_tipo'] = $sol_ret_tipo;
					$item[0]['sol_sug_ins_tipo'] = $sol_sug_ins_tipo;
					$item[0]['sol_sug_ret_tipo'] = $sol_sug_ret_tipo;
					$data = array('sol_id' => $item[0]['sol_id'],
						'sol_descripcion' => $item[0]['sol_descripcion'],                                      
						'tip_id' => $item[0]['tip_id'],
						'mov_id' => $item[0]['mov_id'],
						'est_id' => $item[0]['est_id'],
						'dep_id_sec'=>$item[0]['dep_id_sec'],
						'sol_email'=>$item[0]['sol_email'],
						'sol_nombre'=>$item[0]['sol_nombre'],
						'sol_apellido'=>$item[0]['sol_apellido'],
						'sol_fec_creacion'=>$item[0]['sol_fec_creacion'],
						'sol_pidm'=>$item[0]['sol_pidm'],
						'sol_uidnumber'=>$item[0]['sol_uidnumber'],
						/*'sol_mag_crn_ret_des' => $item[0]['sol_mag_crn_ret_des'],
						'sol_mag_crn_ret' => $item[0]['sol_mag_crn_ret'],
						'sol_mag_crn_ins_des' => $item[0]['sol_mag_crn_ins_des'],
						'sol_mag_crn_ins' => $item[0]['sol_mag_crn_ins'],
						'sol_com_crn_ret_des' => $item[0]['sol_com_crn_ret_des'],
						'sol_com_crn_ret' => $item[0]['sol_com_crn_ret'],
						'sol_com_crn_ins_des' => $item[0]['sol_com_crn_ins_des'],
						'sol_com_crn_ins' => $item[0]['sol_com_crn_ins'],*/
						'sol_ins_crn' => $item[0]['sol_ins_crn'],
						'sol_ret_crn' => $item[0]['sol_ret_crn'],
						'sol_ins_des' => $item[0]['sol_ins_des'],
						'sol_ret_des' => $item[0]['sol_ret_des'],
						'sol_ins_mat' => $item[0]['sol_ins_mat'],
						'sol_ret_mat' => $item[0]['sol_ret_mat'],
						'sol_sug_ins_crn' => $item[0]['sol_sug_ins_crn'],
						'sol_sug_ret_crn' => $item[0]['sol_sug_ret_crn'],
						'sol_sug_ins_des' => $item[0]['sol_sug_ins_des'],
						'sol_sug_ret_des' => $item[0]['sol_sug_ret_des'],
						'sol_sug_ins_mat' => $item[0]['sol_sug_ins_mat'],
						'sol_sug_ret_mat' => $item[0]['sol_sug_ret_mat'],
						'sol_ins_seccion' => $item[0]['sol_ins_seccion'],
						'sol_ins_instructor' => $item[0]['sol_ins_instructor'],
						'sol_ins_tipo' => $item[0]['sol_ins_tipo'],
						'sol_ret_seccion' => $item[0]['sol_ret_seccion'],
						'sol_ret_instructor' => $item[0]['sol_ret_instructor'],
						'sol_ret_tipo' => $item[0]['sol_ret_tipo'],
						'sol_sug_ins_seccion' => $item[0]['sol_sug_ins_seccion'],
						'sol_sug_ins_instructor' => $item[0]['sol_sug_ins_instructor'],
						'sol_sug_ins_tipo' => $item[0]['sol_sug_ins_tipo'],
						'sol_sug_ret_seccion' => $item[0]['sol_sug_ret_seccion'],
						'sol_sug_ret_instructor' => $item[0]['sol_sug_ret_instructor'],
						'sol_sug_ret_tipo' => $item[0]['sol_sug_ret_tipo'],
						'tipo'=>$tipo[0]['tip_descripcion'],
						'motivo'=>$motivo[0]['mov_descripcion'],
						'estado'=>$estado[0]['est_descripcion'],
						'options_estado'=>$options_estado,
						'tipo'=>'uno',
						);
					
				}else{
					/*mensaje cuando son varios ids*/
					$mensaje_varios = trim($mensaje_varios,',');
					$mensaje_varios = 'Se van a modificar las solicitudes con los siguientes ID: '.$mensaje_varios.'.';
					$data['mensaje_gestion']=$mensaje;
					$data['mensaje_varios']=$mensaje_varios;
					$data['mensaje_cancelados']= $ids_cancelados=='' ? '' : 'Ya presentan estado cancelado o finalizado las solicitudes con los siguientes ID:'.trim($ids_cancelados,',').'.';
					$data['tipo']='varios';						
				}
				$this->load->model('Comentario_model','',TRUE);
				$this->load->model('Rol_model','',TRUE);

				$this->load->model('Parametro_model','',TRUE);
				$comentario_normal = $this->Parametro_model->get_item('comentario normal','par_nombre');
				$comentario_cancelar = $this->Parametro_model->get_item('comentario cancelar','par_nombre');
				$comentario_cambiar_estado = $this->Parametro_model->get_item('comentario cambiar estado','par_nombre');
				unset($this->Parametro_model);				
				$datac = array('sol_id'=>$sol_id,					
					'com_nombre'=>$this->session->userdata('nombres'),
					'rol_id'=>$this->session->userdata('rol'),
					'accion'=>'',
					'comentario_normal' => $comentario_normal[0]['par_valor'],
					'comentario_cancelar' => $comentario_cancelar[0]['par_valor'],
					'comentario_cambiar_estado' => $comentario_cambiar_estado[0]['par_valor'],
					);
				//$this->_prepare_list_comentario($datac, $id, $this->Comentario_model, false);
				unset($this->Comentario_model);
				unset($this->Rol_model);
				$comentario_form = $this->load->view('comentario_form',$datac, true);
				$data['sol_id']=$sol_id;
				$data['accion']='estado';
				$data['titulo'] = 'Cancelar';  				
				$data['comentario_form']=$comentario_form;
				$data['menu']=$menu;
				$data['ids_habilitados']=$ids_habilitados;
				//$data['sol_id'] = $sol_id;
				//obtiene una cadena 'anterior,actual,siguiente'-----------------------------------------------
				$filtros['sortorder'] = $this->session->userdata('sortorder');
				$filtros['sortname'] = $this->session->userdata('sortname');
				$filtros['qtype'] = $this->session->userdata('qtype');
				$filtros['query'] = $this->session->userdata('query');
				$filtros['qtype2'] = $this->session->userdata('qtype2');
				$filtros['query2'] = $this->session->userdata('query2');
				
				$ordenadas = $this->_get_filas($this->session->userdata('rol'),
									0, 0, //$inicio,$this->session->userdata('cantpag'),
									$filtros['sortorder'],
									$filtros['sortname'],
									$filtros['qtype'],
									$filtros['query'],
									$filtros['qtype2'],
									$filtros['query2'],
									true);//imprimir

				$ordenfilas = '';
				/*echo 'sortorder '.$filtros['sortorder'].' sortname '.$filtros['sortname'];
				echo $filtros['qtype'].'<br>';
				echo $filtros['query'].'<br>';
				echo $filtros['qtype2'].'<br>';
				echo $filtros['query2'].'<br>';*/
				
				//print_r($ordenadas);
				foreach($ordenadas as $indice=>$fila){
				//echo $fila['sol_id'].'<-<br>';
					if($fila['sol_id']==str_replace('-', '', $sol_id)){	
						
						$anterior = $indice == 0 ? $ordenadas[count($ordenadas) - 1]['sol_id'] : $ordenadas[$indice - 1]['sol_id'];
						$siguiente = $indice == count($ordenadas) - 1 ? $ordenadas[0]['sol_id'] : $ordenadas[$indice + 1]['sol_id'];
				
						$ordenfilas = $anterior.';'.$fila['sol_id'].';'.$siguiente; //cadena 'anterior,actual,siguiente'
					
					}
				}				
				//-----------------------------------------------------------------------------------------------
				$data['ordenfilas'] = $ordenfilas;
				$data['ordenfilas_paginado'] = $this->session->userdata('ordenfilas');
				$data['rol_botones'] = $this->session->userdata('rol');
				$this->load->view('solicitud_form_cancelar', $data);
			}			
					
		}			
	}
	public  function formaestado($sol_id){		
		$mensaje = '';
		$mensaje_cancelados='';
		$mensaje_varios = '';
		$ids_cancelados ='';
		$ids_habilitados ='';
		$contador=0;
		$contador_c=0;
		$menu = $this->Menu_model->_getmenu();
		$data = array();
		$this->load->model('Estado_model','',TRUE);
		$options_estado = $this->Estado_model->get_dropdown(TRUE);										
					
		if($sol_id){			
			$lista = trim($sol_id,'-');			
			$lista = explode('-',$lista);			
			foreach($lista as $id_c){				
				$item = $this->Solicitud_model->get_item($id_c);				
				if(!$this->_validar_gestion($item[0]['dep_id'])){			
					$mensaje .= 'El Periodo de gesti&oacute;n de la solicitud de id:'.$id_c.' ha finalizado.<br>';
					$contador++;
					
				//se quita validación para que siempre se pueda cambiar estado
				}elseif((int)$item[0]['est_id']==0 /*(int)$item[0]['est_id']==6||(int)$item[0]['est_id']==2 || (int)$item[0]['est_id']==3*/){
					$ids_cancelados .= $id_c.',';
				}else{
					$mensaje_varios .= $id_c.',';
					$ids_habilitados .= $id_c.',';
				}				
			}			
			if($contador == count($lista)){
				$this->load->view('solicitud_aviso', array('aviso'=>/*'Recuerde que con esta aplicaci&oacute;n solo se reciben solicitudes para las facultades de <strong>Derecho</strong> y <strong>Econom&iacute;a</strong>.'*/ 'El Periodo de gesti&oacute;n de solicitudes ha finalizado.','menu'=>$menu,'titulo'=>'AVISO','no_header'=>'no','rol'=>$this->session->userdata('rol')));
				
			}elseif($contador_c == count($lista)){
				$this->load->view('solicitud_aviso', array('aviso'=>'Las solicitudes ya han sido canceladas o finalizadas.','menu'=>$menu,'titulo'=>'AVISO','no_header'=>'no','rol'=>$this->session->userdata('rol')));
				
			}else{
				if(count($lista)===1){
					$estado = $this->Estado_model->get_item($item[0]['est_id']);
					$item = $this->Solicitud_model->get_item($lista[0]);			
					$this->load->model('Tipo_model','',TRUE);
					$tipo = $this->Tipo_model->get_item($item[0]['tip_id']);
					unset($this->Tipo_model);
					$this->load->model('Motivo_model','',TRUE);
					$motivo = $this->Motivo_model->get_item($item[0]['mov_id']);
					unset($this->Motivo_model);
					
					$sol_ins_tipo = ($item[0]['sol_ins_tipo']=='mag' || $item[0]['sol_ins_tipo']=='com') ? $item[0]['sol_ins_tipo'] : 'NORMAL';
					if($sol_ins_tipo!='NORMAL')
						$sol_ins_tipo = ($item[0]['sol_ins_tipo']=='mag') ? 'MAGISTRAL' : 'COMPLEMENTARIA';
					else
						$sol_ins_tipo = $item[0]['sol_ins_crn']!='' ? $sol_ins_tipo : '';
					$sol_ret_tipo = ($item[0]['sol_ret_tipo']=='mag' || $item[0]['sol_ret_tipo']=='com') ? $item[0]['sol_ret_tipo'] : 'NORMAL';
					if($sol_ret_tipo!='NORMAL')
						$sol_ret_tipo = ($item[0]['sol_ret_tipo']=='mag') ? 'MAGISTRAL' : 'COMPLEMENTARIA';
					else
						$sol_ret_tipo = $item[0]['sol_ret_crn']!='' ? $sol_ret_tipo : '';
					$sol_sug_ins_tipo = ($item[0]['sol_sug_ins_tipo']=='mag' || $item[0]['sol_sug_ins_tipo']=='com') ? $item[0]['sol_sug_ins_tipo'] : 'NORMAL';
					if($sol_sug_ins_tipo!='NORMAL')
						$sol_sug_ins_tipo = ($item[0]['sol_sug_ins_tipo']=='mag') ? 'MAGISTRAL' : 'COMPLEMENTARIA';
					else
						$sol_sug_ins_tipo = $item[0]['sol_sug_ins_crn']!='' ? $sol_sug_ins_tipo : '';
					$sol_sug_ret_tipo = ($item[0]['sol_sug_ret_tipo']=='mag' || $item[0]['sol_sug_ret_tipo']=='com') ? $item[0]['sol_sug_ret_tipo'] : 'NORMAL';
					if($sol_sug_ret_tipo!='NORMAL')
						$sol_sug_ret_tipo = ($item[0]['sol_sug_ret_tipo']=='mag') ? 'MAGISTRAL' : 'COMPLEMENTARIA';
					else
						$sol_sug_ret_tipo = $item[0]['sol_sug_ret_crn']!='' ? $sol_sug_ret_tipo : '';
					$item[0]['sol_ins_tipo'] = $sol_ins_tipo;
					$item[0]['sol_ret_tipo'] = $sol_ret_tipo;
					$item[0]['sol_sug_ins_tipo'] = $sol_sug_ins_tipo;
					$item[0]['sol_sug_ret_tipo'] = $sol_sug_ret_tipo;
					$data = array('sol_id' => $item[0]['sol_id'],
						      'sol_descripcion' => $item[0]['sol_descripcion'],                                      
						      'tip_id' => $item[0]['tip_id'],
						      'mov_id' => $item[0]['mov_id'],
						      'est_id' => $item[0]['est_id'],
						      'dep_id_sec'=>$item[0]['dep_id_sec'],
						      'sol_email'=>$item[0]['sol_email'],
						      'sol_nombre'=>$item[0]['sol_nombre'],
						      'sol_apellido'=>$item[0]['sol_apellido'],
						      'sol_fec_creacion'=>$item[0]['sol_fec_creacion'],
						      'sol_pidm'=>$item[0]['sol_pidm'],
						      'sol_uidnumber'=>$item[0]['sol_uidnumber'],
						      /*'sol_mag_crn_ret_des' => $item[0]['sol_mag_crn_ret_des'],
						      'sol_mag_crn_ret' => $item[0]['sol_mag_crn_ret'],
						      'sol_mag_crn_ins_des' => $item[0]['sol_mag_crn_ins_des'],
						      'sol_mag_crn_ins' => $item[0]['sol_mag_crn_ins'],
						      'sol_com_crn_ret_des' => $item[0]['sol_com_crn_ret_des'],
						      'sol_com_crn_ret' => $item[0]['sol_com_crn_ret'],
						      'sol_com_crn_ins_des' => $item[0]['sol_com_crn_ins_des'],
						      'sol_com_crn_ins' => $item[0]['sol_com_crn_ins'],*/
								'sol_ins_crn' => $item[0]['sol_ins_crn'],
								'sol_ret_crn' => $item[0]['sol_ret_crn'],
								'sol_ins_des' => $item[0]['sol_ins_des'],
								'sol_ret_des' => $item[0]['sol_ret_des'],
								'sol_ins_mat' => $item[0]['sol_ins_mat'],
								'sol_ret_mat' => $item[0]['sol_ret_mat'],
								'sol_sug_ins_crn' => $item[0]['sol_sug_ins_crn'],
								'sol_sug_ret_crn' => $item[0]['sol_sug_ret_crn'],
								'sol_sug_ins_des' => $item[0]['sol_sug_ins_des'],
								'sol_sug_ret_des' => $item[0]['sol_sug_ret_des'],
								'sol_sug_ins_mat' => $item[0]['sol_sug_ins_mat'],
								'sol_sug_ret_mat' => $item[0]['sol_sug_ret_mat'],
								'sol_ins_seccion' => $item[0]['sol_ins_seccion'],
								'sol_ins_instructor' => $item[0]['sol_ins_instructor'],
								'sol_ins_tipo' => $item[0]['sol_ins_tipo'],
								'sol_ret_seccion' => $item[0]['sol_ret_seccion'],
								'sol_ret_instructor' => $item[0]['sol_ret_instructor'],
								'sol_ret_tipo' => $item[0]['sol_ret_tipo'],
								'sol_sug_ins_seccion' => $item[0]['sol_sug_ins_seccion'],
								'sol_sug_ins_instructor' => $item[0]['sol_sug_ins_instructor'],
								'sol_sug_ins_tipo' => $item[0]['sol_sug_ins_tipo'],
								'sol_sug_ret_seccion' => $item[0]['sol_sug_ret_seccion'],
								'sol_sug_ret_instructor' => $item[0]['sol_sug_ret_instructor'],
								'sol_sug_ret_tipo' => $item[0]['sol_sug_ret_tipo'],
						      'tipo'=>$tipo[0]['tip_descripcion'],
						      'motivo'=>$motivo[0]['mov_descripcion'],
						      'estado'=>$estado[0]['est_descripcion'],						      
						      'tipo_entrada'=>'uno',
						);
					
				}else{
					/*mensaje cuando son varios ids*/
					$mensaje_varios = trim($mensaje_varios,',');
					$mensaje_varios = 'Se van a modificar las solicitudes con los siguientes ID: '.$mensaje_varios.'.';
					$data['mensaje_gestion']=$mensaje;
					$data['mensaje_varios']=$mensaje_varios;
					$data['mensaje_cancelados']= $ids_cancelados=='' ? '' : 'Presentan estado cancelado o finalizado  las solicitudes con los siguientes ID:'.trim($ids_cancelados,',').'.';
					$data['tipo_entrada']='varios';						
				}
				$this->load->model('Comentario_model','',TRUE);
				$this->load->model('Rol_model','',TRUE);
				$this->load->model('Parametro_model','',TRUE);
				$comentario_normal = $this->Parametro_model->get_item('comentario normal','par_nombre');
				$comentario_cancelar = $this->Parametro_model->get_item('comentario cancelar','par_nombre');
				$comentario_cambiar_estado = $this->Parametro_model->get_item('comentario cambiar estado','par_nombre');
				unset($this->Parametro_model);				
				$datac = array('sol_id'=>$sol_id,					
					'com_nombre'=>$this->session->userdata('nombres'),
					'rol_id'=>$this->session->userdata('rol'),
					'accion'=>'',
					'comentario_normal' => $comentario_normal[0]['par_valor'],
					'comentario_cancelar' => $comentario_cancelar[0]['par_valor'],
					'comentario_cambiar_estado' => $comentario_cambiar_estado[0]['par_valor'],
					);
				//$this->_prepare_list_comentario($datac, $id, $this->Comentario_model, false);
				unset($this->Comentario_model);
				unset($this->Rol_model);
				
				$comentario_form = $this->load->view('comentario_form',$datac, true);
				$data['sol_id']=$sol_id;
				$data['accion']='estado';
				$data['titulo'] = 'Cambiar estado';  				
				$data['comentario_form']=$comentario_form;
				$data['menu']=$menu;
				$data['ids_habilitados']=$ids_habilitados;
				$data['options_estado']=$options_estado;
				//$data['sol_id'] = $sol_id;				
				//obtiene una cadena 'anterior,actual,siguiente'-----------------------------------------------
				$filtros['sortorder'] = $this->session->userdata('sortorder');
				$filtros['sortname'] = $this->session->userdata('sortname');
				$filtros['qtype'] = $this->session->userdata('qtype');
				$filtros['query'] = $this->session->userdata('query');
				$filtros['qtype2'] = $this->session->userdata('qtype2');
				$filtros['query2'] = $this->session->userdata('query2');
				
				$ordenadas = $this->_get_filas($this->session->userdata('rol'),
									0, 0, //$inicio,$this->session->userdata('cantpag'),
									$filtros['sortorder'],
									$filtros['sortname'],
									$filtros['qtype'],
									$filtros['query'],
									$filtros['qtype2'],
									$filtros['query2'],
									true);//imprimir

				$ordenfilas = '';
				/*echo 'sortorder '.$filtros['sortorder'].' sortname '.$filtros['sortname'];
				echo $filtros['qtype'].'<br>';
				echo $filtros['query'].'<br>';
				echo $filtros['qtype2'].'<br>';
				echo $filtros['query2'].'<br>';*/
				
				//print_r($ordenadas);
				foreach($ordenadas as $indice=>$fila){
				//echo $fila['sol_id'].'<-<br>';
					if($fila['sol_id']==str_replace('-', '', $sol_id)){	
						
						$anterior = $indice == 0 ? $ordenadas[count($ordenadas) - 1]['sol_id'] : $ordenadas[$indice - 1]['sol_id'];
						$siguiente = $indice == count($ordenadas) - 1 ? $ordenadas[0]['sol_id'] : $ordenadas[$indice + 1]['sol_id'];
				
						$ordenfilas = $anterior.';'.$fila['sol_id'].';'.$siguiente; //cadena 'anterior,actual,siguiente'
					
					}
				}				
				//-----------------------------------------------------------------------------------------------
				$data['ordenfilas'] = $ordenfilas;
				$data['ordenfilas_paginado'] = $this->session->userdata('ordenfilas');
				$data['rol_botones'] = $this->session->userdata('rol');
				$this->load->view('solicitud_form_estado', $data);
			}			
					
		}			
	}
	
	public function enviarCorreo($tipo_correo, $to2, $subject2, $id, $cc2='', $bcc2=''){
		//echo "to2 $to2, subject2 $subject2, id $id, cc2 $cc2, bcc2 $bcc2";
		$this->load->model('Parametro_model','Parametro_model_correo',TRUE);
		$correo_from = $this->Parametro_model_correo->get_item('correo_from','par_nombre');
		$nombre_from = $this->Parametro_model_correo->get_item('nombre_from','par_nombre');
		//unset($this->Parametro_model_correo);
		
		$this->email->from($correo_from[0]['par_valor'], $nombre_from[0]['par_valor']);
		$this->email->to($to2);
		if($cc2!='')
			$this->email->cc($cc2);
		if($bcc2!='')
			$this->email->bcc($bcc2);
		$this->email->subject($subject2);
				
		$item = $this->Solicitud_model->get_item($id);
		
		$this->load->model('Tipo_model','Tipo_model_correo',TRUE);
		$tipo = $this->Tipo_model_correo->get_item($item[0]['tip_id']);
		//unset($this->Tipo_model_correo);
		$this->load->model('Motivo_model','Motivo_model_correo',TRUE);
		$motivo = $this->Motivo_model_correo->get_item($item[0]['mov_id']);
		//unset($this->Motivo_model_correo);
		$this->load->model('Estado_model','Estado_model_correo',TRUE);
		$estado = $this->Estado_model_correo->get_item($item[0]['est_id']);
		//unset($this->Estado_model_correo);
		$this->load->model('Rol_model','Rol_model_correo',TRUE);
		$rol = $this->Rol_model_correo->get_item($this->session->userdata('rol'));
		//unset($this->Rol_model_correo);
		$this->load->model('Comentario_model','Comentario_model_correo',TRUE); //esta linea adiciona tabulado al OK
		$comentario = $this->Comentario_model_correo->get_item($this->Comentario_model_correo->get_last($id, 'sol_id'));
		//unset($this->Comentario_model_correo);
		
		$sol_ins_tipo = ($item[0]['sol_ins_tipo']=='mag' || $item[0]['sol_ins_tipo']=='com') ? $item[0]['sol_ins_tipo'] : 'NORMAL';
		if($sol_ins_tipo!='NORMAL')
			$sol_ins_tipo = ($item[0]['sol_ins_tipo']=='mag') ? 'MAGISTRAL' : 'COMPLEMENTARIA';
		else
			$sol_ins_tipo = $item[0]['sol_ins_crn']!='' ? $sol_ins_tipo : '';
		$sol_ret_tipo = ($item[0]['sol_ret_tipo']=='mag' || $item[0]['sol_ret_tipo']=='com') ? $item[0]['sol_ret_tipo'] : 'NORMAL';
		if($sol_ret_tipo!='NORMAL')
			$sol_ret_tipo = ($item[0]['sol_ret_tipo']=='mag') ? 'MAGISTRAL' : 'COMPLEMENTARIA';
		else
			$sol_ret_tipo = $item[0]['sol_ret_crn']!='' ? $sol_ret_tipo : '';
		$sol_sug_ins_tipo = ($item[0]['sol_sug_ins_tipo']=='mag' || $item[0]['sol_sug_ins_tipo']=='com') ? $item[0]['sol_sug_ins_tipo'] : 'NORMAL';
		if($sol_sug_ins_tipo!='NORMAL')
			$sol_sug_ins_tipo = ($item[0]['sol_sug_ins_tipo']=='mag') ? 'MAGISTRAL' : 'COMPLEMENTARIA';
		else
			$sol_sug_ins_tipo = $item[0]['sol_sug_ins_crn']!='' ? $sol_sug_ins_tipo : '';
		$sol_sug_ret_tipo = ($item[0]['sol_sug_ret_tipo']=='mag' || $item[0]['sol_sug_ret_tipo']=='com') ? $item[0]['sol_sug_ret_tipo'] : 'NORMAL';
		if($sol_sug_ret_tipo!='NORMAL')
			$sol_sug_ret_tipo = ($item[0]['sol_sug_ret_tipo']=='mag') ? 'MAGISTRAL' : 'COMPLEMENTARIA';
		else
			$sol_sug_ret_tipo = $item[0]['sol_sug_ret_crn']!='' ? $sol_sug_ret_tipo : '';
			
		$tipo_crn_ins = $this->nombre_tipo(@$sol_ins_tipo);
		$tipo_crn_ret = $this->nombre_tipo(@$sol_ins_tipo, 'sug');
			
		$item[0]['sol_ins_tipo'] = $sol_ins_tipo;
		$item[0]['sol_ret_tipo'] = $sol_ret_tipo;
		$item[0]['sol_sug_ins_tipo'] = $sol_sug_ins_tipo;
		$item[0]['sol_sug_ret_tipo'] = $sol_sug_ret_tipo;
		$data = array('sol_id' => $item[0]['sol_id'],
			'sol_descripcion' => $item[0]['sol_descripcion'],                                      
			'tip_id' => $item[0]['tip_id'],
			'mov_id' => $item[0]['mov_id'],
			'est_id' => $item[0]['est_id'],
			'dep_id_sec'=>$item[0]['dep_id_sec'],
			'sol_email'=>$item[0]['sol_email'],
			'sol_nombre'=>$item[0]['sol_nombre'],
			'sol_apellido'=>$item[0]['sol_apellido'],
			'sol_fec_creacion'=>$item[0]['sol_fec_creacion'],
			'sol_pidm'=>$item[0]['sol_pidm'],
			'sol_uidnumber'=>$item[0]['sol_uidnumber'],
			/*'sol_mag_crn_ret_des' => $item[0]['sol_mag_crn_ret_des'],
			'sol_mag_crn_ret' => $item[0]['sol_mag_crn_ret'],
			'sol_mag_crn_ins_des' => $item[0]['sol_mag_crn_ins_des'],
			'sol_mag_crn_ins' => $item[0]['sol_mag_crn_ins'],
			'sol_com_crn_ret_des' => $item[0]['sol_com_crn_ret_des'],
			'sol_com_crn_ret' => $item[0]['sol_com_crn_ret'],
			'sol_com_crn_ins_des' => $item[0]['sol_com_crn_ins_des'],
			'sol_com_crn_ins' => $item[0]['sol_com_crn_ins'],*/
			'sol_ins_crn' => $item[0]['sol_ins_crn'],
			'sol_ret_crn' => $item[0]['sol_ret_crn'],
			'sol_ins_des' => $item[0]['sol_ins_des'],
			'sol_ret_des' => $item[0]['sol_ret_des'],
			'sol_ins_mat' => $item[0]['sol_ins_mat'],
			'sol_ret_mat' => $item[0]['sol_ret_mat'],
			'sol_sug_ins_crn' => $item[0]['sol_sug_ins_crn'],
			'sol_sug_ret_crn' => $item[0]['sol_sug_ret_crn'],
			'sol_sug_ins_des' => $item[0]['sol_sug_ins_des'],
			'sol_sug_ret_des' => $item[0]['sol_sug_ret_des'],
			'sol_sug_ins_mat' => $item[0]['sol_sug_ins_mat'],
			'sol_sug_ret_mat' => $item[0]['sol_sug_ret_mat'],
			'sol_ins_seccion' => $item[0]['sol_ins_seccion'],
			'sol_ins_instructor' => $item[0]['sol_ins_instructor'],
			'sol_ins_tipo' => $item[0]['sol_ins_tipo'],
			'sol_ret_seccion' => $item[0]['sol_ret_seccion'],
			'sol_ret_instructor' => $item[0]['sol_ret_instructor'],
			'sol_ret_tipo' => $item[0]['sol_ret_tipo'],
			'sol_sug_ins_seccion' => $item[0]['sol_sug_ins_seccion'],
			'sol_sug_ins_instructor' => $item[0]['sol_sug_ins_instructor'],
			'sol_sug_ins_tipo' => $item[0]['sol_sug_ins_tipo'],
			'sol_sug_ret_seccion' => $item[0]['sol_sug_ret_seccion'],
			'sol_sug_ret_instructor' => $item[0]['sol_sug_ret_instructor'],
			'sol_sug_ret_tipo' => $item[0]['sol_sug_ret_tipo'],
			'sol_ticket'=>$item[0]['sol_ticket'],
			'tipo'=>$tipo[0]['tip_descripcion'],
			'motivo'=>$motivo[0]['mov_descripcion'],
			'estado'=>$estado[0]['est_descripcion'],
			'rol_descripcion'=>$rol[0]['rol_descripcion'],			
			'tipo_crn_ins'=>$tipo_crn_ins,
			'tipo_crn_ret'=>$tipo_crn_ret,			
			);
		$data = array_merge($data, (array)@$comentario[0]);

		foreach($data as $clave=>$valor){
			$data[$clave] = utf8_decode($valor);
		}
		
		switch($tipo_correo){
			case 'crear':
				$plantilla = 'solicitud_correo';
			break;
			case 'cancelar':			 
				$plantilla = 'estado_correo';
			break;
			case 'estado':
				$plantilla = 'estado_correo';
			break;
			case 'comentario':
				$plantilla = 'comentario_correo';
			break;
		}	
		$message2 = $this->load->view($plantilla, $data, true);
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
	
	public function mensaje($tipo){
		$menu = $this->Menu_model->_getmenu();
		$mensaje='';
		switch($tipo){
			case 1:
				$mensaje = /*'Recuerde que con esta aplicaci&oacute;n solo se reciben solicitudes para las facultades de <strong>Derecho</strong> y <strong>Econom&iacute;a</strong>.'*/ 'El Periodo de creaci&oacute;n de solicitudes ha finalizado.';
				break;
			case 2:
				break;
		}
		$no_header = $this->session->userdata('rol')!=3 /*estudiante*/ ? 'si' : 'no'; 
		$this->load->view('solicitud_aviso', array('aviso'=>$mensaje,'menu'=>$menu,'titulo'=>'AVISO',
				'rol'=>$this->session->userdata('rol'),'no_header'=>$no_header
		));		
	}
	public function columnasno(){
		$columnas = $this->input->post('ocultas');
		$datos_sesion= array('colocultas'=>'');
		$this->session->set_userdata($datos_sesion);
		redirect(base_url().'index.php/solicitud');
	}
	
	function nombre_tipo($tipo, $sug=''){
		switch($tipo){
			case 'MAGISTRAL':
				$nombre_tipo = $sug=='' ? ' Magistral' : ' Complementaria';
				break;
			case 'COMPLEMENTARIA':
				$nombre_tipo = $sug=='' ? ' Complementaria' : ' Magistral';
				break;
			default:
			   $nombre_tipo = '';
		}
		return $nombre_tipo;
	}
	
	
	public function formacomentario($sol_id){		
		$mensaje = '';
		$mensaje_varios = '';
		$ids_habilitados ='';
		$ids_cancelados ='';
		$mensaje_cancelados='';
		$contador=0;
		$contador_c=0;
		$menu = $this->Menu_model->_getmenu();
		$data = array();
		if($sol_id){			
			$lista = trim($sol_id,'-');			
			$lista = explode('-',$lista);			
			foreach($lista as $id_c){				
				$item = $this->Solicitud_model->get_item($id_c);				
				if(!$this->_validar_gestion($item[0]['dep_id'])){			
					$mensaje .= 'El Periodo de gesti&oacute;n de la solicitud de id:'.$id_c.' ha finalizado.<br>';
					$contador++;
				
				}elseif(!((($item[0]['est_id']=='1'/*En revisi?n*/ || $item[0]['est_id']=='5'/*En espera de respuesta del coordinador*/) && ($this->session->userdata('rol')=='2'/*Coordinador*/ || $this->session->userdata('rol')=='1'/*Administrador*/)) || 
				($item[0]['est_id']=='4'/*En espera de respuesta del estudiante*/ && $this->session->userdata('rol')=='3'/*Estudiante*/))){
					$ids_cancelados .= $id_c.','; //no se pueden comentar por su estado
				}else{
					$mensaje_varios .= $id_c.',';
					$ids_habilitados .= $id_c.',';
				}				
			}			
			if($contador == count($lista)){
				$this->load->view('solicitud_aviso', array('aviso'=>/*'Recuerde que con esta aplicaci&oacute;n solo se reciben solicitudes para las facultades de <strong>Derecho</strong> y <strong>Econom&iacute;a</strong>.'*/ 'El Periodo de gesti&oacute;n de solicitudes ha finalizado.','menu'=>$menu,'titulo'=>'AVISO','no_header'=>'no','rol'=>$this->session->userdata('rol')));
			}elseif($contador_c == count($lista)){
				$this->load->view('solicitud_aviso', array('aviso'=>'No se pueden enviar comentarios debido al estado de las solicitudes.','menu'=>$menu,'titulo'=>'AVISO','no_header'=>'no','rol'=>$this->session->userdata('rol')));
				
			}else{
				if(count($lista)===1){
					$this->comentario($sol_id);
				}else{
					/*mensaje cuando son varios ids*/
					$mensaje_varios = trim($mensaje_varios,',');
					$mensaje_varios = 'Se van a enviar comentarios a las solicitudes con los siguientes ID: '.$mensaje_varios.'.';
					$data['mensaje_gestion']=$mensaje;
					$data['mensaje_varios']=$mensaje_varios;
					$data['mensaje_cancelados']= $ids_cancelados=='' ? '' : 'No se pueden enviar comentarios debido al estado de las solicitudes con los siguientes ID:'.trim($ids_cancelados,',').'.';
					$data['tipo']='varios';						
				}
				$this->load->model('Comentario_model','',TRUE);
				$this->load->model('Rol_model','',TRUE);

				$this->load->model('Parametro_model','',TRUE);
				$comentario_normal = $this->Parametro_model->get_item('comentario normal','par_nombre');
				$comentario_cancelar = $this->Parametro_model->get_item('comentario cancelar','par_nombre');
				$comentario_cambiar_estado = $this->Parametro_model->get_item('comentario cambiar estado','par_nombre');
				unset($this->Parametro_model);				
				$datac = array('sol_id'=>$sol_id,					
					'com_nombre'=>$this->session->userdata('nombres'),
					'rol_id'=>$this->session->userdata('rol'),
					'accion'=>'',
					'comentario_normal' => $comentario_normal[0]['par_valor'],
					'comentario_cancelar' => $comentario_cancelar[0]['par_valor'],
					'comentario_cambiar_estado' => $comentario_cambiar_estado[0]['par_valor'],
					);
				//$this->_prepare_list_comentario($datac, $id, $this->Comentario_model, false);
				unset($this->Comentario_model);
				unset($this->Rol_model);
				$comentario_form = $this->load->view('comentario_form',$datac, true);
				$data['sol_id']=$sol_id;
				$data['accion']='estado';
				$data['titulo'] = 'Comentario';  				
				$data['comentario_form']=$comentario_form;
				$data['menu']=$menu;
				$data['ids_habilitados']=$ids_habilitados;
				//$data['sol_id'] = $sol_id;
				$data['ordenfilas'] = $this->session->userdata('ordenfilas');
				$this->load->view('solicitud_form_comentar_masivo', $data);
			}			
					
		}			
	}
	public function comentar_masivo(){
		$this->load->model('Comentario_model','',TRUE);
		$this->load->model('Rol_model','',TRUE);
		$res = '';
		$sol_id = $this->input->post('sol_id');
		if($sol_id){
			$lista = trim($sol_id,',');
			$lista = explode(',',$sol_id);			
			foreach($lista as $item){
				if(!empty($item)){
					//$data = array('est_id'=>6, 'sol_fec_actualizacion' => date("Y-m-d H:i:s"));
					//if($this->Solicitud_model->update($item,$data)) {						
						$res = 'OK';
					//}
					//asocio el comentario					
					$datac = array(					
						'com_texto'=>$this->input->post('com_texto'),
						'com_login'=>$this->session->userdata('login'),
						'com_nombre'=>$this->session->userdata('nombres'),
						'sol_id'=>$item,
						'rol_id'=>$this->session->userdata('rol'),			
					);
					if($datac['com_texto']!=''){
						$this->Comentario_model->insert($datac);
						
						$est_id = $this->session->userdata('rol')=='3'/*estudiante*/ ? '5'/*En espera de respuesta del coordinador*/ : '4';//En espera de respuesta del estudiante
						$datosol = array('est_id'=>$est_id, 'sol_fec_actualizacion' => date("Y-m-d H:i:s"));
						$this->Solicitud_model->update($item,$datosol);
					}
					$datos = $this->Solicitud_model->get_item($item,'sol_id');
					$this->enviarCorreo('comentario', $datos[0]['sol_email'], 'Comentario solicitud', $item);			
				}								
			}
		}
		$this->index();
	}
}