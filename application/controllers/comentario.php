<?php

class Comentario extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('Comentario_model', '', TRUE);
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
		$data = array('titulo' => 'ADMINISTRADOR DE COMENTARIOS');
		$this->_prepare_list($data);		
		$this->load->view('comentario_listado', $data);
	}
	
	public function crear()
	{	
		if($this->validar()) {
			$data = array(
			'com_id'=>$this->input->post('com_id'),
			'com_login'=>$this->input->post('com_login'),
			'com_texto'=>$this->input->post('com_texto'),
			'sol_id'=>$this->input->post('sol_id')
			);
			$mensaje = $this->Comentario_model->insert($data) ? 'Se ha insertado con \u00e9xito' : 'No se pudo insertar';
			$data = array('titulo' => 'ADMINISTRADOR DE COMENTARIOS','mensaje' => $mensaje);
				$this->_prepare_list($data);
				$this->load->view('comentario_listado', $data);
		}
		else {
			$data = array('titulo'=>'Crear', 'accion'=>'crear',
			'com_id'=>$this->input->post('com_id'),
			'com_login'=>$this->input->post('com_login'),
			'com_texto'=>$this->input->post('com_texto'),
			'sol_id'=>$this->input->post('sol_id')
			);
			$this->load->view('comentario_form', $data);
		}
	}
	
	public function actualizar($id)
	{	
		if($this->validar()) {
			$data = array(
			'com_login'=>$this->input->post('com_login'),
			'com_texto'=>$this->input->post('com_texto'),
			'sol_id'=>$this->input->post('sol_id')
			);
			$mensaje = $this->Comentario_model->update($id, $data) ? 'Se ha actualizado con \u00e9xito' : 'No se pudo actualizar';
			$data = array('titulo' => 'ADMINISTRADOR DE COMENTARIOS','mensaje' => $mensaje);
			$this->_prepare_list($data);
			$this->load->view('comentario_listado', $data);
		}	
		else {
			$datas = $this->Comentario_model->get_item($id);
			$accion = array('titulo'=>'Actualizar', 'accion'=>'actualizar');
			foreach($datas as $data) {
				$data = array_merge((array)$data, $accion);
				$this->load->view('comentario_form', $data);
			}			
		}
	}
	
	public function borrar($id)
	{
		$mensaje = $this->Comentario_model->delete($id) ? 'Se ha borrado con \u00e9xito' : 'No se pudo borrar';
		$data = array('titulo' => 'ADMINISTRADOR DE COMENTARIOS','mensaje' => $mensaje);
		$this->_prepare_list($data);
		$this->load->view('comentario_listado', $data);
	}
		
	public function validar()
	{
		$this->form_validation->set_rules('com_texto', 'Texto', 'required');	
		return $this->form_validation->run();
	}
	
	private function _prepare_list(&$data){
		$this->load->library('pagination');
                $config_page['base_url'] = '/index.php/comentario/page/';
                $config_page['total_rows'] = $this->Comentario_model->get_count();
                $config_page['per_page'] = 20;		
                $this->pagination->initialize($config_page);
		$data['filas'] = $this->Comentario_model->get_all();
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
}
