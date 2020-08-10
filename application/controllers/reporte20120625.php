<?php

class Reporte extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');		
		$this->load->library('session');
		$this->load->library('integracion');		
		$this->load->model('Solicitud_model', '', TRUE);
		$this->load->model('Menu_model','',TRUE);
	}

	function index(){
		$menu = $this->Menu_model->_getmenu();
		$data = array(
			'titulo' => 'Generaci&oacute;n de reportes',
			'menu'=>$menu,
		);
		$data['option_prog']= array();
		$coor_pro = array();
		if($this->session->userdata('rol')>1){
			$mis_prog = explode('*',$this->session->userdata('programas'));
			foreach($mis_prog as $valor){
				$nombre = @$this->integracion->obtenerPrograma($valor);
				$coor_pro[$valor] = $nombre;
			}
			$data['option_prog'] = $coor_pro;			
		}else{
			$data['option_prog']= @$this->integracion->programasActivos();			
		}
		array_unshift($data['option_prog'], "Seleccione Programa");
		$this->load->model('Estado_model', '', TRUE);
		$data['option_est']=  $this->Estado_model->get_all();
		$data['option_est'] = $this->Estado_model->get_dropdown(TRUE);
		$this->load->view('reporte_form', $data);
	}

	private function _getmenu(){
		$this->load->model('Rol_model','',TRUE);
		$rol_name = $this->Rol_model->get_item($this->session->userdata('rol'));
		$menu='';
		$data = array('usuario'=>$this->session->userdata('login'),'rol_name'=>$rol_name[0]['rol_descripcion']);
		if($this->session->userdata('logged_in')){
			if($this->session->userdata('rol')==1){
				$menu = $this->load->view('_menu_admin',$data, true);
			}else{
				if($this->session->userdata('rol')==2)
					$menu = $this->load->view('_menu_normal',$data, true);
				else
					redirect('/auth');
			}
		}else{
			redirect('/auth');
			return false;
		}
		return $menu;
	}
	
	public function validar()
	{
		$this->form_validation->set_rules('fecha_ini', 'Fecha inicio', 'required');
		$this->form_validation->set_rules('fecha_fin', 'Fecha fin', 'required');
		return $this->form_validation->run();
	}
	
	public function busquedaReporte(){
		$programa_id = ($this->input->post('programa_id'))?$this->input->post('programa_id'):' ';
		$estado_id = ($this->input->post('estado_id'))?$this->input->post('estado_id'):' ';
		$fecha_ini = ($this->input->post('fecha_ini'))?$this->input->post('fecha_ini'):' ';
		$fecha_fin = ($this->input->post('fecha_fin'))?$this->input->post('fecha_fin'):' ';
		$reporte = ($this->input->post('reporte'))?$this->input->post('reporte'):' ';
				
			$menu = $this->Menu_model->_getmenu();
		$data = array(
			'titulo' => 'REPORTES',
			/*'menu'=>$menu,*/
			'reporte'=>$reporte,
			'programa_id'=>$programa_id,
			'estado_id'=>$estado_id,
			'fecha_ini'=>$fecha_ini,
			'fecha_fin'=>$fecha_fin
			);
		$template = '';
		switch ($reporte){
			case '1':
				$template='resultados_reporte';
				break;
			case '2':
				$template='resultados_reporte_2';
				break;
			case '3':
				$template='resultados_reporte_3';
				break;
			
		}
		$this->load->view($template, $data);		
	}
	
	public function page(){
		$this->load->model('Tipo_model','',TRUE);
		$this->load->model('Motivo_model','',TRUE);
		$this->load->model('Estado_model','',TRUE);
		$datos = array();
		$datos['page'] = $this->input->post('page');			
		$datos['sortname'] = ($this->input->post('sortname')!='')?$this->input->post('sortname'):$this->Solicitud_model->tableLlave();		
		$datos['sortorder'] = ($this->input->post('sortorder')!='')?$this->input->post('sortorder'):'ASC';
		$datos['qtype'] = ($this->input->post('qtype')!='')?$this->input->post('qtype'):'';
		$datos['query'] = ($this->input->post('query')!='')?$this->input->post('query'):'';		
		$datos['otro'] =($this->input->post('otro')!='')?$this->input->post('otro'):' *** *** *** ';
		$inicio = ((int)($this->input->post('page'))-1)*(int)$this->input->post('rp');
		$otrosparams = explode('***',$datos['otro']);		
		$programa_id = $otrosparams[0];
		$estado_id = $otrosparams[1];
		$fecha_ini = $otrosparams[2];
		$fecha_fin = $otrosparams[3];
		$reporte = $otrosparams[4];
		$id = 0;
		$mis_prog = array();
		$mis_niveles = array();		
		if($this->session->userdata('rol')>1){
			$mis_prog = explode('*',$this->session->userdata('programas'));
			$mis_niveles = explode('*',$this->session->userdata('niveles'));
		}			
		switch($reporte){			
			case '1':				
				$filas = $this->Solicitud_model->reporte_solicitudes(TRUE,$programa_id, $estado_id, $fecha_ini, $fecha_fin, $inicio, $this->input->post('rp'), $datos['sortname'], $datos['sortorder'],$mis_prog,$mis_niveles);				
				$datos['total'] = $this->Solicitud_model->count_reporte_solicitudes($programa_id, $estado_id, $fecha_ini, $fecha_fin, $inicio, $this->input->post('rp'), $datos['sortname'], $datos['sortorder'],$mis_prog,$mis_niveles);
				foreach($filas as $item){
					$item['sol_fec_creacion'] = substr($item['sol_fec_creacion'], 0, -3);
					$profesores = '';
					$instructor = explode(',',$item['sol_ins_instructor']);
					foreach($instructor as $unp){
						$profesores .= $unp.'<br>';
					}
					$this->_adicionar_foraneas($item, $this->Tipo_model, $this->Motivo_model, $this->Estado_model, false);
					$color = $this->_get_color($item['est_id']);			
					$datos['rows'][] = array(
						'id' => $item['sol_id'],				
						'cell' => array($item['sol_id'],
								$item['sol_ins_mat'],
								$item['sol_ins_crn'],
								$item['sol_ins_des'],
								$item['sol_ins_seccion'],
								$profesores,												
								$item['sol_descripcion'],
								$item['tip_descripcion'],
								$item['mov_descripcion'],
								$item['sol_fec_creacion'],
								$item['sol_nombre'],
								$item['sol_apellido'],
								$item['sol_uidnumber'],						
								$color)
					);		
				}				
			break;
			case '2':
				$filas = $this->Solicitud_model->reporte_solicitud_estado(true,$programa_id, $estado_id, $fecha_ini, $fecha_fin, $inicio, $this->input->post('rp'), $datos['sortname'], $datos['sortorder'],$mis_prog,$mis_niveles);
				$datos['total'] = $this->Solicitud_model->count_reporte_solicitud_estado($programa_id, $estado_id, $fecha_ini, $fecha_fin, $inicio, $this->input->post('rp'), $datos['sortname'], $datos['sortorder'],$mis_prog,$mis_niveles);		
				foreach($filas as $item){
					$id++;
					$datos['rows'][] = array(
						'id' => $id,				
						'cell' => array($item['dep_id'],
								$item['est_descripcion'],
								$item['total']
								)
					);		
				}
			break;
			case '3':
				$filas = $this->Solicitud_model->reporte_solicitud_crn(true,$programa_id, $estado_id, $fecha_ini, $fecha_fin, $inicio, $this->input->post('rp'), $datos['sortname'], $datos['sortorder'],$mis_prog,$mis_niveles);
				$datos['total'] = $this->Solicitud_model->count_reporte_solicitud_crn($programa_id, $estado_id, $fecha_ini, $fecha_fin, $inicio, $this->input->post('rp'), $datos['sortname'], $datos['sortorder'],$mis_prog,$mis_niveles);		
				foreach($filas as $item){
					$id++;
					$datos['rows'][] = array(
						'id' => $id,				
						'cell' => array($item['sol_ins_crn'],
								$item['dep_id'],
								$item['total'])
					);		
				}
			break;
		}		
		echo json_encode($datos);
		unset($this->Tipo_model);
		unset($this->Motivo_model);
		unset($this->Estado_model);		
	}
	
	public function excel(){
		$this->load->model('Tipo_model','',TRUE);
		$this->load->model('Motivo_model','',TRUE);
		$this->load->model('Estado_model','',TRUE);
		$reporte = $this->input->post('reporte_2');
		$programa_id = ($this->input->post('programa_id_2'))?$this->input->post('programa_id_2'):'';
		$estado_id = ($this->input->post('estado_id_2'))?$this->input->post('estado_id_2'):'';
		$fecha_ini = ($this->input->post('fecha_ini_2'))?$this->input->post('fecha_ini_2'):'';
		$fecha_fin = ($this->input->post('fecha_fin_2'))?$this->input->post('fecha_fin_2'):'';
		//echo "programa_id $programa_id, estado_id $estado_id, fecha_ini $fecha_ini, fecha_fin $fecha_fin";
		$cabeceras = array();
		$datos = array();
		$nombre = '';
		
		$mis_prog = array();
		$mis_niveles = array();		
		if($this->session->userdata('rol')>1){
			$mis_prog = explode('*',$this->session->userdata('programas'));
			$mis_niveles = explode('*',$this->session->userdata('niveles'));
		}
		
		switch($reporte){
			case '1':
				$nombre = 'solicitudes_'.time();
				$filas = $this->Solicitud_model->reporte_solicitudes(false,$programa_id, $estado_id, $fecha_ini, $fecha_fin, 0, 50, 'sol_id', 'ASC',$mis_prog,$mis_niveles);
				$cabeceras = array('ID','Cod Materia','CRN','Materia','Seccion','Profesor','Descripcion','Tipo','Motivo','Fecha','Estudiante','Apellido','Codigo','Estado');
				foreach($filas as $item){
					$item['sol_fec_creacion'] = substr($item['sol_fec_creacion'], 0, -3);
					$profesores = '';
					$instructor = explode(',',$item['sol_ins_instructor']);
					foreach($instructor as $unp){
						$profesores .= $unp.',';
					}					
					$this->_adicionar_foraneas($item, $this->Tipo_model, $this->Motivo_model, $this->Estado_model, false);
					$color = $this->_get_color($item['est_id']);			
					$datos[] = array($item['sol_id'],
							$item['sol_ins_mat'],
							$item['sol_ins_crn'],
							$item['sol_ins_des'],
							$item['sol_ins_seccion'],
							trim($profesores,','),												
							$item['sol_descripcion'],
							$item['tip_descripcion'],
							$item['mov_descripcion'],
							$item['sol_fec_creacion'],
							$item['sol_nombre'],
							$item['sol_apellido'],
							$item['sol_uidnumber'],						
							$color);
					//var_dump($datos);
					
				}				
			break;
			case '2':
				$nombre = 'solicitudes_estado'.time();
				$filas = $this->Solicitud_model->reporte_solicitud_estado(false,$programa_id, $estado_id, $fecha_ini, $fecha_fin, 0, 50, 'dep_id', 'ASC',$mis_prog,$mis_niveles);
				$cabeceras = array('Programa','Estado','Total');
				foreach($filas as $item){					
					$datos[] = array($item['dep_id'],
								$item['est_descripcion'],
								$item['total']
								);					
				}
			break;
			case '3':
				$nombre = 'solicitudes_crn'.time();
				$filas = $this->Solicitud_model->reporte_solicitud_crn(false,$programa_id, $estado_id, $fecha_ini, $fecha_fin, 0, 50, 'sol_ins_crn', 'ASC',$mis_prog,$mis_niveles);
				$cabeceras = array('CRN','Programa','Total');
				foreach($filas as $item){				
					$datos[] = array($item['sol_ins_crn'],
								$item['dep_id'],
								$item['total']
					);		
				}
			break;
		}		
		$this->to_excel($cabeceras,$datos,$nombre);
		unset($this->Tipo_model);
		unset($this->Motivo_model);
		unset($this->Estado_model);		
	}
	
	private function _get_count($rol,$qtype,$query){
		
		$filas = array();
		switch($rol){
			case 1:
			 $filas = $this->Solicitud_model->get_count($qtype,$query);		
			break;
			case 2:			 
			 $programas = explode('*',$this->session->userdata('programas'));
			 $filas = $this->Solicitud_model->get_count_coordinador($qtype,$query,$programas,'dep_id');			
			break;
			case 3:
			 $login = $this->session->userdata('login');
			 $filas = $this->Solicitud_model->get_count($qtype,$query,$login,'sol_login');
			break;
		}
		return $filas;
		
	}
	
	private function _get_color($id){
		$this->load->model('Estado_model','',TRUE);
		$item = $this->Estado_model->get_item($id);
		return $item[0]['est_descripcion'];
		/*$color = '';		
		$height='10px';
		switch($id){
			case 1 :
				$color = '<div style="background-color:#5B86EA;height:'.$height.'"></div>';
			break;
			case 2 :
				$color = '<div style="background-color:#339933;height:'.$height.'"></div>';
			break;
			case 3 :
				$color = '<div style="background-color:#66CC66;height:'.$height.'"></div>';
			break;
			case 4 :
				$color = '<div style="background-color:#CC9900;height:'.$height.'"></div>';
			break;
			case 5 :
				$color = '<div style="background-color:#CC6600;height:'.$height.'"></div>';
			break;
			case 6 :
				$color = '<div style="background-color:#333333;height:'.$height.'"></div>';
			break;
			case 7 :
				$color = '<div style="background-color:#CC3300;height:'.$height.'"></div>';
			break;				
		}
		return $color;		*/
		
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
	
	private function to_excel($cabeceras,$datos, $filename='exceloutput'){
         /*$headers ='';
	 $data ='';
         if (count($datos) == 0) {
              echo '<p>No hay datos.</p>';
         } else {
              foreach ($cabeceras as $field) {
                 $headers .= $field. "\t";
              }         
              foreach ($datos as $row) {
		   
                   $line = '';
                   foreach($row as $value) {                                            
                        if ((!isset($value)) OR ($value == "")) {
                             $value = "\t";
                        } else {
                             $value = str_replace('"', '""', $value);
                             $value = '"' . $value . '"' . "\t";
                        }
						
                        $line .= utf8_decode($value);
                   }
                   $data .= trim($line)."\n";
              }              
              $data = str_replace("\r","",$data);                             
              header("Content-type: application/x-msdownload");
              header("Content-Disposition: attachment; filename=$filename.xls");
              echo "$headers\n$data";  
         }*/
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
    
    public function columnas(){
	$ordencol = $this->input->post('ordencol');
	$ordencol_label = $this->input->post('ordencol_label');
	$ordencol_width = $this->input->post('ordencol_width');	
	$qtype = $this->input->post('qtype');
	$query = $this->input->post('query');
	$qtype2 = $this->input->post('qtype2');
	$query2 = $this->input->post('query2');
	
	$columnas = $this->input->post('ocultas');
	$columnas .= $this->session->userdata('colocultas')!='' ? $this->session->userdata('colocultas') : '';
	$datos_sesion= array(
		'colocultas'=>$columnas,
		'ordencol'=>$ordencol,
		'ordencol_label'=>$ordencol_label,
		'ordencol_width'=>$ordencol_width,
		'qtype'=>$qtype,
		'query'=>$query,
		'qtype2'=>$qtype2,
		'query2'=>$query2,
	);
	$this->session->set_userdata($datos_sesion);
	echo 'OK';	
    }    
    
}