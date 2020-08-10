<?php

class Motivo extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('Motivo_model', '', TRUE);
        $this->load->library('session');
		$this->load->model('Menu_model','',TRUE);
			}
			
	function index(){
                $menu = $this->Menu_model->_getmenu();
		$data = array('titulo' => 'ADMINISTRADOR DE MOTIVOS','menu'=>$menu);
		$this->_prepare_list($data);		
		$this->load->view('motivo_listado', $data);
	}
	
	public function crear()
	{	
		$menu = $this->Menu_model->_getmenu();
		if($this->validar()) {
			$data = array('mov_descripcion' => $this->input->post('descripcion'));
			$mensaje = $this->Motivo_model->insert($data) ? 'Se ha insertado con \u00e9xito' : 'No se pudo insertar';
			$data = array('titulo' => 'ADMINISTRADOR DE MOTIVOS','mensaje' => $mensaje, 'menu' => $menu);
				$this->_prepare_list($data);
				$this->load->view('motivo_listado', $data);
		}
		else {
			$data = array('titulo'=>'Crear', 'accion'=>'crear', 'mov_id'=>$this->input->post('mov_id'), 'mov_descripcion'=>$this->input->post('mov_descripcion'), 'menu' => $menu);
			$this->load->view('motivo_form', $data);
		}
	}
	
	public function actualizar($id)
	{	
		$menu = $this->Menu_model->_getmenu();
		if($this->validar()) {
			$data = array('mov_descripcion' => $this->input->post('descripcion'));
			$mensaje = $this->Motivo_model->update($id, $data) ? 'Se ha actualizado con \u00e9xito' : 'No se pudo actualizar';
			$data = array('titulo' => 'ADMINISTRADOR DE MOTIVOS','mensaje' => $mensaje, 'menu' => $menu);
			$this->_prepare_list($data);
			$this->load->view('motivo_listado', $data);
		}	
		else {
			$datas = $this->Motivo_model->get_item($id);
			$accion = array('titulo'=>'Actualizar', 'accion'=>'actualizar', 'menu' => $menu);
			foreach($datas as $data) {
				$data = array_merge((array)$data, $accion);
				$this->load->view('motivo_form', $data);
			}			
		}
	}
	
	public function borrar($id)
	{
		$id =  $this->input->post('coo_id');
		if($id){
			$mensaje = $this->Motivo_model->delete($id) ? 'Se ha borrado con \u00e9xito' : 'No se pudo borrar';
			$data = array('titulo' => 'ADMINISTRADOR DE COORDINADORES','mensaje' => $mensaje);				
		}
		echo "OK";
	}
		
	public function validar()
	{
		$this->form_validation->set_rules('descripcion', 'Descripción', 'required');
		return $this->form_validation->run();
	}
	
	private function _prepare_list(&$data){
		$this->load->library('pagination');
                $config_page['base_url'] = '/index.php/motivo/page/';
                $config_page['total_rows'] = $this->Motivo_model->get_count();
                $config_page['per_page'] = 20;		
                $this->pagination->initialize($config_page);
		$data['filas'] = $this->Motivo_model->get_all();
		$data['paginacion'] = $this->pagination->create_links();			
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
        
        function page(){
            $datos = array();
            $datos['page'] = $this->input->post('page');
            $datos['total'] = $this->Motivo_model->get_count();
            $datos['sortname'] = ($this->input->post('sortname')!='')?$this->input->post('sortname'):$this->Motivo_model->tableLlave();
            $datos['sortorder'] = ($this->input->post('sortorder')!='')?$this->input->post('sortorder'):'ASC';
            $datos['qtype'] = ($this->input->post('qtype')!='')?$this->input->post('qtype'):'';
            $datos['query'] = ($this->input->post('query')!='')?$this->input->post('query'):'';
            $inicio = ($this->input->post('page')>1)?(($this->input->post('page')*$this->input->post('rp')))/2:"0";		
            $filas = $this->_get_filas($this->session->userdata('rol'),
                                                        $inicio,$this->input->post('rp'),
                                                        $datos['sortorder'],
                                                        $datos['sortname'],
                                                        $datos['qtype'],
                                                        $datos['query']);
            foreach($filas as $item){             
                    $datos['rows'][] = array(
                            'id' => $item['mov_id'],				
                            'cell' => array($item['mov_id'], $item['mov_descripcion'])
                    );			
            }
            echo json_encode($datos);            
        }
	
	public function listado(){
		$menu = $this->Menu_model->_getmenu();
		$data = array('titulo' => 'Administrador de par&aacute;metros','menu'=>$menu);		
		$this->load->view('listado', $data);		
	}
        
        /*Obtiene las filas segun*/
	private function _get_filas($rol,$inicio,$pr,$order,$sortname,$qtype,$query){
		
		$filas = array();
		switch($rol){
			case 1:
			 $filas = $this->Motivo_model->get_all($inicio,$pr,$order,$sortname,$qtype,$query);		
			break;
			case 2:			 
			 $programas = explode('*',$this->session->userdata('programas'));
			 $filas = $this->Motivo_model->get_all_coordinador($inicio,$pr,$order,$sortname,$qtype,$query,$programas,'dep_id');			
			break;
			case 3:
			 $login = $this->session->userdata('login');
			 $filas = $this->Motivo_model->get_all($inicio,$pr,$order,$sortname,$qtype,$query,$login,'sol_login');
			break;
		}
		return $filas;
		
	}
}
