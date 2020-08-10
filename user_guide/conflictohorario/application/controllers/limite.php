<?php

class Limite extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('Limite_model', '', TRUE);
		$this->load->model('Menu_model','',TRUE);
	}
			
	function index(){
		$data = array('titulo' => 'ADMINISTRADOR DE L&Iacute;MITES');
		$this->_prepare_list($data);		
		$this->load->view('limite_listado', $data);
	}
	
	public function crear()
	{	
		if($this->validar()) {
			$data = array(
			'lim_id'=>$this->input->post('lim_id'),
			'lim_fec_a_sol'=>$this->input->post('lim_fec_a_sol'),
			'lim_fec_c_sol'=>$this->input->post('lim_fec_c_sol'),
			'lim_fec_a_ges'=>$this->input->post('lim_fec_a_ges'),
			'lim_fec_c_ges'=>$this->input->post('lim_fec_c_ges')
			);
			$mensaje = $this->Limite_model->insert($data) ? 'Se ha insertado con \u00e9xito' : 'No se pudo insertar';
			$data = array('titulo' => 'ADMINISTRADOR DE L&Iacute;MITES','mensaje' => $mensaje);
				$this->_prepare_list($data);
				$this->load->view('limite_listado', $data);
		}
		else {
			$data = array('titulo'=>'Crear', 'accion'=>'crear',
			'lim_id'=>$this->input->post('lim_id'),
			'lim_fec_a_sol'=>$this->input->post('lim_fec_a_sol'),
			'lim_fec_c_sol'=>$this->input->post('lim_fec_c_sol'),
			'lim_fec_a_ges'=>$this->input->post('lim_fec_a_ges'),
			'lim_fec_c_ges'=>$this->input->post('lim_fec_c_ges')
			);
			$this->load->view('limite_form', $data);
		}
	}
	
	public function actualizar($id)
	{	
		if($this->validar()) {
			$data = array(
			'lim_fec_a_sol'=>$this->input->post('lim_fec_a_sol'),
			'lim_fec_c_sol'=>$this->input->post('lim_fec_c_sol'),
			'lim_fec_a_ges'=>$this->input->post('lim_fec_a_ges'),
			'lim_fec_c_ges'=>$this->input->post('lim_fec_c_ges')
			);
			$mensaje = $this->Limite_model->update($id, $data) ? 'Se ha actualizado con \u00e9xito' : 'No se pudo actualizar';
			$data = array('titulo' => 'ADMINISTRADOR DE L&Iacute;MITES','mensaje' => $mensaje);
			$this->_prepare_list($data);
			$this->load->view('limite_listado', $data);
		}	
		else {
			$datas = $this->Limite_model->get_item($id);
			$accion = array('titulo'=>'Actualizar', 'accion'=>'actualizar');
			foreach($datas as $data) {
				$data = array_merge((array)$data, $accion);
				$this->load->view('limite_form', $data);
			}			
		}
	}
	
	public function borrar($id)
	{
		$mensaje = $this->Limite_model->delete($id) ? 'Se ha borrado con \u00e9xito' : 'No se pudo borrar';
		$data = array('titulo' => 'ADMINISTRADOR DE L&Iacute;MITES','mensaje' => $mensaje);
		$this->_prepare_list($data);
		$this->load->view('limite_listado', $data);
	}
		
	public function validar()
	{
		$this->form_validation->set_rules('lim_fec_a_sol', 'Fecha apertura de solicitud', 'required');
		$this->form_validation->set_rules('lim_fec_c_sol', 'Fecha cierre de solicitud', 'required');
		$this->form_validation->set_rules('lim_fec_a_ges', 'Fecha apertura de gestión', 'required');
		$this->form_validation->set_rules('lim_fec_c_ges', 'Fecha cierre de gestión', 'required');		
		return $this->form_validation->run();
	}
	
	private function _prepare_list(&$data){
		$this->load->library('pagination');
                $config_page['base_url'] = '/index.php/limite/page/';
                $config_page['total_rows'] = $this->Limite_model->get_count();
                $config_page['per_page'] = 20;		
                $this->pagination->initialize($config_page);
		$data['filas'] = $this->Limite_model->get_all();
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
