<?php

class Coordinador extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('Coordinador_model', '', TRUE);
		$this->load->library('integracion');
        $this->load->library('session');
		$this->load->model('Menu_model','',TRUE);
	}
			
	function index(){
		$menu= $this->Menu_model->_getmenu();
		$data = array('titulo' => 'ADMINISTRADOR DE COORDINADORES',"menu"=>$menu);
		$columns = $this->Coordinador_model->getColumns();
		$orderColumns = json_decode($columns[0]["columns"]);
		$data["orderColumns"] = $orderColumns;
		//echo "<pre>"; print_r($columns); exit;
		$this->load->view('coordinador_listado', $data);
	}
	
	public function crear()
	{	$menu = $this->Menu_model->_getmenu();
		$this->load->model('Nivel_model','',TRUE);
		$options_nivel = $this->Nivel_model->get_dropdown();
		//unset($this->Nivel_model);
		
		$this->load->model('Departamento_model','',TRUE);
		$options_departamento = $this->Departamento_model->get_dropdown();
		//unset($this->Departamento_model);
		
		$this->load->model('Rol_model','',TRUE);
		$options_rol = $this->Rol_model->get_dropdown();
		unset($options_rol['3']);
		//unset($this->Rol_model);		
		
		
		if($this->validar()){
			$dep_id = '';
			if(is_array($this->input->post('dep_ids'))) {
				foreach($this->input->post('dep_ids') as $dep) {
					$dep_id .= $dep_id!='' ? '*' : '';
					$dep_id .= $dep;
				}
			}
			else
				$dep_id = $this->input->post('dep_ids');
                        
                        
			$materia_id = '';
			if(is_array($this->input->post('materias_ids'))) {
				foreach($this->input->post('materias_ids') as $mat) {
					$materia_id .= $materia_id!='' ? '*' : '';
					$materia_id .= $mat;
				}
			}
			else
				$materia_id = $this->input->post('materias_ids');
			
			$niv_id = '';
			if(is_array($this->input->post('niv_ids'))) {
				foreach($this->input->post('niv_ids') as $nivel) {
					$niv_id .= $niv_id!='' ? '*' : '';
					$niv_id .= $nivel;
				}
			}
			else
				$niv_id = $this->input->post('niv_ids');
				
			$data = array(
			'coo_id'=>$this->input->post('coo_id'),
			'coo_email'=>$this->input->post('coo_login').'@uniandes.edu.co',//$this->input->post('coo_email'),
			'coo_asistente'=>$this->input->post('coo_asistente'),
			'coo_activo'=>$this->input->post('coo_activo'),
			'coo_nombre'=>$this->input->post('coo_nombre'),
			'coo_login'=>$this->input->post('coo_login'),
			'niv_id'=>$niv_id,
			'dep_id'=>$dep_id,
                        'materia_id'=>$materia_id,
			'rol_id'=>$this->input->post('rol_id')						
			);
			$objext = $this->Coordinador_model->get_item($this->input->post('coo_login'),'coo_login');			
			if(count($objext)==0){
				$mensaje = $this->Coordinador_model->insert($data) ? 'Se ha insertado con \u00e9xito' : 'No se pudo insertar';					
			}else{
				$mensaje = 'No se pudo crear el coordinador: El login usado ya existe en la base de datos';
			}
			$data = array('titulo' => 'ADMINISTRADOR DE COORDINADORES','mensaje' => $mensaje,'menu'=>$menu);					
			$this->load->view('coordinador_listado', $data);		
		}		
		else {
			$departamentos = $this->integracion->programasActivos();
			$deps = array();
			foreach($departamentos as $llave => $valor) {
				$deps[] = array('dep_id'=>$llave, 'dep_nombre'=>$valor);
			}
			$data = array('titulo'=>'Crear', 'accion'=>'crear',
			'coo_id'=>$this->input->post('coo_id'),
			'coo_email'=>$this->input->post('coo_login').'@uniandes.edu.co',//$this->input->post('coo_email'),
			'coo_asistente'=>$this->input->post('coo_asistente'),
			'coo_activo'=>$this->input->post('coo_activo'),
			'coo_nombre'=>$this->input->post('coo_nombre'),
			'coo_login'=>$this->input->post('coo_login'),
			'niv_id'=>$this->input->post('niv_id'),
			'niv_ids'=>$this->input->post('niv_ids'),
			'dep_id'=>$this->input->post('dep_id'),
			'rol_id'=>$this->input->post('rol_id'),
			'options_nivel'=>$options_nivel,
			'options_departamento'=>$options_departamento,
			'options_rol'=>$options_rol,
			'departamentos' => $deps,
			'menu'=>$menu,
			);
			$this->load->view('coordinador_form', $data);
		}
		unset($this->Nivel_model);
		unset($this->Departamento_model);
		unset($this->Rol_model);
	}
	
	public function actualizar($id)
	{	$menu = $this->Menu_model->_getmenu();
		$this->load->model('Nivel_model','',TRUE);
		$options_nivel = $this->Nivel_model->get_dropdown();
		//unset($this->Nivel_model);
		
		$this->load->model('Departamento_model','',TRUE);
		$options_departamento = $this->Departamento_model->get_dropdown();
		//unset($this->Departamento_model);
		
		$this->load->model('Rol_model','',TRUE);
		$options_rol = $this->Rol_model->get_dropdown();
		unset($options_rol['3']);
		//unset($this->Rol_model);
		
		if($this->validar()) {
			$dep_id = '';
			if(is_array($this->input->post('dep_ids'))) {
				foreach($this->input->post('dep_ids') as $dep) {
					$dep_id .= $dep_id!='' ? '*' : '';
					$dep_id .= $dep;
				}
			}
			else
				$dep_id = $this->input->post('dep_ids');
                        
                        $materia_id = '';
			if(is_array($this->input->post('materias_ids'))) {
				foreach($this->input->post('materias_ids') as $mat) {
					$materia_id .= $materia_id!='' ? '*' : '';
					$materia_id .= $mat;
				}
			}
			else
				$materia_id = $this->input->post('materias_ids');
                            
			$niv_id = '';
			if(is_array($this->input->post('niv_ids'))) {
				foreach($this->input->post('niv_ids') as $nivel) {
					$niv_id .= $niv_id!='' ? '*' : '';
					$niv_id .= $nivel;
				}
			}
			else
				$niv_id = $this->input->post('niv_ids');
			
			$data = array(
			'coo_email'=>$this->input->post('coo_login').'@uniandes.edu.co',//$this->input->post('coo_email'),
			'coo_asistente'=>$this->input->post('coo_asistente'),
			'coo_activo'=>$this->input->post('coo_activo'),
			'coo_nombre'=>$this->input->post('coo_nombre'),
			'coo_login'=>$this->input->post('coo_login'),
			'niv_id'=>$niv_id,
			'dep_id'=>$dep_id,
			'materia_id'=>$materia_id,
			'rol_id'=>$this->input->post('rol_id'),
			);
			//print_r($data);
			$mensaje = $this->Coordinador_model->update($id, $data) ? 'Se ha actualizado con \u00e9xito' : 'No se pudo actualizar';
			$data = array('titulo' => 'ADMINISTRADOR DE COORDINADORES','mensaje' => $mensaje,'menu'=>$menu);
			$this->load->view('coordinador_listado', $data);
		}	
		else {
			$departamentos = $this->integracion->programasActivos();
			$deps = array();
			foreach($departamentos as $llave => $valor) {
				$deps[] = array('dep_id'=>$llave, 'dep_nombre'=>$valor);
			}	
			$datas = $this->Coordinador_model->get_item($id);
			$accion = array('titulo'=>'Actualizar', 'accion'=>'actualizar',
			'options_nivel'=>$options_nivel,
			'options_departamento'=>$options_departamento,
			'options_rol'=>$options_rol,
			'departamentos' => $deps,
			'menu'=>$menu,
			'niv_ids'=>$this->input->post('niv_ids'),
			);
			foreach($datas as $data) {
				$data = array_merge((array)$data, $accion);				
				$this->load->view('coordinador_form', $data);
			}			
		}
		unset($this->Nivel_model);
		unset($this->Departamento_model);
		unset($this->Rol_model);
	}
	
	public function borrar()	{
		$id =  $this->input->post('coo_id');
		if($id){
			$mensaje = $this->Coordinador_model->delete($id) ? 'Se ha borrado con \u00e9xito' : 'No se pudo borrar';
			$data = array('titulo' => 'ADMINISTRADOR DE COORDINADORES','mensaje' => $mensaje);				
		}
		echo "OK";
	}
		
	public function validar()
	{				
		$this->form_validation->set_rules('coo_nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('coo_login', 'Login', 'required');
		//$this->form_validation->set_rules('coo_email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('niv_ids', 'Nivel', 'required');
		//$this->form_validation->set_rules('dep_id', 'Departamento', 'required');
		$this->form_validation->set_rules('rol_id', 'Rol', 'required');		
		return $this->form_validation->run();
	}
	
        public function getMaterias($id,$coo_id){
            //echo "<li>" .$id =  $this->input->post('id');            
            $materiasSeleccionadas=array();
            if($coo_id>0){
                $materiasSeleccionadas = $this->Coordinador_model->get_selMats($coo_id);            
                $materiasSeleccionadas = $materiasSeleccionadas[0]['materia_id'];
                $materiasSeleccionadas = explode("*", $materiasSeleccionadas);
            }
            $materias = $this->integracion->materiasPorDepto($id);  
            $tieneSeleccionadas=0;
            foreach ($materias as $key => $materia) {
                if(in_array($materia['MATERIA'].$materia['CURSO'], $materiasSeleccionadas)){
                    $materias[$key]['SEL']=1;
                    $tieneSeleccionadas++;
                }  else {
                    $materias[$key]['SEL']=0;
                }
            }
            foreach ($materias as $key => $materia) {
                if($tieneSeleccionadas>0){
                    $materias[$key]['DEFAULT']=1;                    
                }  else {
                    $materias[$key]['DEFAULT']=0;
                }
            }            
            echo json_encode($materias);
        }
        

        public function page(){
                $sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		$this->load->model('Nivel_model','',TRUE);
		$this->load->model('Departamento_model','',TRUE);
		$this->load->model('Rol_model','',TRUE);
		$datos = array();
		$datos['page'] = $this->input->post('page');
		$datos['total'] = $this->Coordinador_model->get_count();
		$datos['sortname'] = ($this->input->post('sortname')!='')?$this->input->post('sortname'):$this->Coordinador_model->tableLlave();
		$datos['sortorder'] = ($this->input->post('sortorder')!='')?$this->input->post('sortorder'):'ASC';
		$datos['qtype'] = ($this->input->post('qtype')!='')?$this->input->post('qtype'):'';
		$datos['query'] = ($this->input->post('query')!='')?$this->input->post('query'):'';
		$inicio = ((int)($this->input->post('page'))-1)*(int)$this->input->post('rp');	
		$filas = $this->Coordinador_model->get_all($inicio,$this->input->post('rp'),$datos['sortorder'],$datos['sortname'],$datos['qtype'],$datos['query']);
		
		$columns = $this->Coordinador_model->getColumns();
		if(count($columns)){
			$orderColumns = json_decode($columns[0]["columns"]);
			foreach($orderColumns as $col){
				$cells[] = $col->name;
			}
		}
		
		//print_r($cells); exit;
		
		foreach($filas as $item){
			$item_nivs = $item['niv_id'];
			$this->_adicionar_foraneas($item, $this->Nivel_model, /*$this->Departamento_model,*/ $this->Rol_model, false);
			$ids_dep = explode('*', $item['dep_id']);
			$item['coo_asistente'] = $item['coo_asistente'] == 0?'No':'Si';
			//print_r($ids_dep);
			$nombres_dep = '';
			$cod_dep = '';
			foreach($ids_dep as $id_dep) {
				//$nombres_dep .= $nombres_dep!='' ? '<br>' : '';
				if($nombres_dep!='') $nombres_dep = $nombres_dep.'<br>';
				if($cod_dep!='') $cod_dep = $cod_dep.'<br>';
				
				$nombres_dep .= $this->integracion->obtenerPrograma($id_dep);
				$cod_dep .= $id_dep; 
				//print "$id_dep - $nombres_dep<br>";
			}			
			$ids_niv = explode('*', $item_nivs);
			$nombres_niv='';
			
			foreach($ids_niv as $id_niv) {
				if($nombres_niv!='')
					$nombres_niv = $nombres_niv.'<br>';
				$unnivel = $this->Nivel_model->get_item($id_niv);
				$nombres_niv .= $unnivel[0]['niv_descripcion'];
				//print "$id_dep - $nombres_dep<br>";
			}	
				$cell = array();
			if(count($cells)){
				foreach($cells as $cl){
					if($cl != "dep_nom")
						$cell[] = $item[$cl];
					if($cl == "dep_nom")
						$cell[] = $nombres_dep;
					
				}							
			}else{
				$cell = array($item['coo_id'], $item['coo_nombre'], $item['coo_login'], $item['coo_email'], $item['coo_asistente'], $nombres_niv,$cod_dep, /*$item['dep_nombre']*/$nombres_dep, $item['rol_descripcion']);
			}
			//print_r($cells); exit;
			//print "<br>";
			$datos['rows'][] = array(
				'id' => $item['coo_id'],
				'cell' => $cell
			);			
		}
		echo json_encode($datos);
		unset($this->Nivel_model);
		unset($this->Departamento_model);
		unset($this->Rol_model);
	}
	
        public function excel(){
                $sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		//$this->load->library('Excel');
		//$this->load->library('Excel_XML');
		$this->load->model('Nivel_model','',TRUE);
		$this->load->model('Departamento_model','',TRUE);
		$this->load->model('Rol_model','',TRUE);
		$datos = array();
		$data = array();
		$datos['page'] = $this->input->post('page');
		$datos['total'] = $this->Coordinador_model->get_count();
		$datos['sortname'] = ($this->input->post('sortname')!='')?$this->input->post('sortname'):$this->Coordinador_model->tableLlave();
		$datos['sortorder'] = ($this->input->post('sortorder')!='')?$this->input->post('sortorder'):'ASC';
		$datos['qtype'] = ($this->input->post('qtype')!='')?$this->input->post('qtype'):'';
		$datos['query'] = ($this->input->post('query')!='')?$this->input->post('query'):'';
		$inicio = ((int)($this->input->post('page'))-1)*(int)$this->input->post('rp');	
		$filas = $this->Coordinador_model->get_all($inicio,$this->input->post('rp'),$datos['sortorder'],$datos['sortname'],$datos['qtype'],$datos['query']);
		foreach($filas as $item){
			$item_nivs = $item['niv_id'];
			$this->_adicionar_foraneas($item, $this->Nivel_model, /*$this->Departamento_model,*/ $this->Rol_model, false);
			$ids_dep = explode('*', $item['dep_id']);
			$item['coo_asistente'] = $item['coo_asistente'] == 0?'No':'Si';
			//print_r($ids_dep);
			$nombres_dep = '';
			$cod_dep='';
			foreach($ids_dep as $id_dep) {
				//$nombres_dep .= $nombres_dep!='' ? '<br>' : '';
				if($nombres_dep!='') $nombres_dep = $nombres_dep.' - ';
				if($cod_dep!='') $cod_dep = $cod_dep.' - ';
				
				$nombres_dep .= $this->integracion->obtenerPrograma($id_dep);
				$cod_dep .= $id_dep; 
				
				//print "$id_dep - $nombres_dep<br>";
			}			
			$ids_niv = explode('*', $item_nivs);
			$nombres_niv='';
			
			foreach($ids_niv as $id_niv) {
				if($nombres_niv!='')
					$nombres_niv = $nombres_niv.' - ';
				$unnivel = $this->Nivel_model->get_item($id_niv);
				$nombres_niv .= $unnivel[0]['niv_descripcion'];
				//print "$id_dep - $nombres_dep<br>";
			}			
			//print "<br>";
			$data[] = array($item['coo_id'], $item['coo_nombre'], $item['coo_login'], $item['coo_email'], $item['coo_asistente'], $nombres_niv,$cod_dep, /*$item['dep_nombre']*/$nombres_dep, $item['rol_descripcion']	);			
		}
                $nombre = 'coordinadores_'.time();
                $cabeceras = array('ID','Nombre','Login','Email','Asistente','Nivel','Cod Departamento','Departamento','Rol');
                
		
			
		$this->to_excel($cabeceras,$data,$nombre);
		unset($this->Nivel_model);
		unset($this->Departamento_model);
		unset($this->Rol_model);		
	}
        
        private function to_excel($cabeceras,$datos, $filename='exceloutput'){
            
                   $this->load->library('Excel_XML');
                   $data = array(
                                   1 => array ('Name', 'Surname'),
                                   array('Schwarz', 'Oliver'),
                                   array('Test', 'Peter')
                                   );
                   $data = array(
                                   1 => $cabeceras,
                                   );
                   $data = array_merge($data, $datos);

                   $data2=array();
                   foreach($data as $indice=>$valor){
                           $data2[$indice + 1] = $valor;
                   }
                   $data = $data2;
                   // generate file (constructor parameters are optional)
                   $xls = new Excel_XML('UTF-8', false, $filename);
                   $xls->addArray($data);
                   $xls->generateXML($filename);
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
	
	private function _adicionar_foraneas(&$item, $nivel_model, /*$departamento_model,*/ $rol_model, $filas=true){
		if($filas) { //con filas para listado
			$n = 0;
			foreach($data['filas'] as $fila) {			
				$nivel = $nivel_model->get_item($fila['niv_id']);
				/*$departamento = $departamento_model->get_item($fila['dep_id']);*/
				$rol = $rol_model->get_item($fila['rol_id']);
				$filanueva = array_merge($fila, (array)$nivel[0], /*(array)$departamento[0],*/ (array)$rol[0]);
				$item['filas'][$n] = $filanueva;
				$n++;
			}
		}
		else { //sin filas para formulario
			$nivel = $nivel_model->get_item($item['niv_id']);
			/*$departamento = $departamento_model->get_item($item['dep_id']);*/
			$rol = $rol_model->get_item($item['rol_id']);
			$datanueva = array_merge($item, (array)$nivel[0], /*(array)$departamento[0],*/ (array)$rol[0]);
			$item = $datanueva;
		}
	}
        
        /*Revisa los permisos y segun el usuario entrega un tipo de men�*/
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
