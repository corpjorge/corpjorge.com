<?php

class Bloqueo extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('Bloqueo_model', '', TRUE);
                $this->load->library('session');
                $this->load->library('integracion');
		$this->load->model('Menu_model','',TRUE);
		
		$this->load->library('session');
			if(!$this->session->userdata('logged_in')){
			if($this->isAjax()){
				echo "expired";
				exit;
			}else
				redirect('auth/index?e=1');
		}
	}
			
	function index(){
                $menu = $this->Menu_model->_getmenu();
		$data = array('titulo' => 'ADMINISTRADOR DE BLOQUEOS DE CRN','menu'=>$menu);
		$this->_prepare_list($data);		
		$this->load->view('bloqueo_listado', $data);
	}
	
	public function crear()
	{   
		$menu = $this->Menu_model->_getmenu();
		$this->load->model('Parametro_model','',TRUE);
		if($this->validar()) {

			$data = array('crn' => $this->input->post('crn'),'materia' => $this->input->post('materia'),'seccion' => $this->input->post('seccion'),'titulo' => $this->input->post('titulo'),'bloqueado_por'=>$this->session->userdata['login'],'fecha_bloqueo'=>date('Y-m-d H:i:s'), 'periodo'=> $this->input->post('periodo'));
                        $pData= $this->Bloqueo_model->insert($data);
			$mensaje = ($pData===true) ? 'Se ha insertado con \u00e9xito' : 'No se pudo insertar'.$pData;
			$data = array('titulo' => 'BLOQUEO DE CRN','mensaje' => $mensaje, 'menu' => $menu);
				$this->_prepare_list($data);
				$this->load->view('bloqueo_listado', $data);
		}
		else {
				$periodo	= 	$this->Parametro_model->get_item('periodo','par_nombre');
				$periodo	= 	$periodo[0]['par_valor'];
				$dperiodo	 = $this->Parametro_model->get_item('dperiodo','par_nombre');
				$data 		= 	array('dperiodo' => $dperiodo[0]['par_valor'],	'periodo' => $periodo , 'title'=>'Bloquear', 'accion'=>'crear', 'blq_id'=>$this->input->post('blq_id'), 'crn'=>$this->input->post('crn'),'materia' => $this->input->post('materia'),'seccion' => $this->input->post('seccion'),'titulo' => $this->input->post('titulo'), 'menu' => $menu);
	
				$this->load->view('bloqueo_form', $data);
		}
	}
	
	public function actualizar($id)
	{	
		$menu = $this->Menu_model->_getmenu();
		if($this->validar()) {
			$data = array('mov_descripcion' => $this->input->post('descripcion'));
			$mensaje = $this->Bloqueo_model->update($id, $data) ? 'Se ha actualizado con \u00e9xito' : 'No se pudo actualizar';
			$data = array('titulo' => 'ADMINISTRADOR DE MOTIVOS','mensaje' => $mensaje, 'menu' => $menu);
			$this->_prepare_list($data);
			$this->load->view('bloqueo_listado', $data);
		}	
		else {
			$datas = $this->Bloqueo_model->get_item($id);
			$accion = array('titulo'=>'Actualizar', 'accion'=>'actualizar', 'menu' => $menu);
			foreach($datas as $data) {
				$data = array_merge((array)$data, $accion);
				$this->load->view('bloqueo_form', $data);
			}			
		}
	}
	
	public function borrar($id)
	{
		$id =  $this->input->post('coo_id');
		if($id){
			$mensaje = $this->Bloqueo_model->delete($id) ? 'Se ha borrado con \u00e9xito' : 'No se pudo borrar';
			$data = array('titulo' => 'ADMINISTRADOR DE COORDINADORES','mensaje' => $mensaje);				
		}
		echo "OK";
	}
		
	public function validar()
	{
		$this->form_validation->set_rules('crn', 'Crn', 'required|min_length[5]|max_length[5]|numeric');
		$this->form_validation->set_rules('materia', 'Cod Materia', 'required');
		$this->form_validation->set_rules('seccion', 'Seccion', 'required');
		$this->form_validation->set_rules('titulo', 'Titulo', 'required');
		return $this->form_validation->run();
	}
	
	private function _prepare_list(&$data){
		$this->load->library('pagination');
                $config_page['base_url'] = '/index.php/bloqueo/page/';
                $config_page['total_rows'] = $this->Bloqueo_model->get_count();
                $config_page['per_page'] = 20;		
                $this->pagination->initialize($config_page);
		$data['filas'] = $this->Bloqueo_model->get_all();
		$data['paginacion'] = $this->pagination->create_links();			
	}

	function ajaxsearch()
	{
		$function_name = $this->input->post('function_name');
		$description = $this->input->post('crn');
		echo $this->function_model->getSearchResults($function_name, $description);
	}
	function autocomplete()
	{		
            $description = $this->input->get('term');
            $periodo = $this->input->get('periodo');
            //echo json_encode(array("44512 - Aminito","44515 - Derechin","51321 - Psichicology"));            
            $programa=  str_replace("*", "','", $this->session->userdata['programas']);            
            $results=$this->integracion->getAutocomplete($description,$programa, $periodo);
            $return=array();
            if(is_array($results)){
                foreach ($results as $key => $value) {
                    
                    if(is_numeric($key)){
                        $return[]=array(
                          "value"  =>$value['VALUE'],
                          "crn"  =>$value['CRN'],
                          "materia"  =>$value['MATERIA'],
                          "seccion"  =>$value['SECCION'],
                          "titulo"  =>$value['TITULO']
                        );
                    }
                }
            }  else {
                $return[]="Sin Resultados";
            }
            echo json_encode($return);
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
            $datos['total'] = $this->Bloqueo_model->get_count();
            $datos['sortname'] = ($this->input->post('sortname')!='')?$this->input->post('sortname'):$this->Bloqueo_model->tableLlave();
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
                            'id' => $item['blq_id'],				
                            'cell' => array($item['blq_id'], $item['crn'],$item['titulo'],$item['materia'],$item['seccion'],$item['bloqueado_por'],$item['fecha_bloqueo'], $item['periodo'])
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
		
                $filas = $this->Bloqueo_model->get_all($inicio,$pr,$order,$sortname,$qtype,$query);		
		
		return $filas;
		
	}
}
