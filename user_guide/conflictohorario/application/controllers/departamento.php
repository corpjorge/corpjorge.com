<?php
class Departamento extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Departamento_model','',TRUE);
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->library('integracion');
        $this->load->library('session');
		$this->load->model('Menu_model','',TRUE);
	}
	
	function index(){
                $menu = $this->Menu_model->_getmenu();
		$data = array('titulo' => 'ADMINISTRADOR DE PROGRAMAS','menu'=>$menu);
		$this->_prepare_list($data);
		$this->load->view('departamento_listado', $data);
	}
	
	public function crear(){	
		if($this->validar()) {
			$datos = array('dep_nombre' => $this->input->post('dep_nombre'),'dep_externo' => $this->input->post('dep_externo'));
			$this->Departamento_model->insert($datos);
			$data = array('titulo' => 'ADMINISTRADOR DE PROGRAMAS','mensaje'=>'Se ha insertado con \u00e9xito');
			$this->_prepare_list($data);
			$this->load->view('departamento_listado', $data);
		}
		else{
			$data = array('dep_id' => $this->input->post('dep_id'),'dep_nombre' => $this->input->post('dep_nombre'),'dep_externo' => $this->input->post('dep_externo'),'accion'=>'crear','mensaje'=>'Se ha insertado con \u00e9xito','titulo' => 'Crear');						
			$this->load->view('departamento_form', $data);
		}
			
	}
	
	public function actualizar($id=''){
		$menu = $this->Menu_model->_getmenu();
		if(/*$this->validar()*/$id == '') {
			/*$datos = array('dep_nombre' => $this->input->post('dep_nombre'),'dep_externo' => $this->input->post('dep_externo'));
			$this->Departamento_model->update($id,$datos);*/			
			$data = array('titulo' => 'ADMINISTRADOR DE PROGRAMAS','mensaje'=>'Se ha actualizado con \u00e9xito','menu'=>$menu);
			$this->_prepare_list($data);
			$this->load->view('departamento_listado', $data);
		}	
		else {
			//$item = $this->Departamento_model->get_item($id);
			//obtengo el limite si lo hay
			$this->load->model('Limite_model','',TRUE);
			$limite = $this->Limite_model->get_item($id,'dep_id');			
		        unset($this->Limite_model);
			
			$data_llmite = array('dep_id'=>$id,
					     'lim_fec_a_sol'=>@$limite[0]['lim_fec_a_sol'],
					     'lim_fec_c_sol'=>@$limite[0]['lim_fec_c_sol'],
					     'lim_fec_a_ges'=>@$limite[0]['lim_fec_a_ges'],
					     'lim_fec_c_ges'=>@$limite[0]['lim_fec_c_ges']
					     );
			$data_llmite['lim_fec_a_sol'] = substr($data_llmite['lim_fec_a_sol'], 0, -3);
			$data_llmite['lim_fec_c_sol'] = substr($data_llmite['lim_fec_c_sol'], 0, -3);
			$data_llmite['lim_fec_a_ges'] = substr($data_llmite['lim_fec_a_ges'], 0, -3);
			$data_llmite['lim_fec_c_ges'] = substr($data_llmite['lim_fec_c_ges'], 0, -3);
			$limite_form = $this->load->view('limite_form',$data_llmite, true);
                	//			
			$data = array('dep_id' => $id,//$item[0]['dep_id'],
				      'dep_nombre' => $this->integracion->obtenerPrograma($id),//$item[0]['dep_nombre'],
				      /*'dep_externo' => $item[0]['dep_externo'],*/
				      'accion'=>'actualizar',
				      'titulo' => 'Actualizar l&iacute;mites',
				      'limite_form' => $limite_form,
				      'menu'=>$menu
				      );
						
			$this->load->view('departamento_form', $data);
		}
	}
	
	public function borrar(){
		$dep_id = $this->input->post('dep_id');
		if($this->Departamento_model->delete($dep_id)) {
			echo "OK";
			
			/*$data = array('titulo' => 'ADMINISTRADOR DE PROGRAMAS','mensaje'=>'Se ha borrado con \u00e9xito');
			$this->_prepare_list($data);
			$this->load->view('departamento_listado', $data);*/
		}
	}
	
	/*Relaciona un limite a un departamento*/
	public function relate($dep_id){
		$this->load->model('Limite_model','',TRUE);
		$this->Limite_model->delete($dep_id,'dep_id');
		$data = array(
			'lim_fec_a_sol'=>$this->input->post('lim_fec_a_sol'),
			'lim_fec_c_sol'=>$this->input->post('lim_fec_c_sol'),
			'lim_fec_a_ges'=>$this->input->post('lim_fec_a_ges'),
			'lim_fec_c_ges'=>$this->input->post('lim_fec_c_ges'),
			'dep_id'=>$dep_id,
			'dep_nombre'=>$this->integracion->obtenerPrograma($dep_id),
			);
		if($this->validar_limite()){
			$this->Limite_model->delete($dep_id,'dep_id');
			$this->Limite_model->insert($data);
			//replicacion de fechas
			if($this->input->post('replicar')){
				$departamentos = $this->integracion->programasActivos();				
				foreach($departamentos as $key=>$dep){
					$data['dep_id'] = $key;
					$data['dep_nombre'] = utf8_encode($dep);
					$res = $this->Limite_model->delete($key,'dep_id');
					if($res)
					 $this->Limite_model->insert($data);
					/*var_dump($data);
					echo '<br><br>';*/
				}
			}
			//
			echo 'OK';
		}else {
			$limite = $this->Limite_model->get_item($dep_id,'dep_id');
			$data['lim_fec_a_sol'] = substr($data['lim_fec_a_sol'], 0, -3);
			$data['lim_fec_c_sol'] = substr($data['lim_fec_c_sol'], 0, -3);
			$data['lim_fec_a_ges'] = substr($data['lim_fec_a_ges'], 0, -3);
			$data['lim_fec_c_ges'] = substr($data['lim_fec_c_ges'], 0, -3);
			$this->load->view('limite_form',$data);			
		}
		unset($this->Limite_model);
	}
	
	public function validar()
	{
		$this->form_validation->set_rules('dep_nombre', 'dep_nombre', 'required');
		$this->form_validation->set_rules('dep_externo', 'dep_externo', 'required');
		return $this->form_validation->run();
	}
	
	public function validar_limite()
	{
		$this->form_validation->set_rules('lim_fec_a_sol', 'Fecha apertura de solicitud', 'required');
		$this->form_validation->set_rules('lim_fec_c_sol', 'Fecha cierre de solicitud', 'required|callback_valida_fecha_solicitud');	
		$this->form_validation->set_rules('lim_fec_a_ges', 'Fecha apertura de gestión', 'required');
		$this->form_validation->set_rules('lim_fec_c_ges', 'Fecha cierre de gestión', 'required|callback_valida_fecha_gestion');			
		return $this->form_validation->run();
	}
	
	public function valida_fecha_solicitud($str) {
		$val = $this->input->post('lim_fec_c_sol')=='' || ($this->input->post('lim_fec_c_sol') > $this->input->post('lim_fec_a_sol')) ? true : false;
		if(!$val)
			$this->form_validation->set_message('valida_fecha_solicitud', '%s debe ser mayor que Fecha apertura de solicitud');
		return $val;
	}
	public function valida_fecha_gestion($str) {
		$val = $this->input->post('lim_fec_c_ges')=='' || ($this->input->post('lim_fec_c_ges') > $this->input->post('lim_fec_a_ges')) ? true : false;
		if(!$val)
			$this->form_validation->set_message('valida_fecha_gestion', '%s debe ser mayor que Fecha apertura de gestión');
		return $val;
	}
	
	public function page(){
		$datos = array();
		$datos['page'] = $this->input->post('page');
		//$datos['total'] = $this->Departamento_model->get_count();
		$datos['sortname'] = ($this->input->post('sortname')!='')?$this->input->post('sortname'):$this->Departamento_model->tableLlave();
		$datos['sortorder'] = ($this->input->post('sortorder')!='')?$this->input->post('sortorder'):'ASC';
		$datos['rp'] = ($this->input->post('rp')!='')?$this->input->post('rp'):'';
		$datos['qtype'] = ($this->input->post('qtype')!='')?$this->input->post('qtype'):'';
		$datos['query'] = ($this->input->post('query')!='')?$this->input->post('query'):'';
		$inicio = ($this->input->post('page')>1)?(($this->input->post('page')*$this->input->post('rp')))/2:1;		
		//$filas = $this->Departamento_model->get_all($inicio,$this->input->post('rp'),$datos['sortorder'],$datos['sortname'],$datos['qtype'],$datos['query']);
		
		$departamentos = $this->integracion->programasActivos();
		
		if($datos['sortname']=='dep_id')
			array_flip($departamentos);			
		if($datos['sortorder']=='asc')
			asort($departamentos);
		elseif($datos['sortorder']=='desc')
			arsort($departamentos);
		if($datos['sortname']=='dep_id')
			array_flip($departamentos);
		
		$filas = array();
		foreach($departamentos as $llave => $valor) {
			$filas[] = array('dep_id'=>$llave, 'dep_nombre'=>$valor);
		}
		
		if(!empty($datos['qtype']) && !empty($datos['query'])) {
			$filas2 = array();
			foreach($filas as $fila) {
				foreach($fila as $llave => $valor) {
					if($llave==$datos['qtype'] && (strpos(utf8_encode(strtoupper($valor)), utf8_encode(strtoupper($datos['query'])))!==FALSE)) {						
						$filas2[] = $fila;
					}
				}
			}
			$filas = $filas2;
		}
		$datos['total'] = count($filas);		
		$filas = array_slice($filas, ($datos['rp']*($datos['page']-1)), $datos['rp']);

		foreach($filas as $item){
			
			$dep_nombre = $item['dep_nombre'];			
			$dep_nombre = str_replace('\u00c1', '\u00e1',  $dep_nombre); //á
			$dep_nombre = str_replace('\u00c9', '\u00e9',  $dep_nombre); //é
			$dep_nombre = str_replace('\u00cd', '\u00fd',  $dep_nombre); //í
			$dep_nombre = str_replace('\u00d3', '\u00f3',  $dep_nombre); //ó
			$dep_nombre = str_replace('\u00da', '\u00fa',  $dep_nombre); //ú
			//echo utf8_decode($dep_nombre)."<br>";
			
			//\u00d3n
			
			
			$datos['rows'][] = array(
				'id' => $item['dep_id'],
				'cell' => array($item['dep_id'], /*$item['dep_nombre']*/$dep_nombre/*, $item['dep_externo']*/)
			);
		}
		//print_r($datos);
		echo json_encode($datos);	
	}
	
	private function _prepare_list(&$data){
		$data['total_rows'] = $this->Departamento_model->get_count();                
                $filas = $this->Departamento_model->get_all();
		$datos = array();
		foreach($filas as $item){			
			$datos['rows'][] = array(
				'id' => $item['dep_id'],
				'cell' => array($item['dep_id'], $item['dep_nombre'], $item['dep_externo'])
			);
		}
		$data['$filas'] = json_encode($datos);
	}
	
	
	

	function ajaxsearch()
	{
		$function_name = $this->input->post('function_name');
		$description = $this->input->post('description');
		echo $this->function_model->getSearchResults($function_name, $description);
	}

	function search()
	{
		$data['title'] = "Code Igniter Search Results";
		$function_name = $this->input->post('function_name');
		$data['search_results'] = $this->function_model->getSearchResults($function_name);
		$this->load->view('application/search', $data);
	}

         
        /*Revisa los permisos y segun el usuario entrega un tipo de menú*/
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
        
}