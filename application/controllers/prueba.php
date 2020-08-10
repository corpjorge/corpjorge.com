<?php
class prueba extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->library('integracion');
		$this->load->model('Parametro_model','',TRUE);
	}

	function index($codigo){
		session_start();
		//$_SESSION['Hola']="mundo";
		echo '<pre>';
		print_r($_SESSION);
		echo '</pre>';
		
		echo '<pre>';
		print_r($this->session);
		echo '</pre>';
	
		$periodo = $this->Parametro_model->get_item('periodo','par_nombre');
        $periodo = $periodo[0]['par_valor'];
		$fecha_fin = $this->Parametro_model->get_item('fecha final','par_nombre');
        $fecha_fin = $fecha_fin[0]['par_valor'];


		$pidm = $data['PIDM']=$this->integracion->obtenerPidm($codigo);
		$data['periodo']=$periodo;
		$datos_estudiante =$data['datos_estudiante'] = $this->integracion->datosEstudiante($data['PIDM'],$periodo);
		
		$balance=TRUE;
		$causa = '';
		
        //obtengo el indicador de evaluacion de suspensiones academicas actual
        $sa = $this->Parametro_model->get_item('suspensiones academicas','par_nombre');
        $sa = $sa[0]['par_valor'];
        if($sa=='1' /*&& $balance*/){
            $balance = $this->integracion->existenSuspensionesAcademicas($pidm);
			//$balance = FALSE;
			if(!$balance){
				$causa .= ($causa!='') ? '-' : '';
				$causa .= '1';
			}
            //var_dump($balance);
        }
        
        //obtengo el indicador de evaluacion de suspensiones disciplinarias actual
        $sd = $this->Parametro_model->get_item('suspensiones disciplinarias','par_nombre');
        $sd = $sd[0]['par_valor'];
        if($sd=='1' /*&& $balance*/){
            $balance = $this->integracion->existenSuspensionesDisciplinarias($pidm);
			//$balance = FALSE;
			if(!$balance){
				$causa .= ($causa!='') ? '-' : '';
				$causa .= '2';
			}
            //var_dump($balance); echo "2";                
            
        }
        
        //obtengo el indicador de evaluacion de restricciones actual
        $rest = $this->Parametro_model->get_item('restricciones','par_nombre');
        $rest = $rest[0]['par_valor'];
        if($rest=='1' /*&& $balance*/){
            $balance = $this->integracion->existenRestricciones($pidm);
			//$balance = FALSE;
			if(!$balance){
				$causa .= ($causa!='') ? '-' : '';
				$causa .= '3';
			}
            //var_dump($balance); echo "3";
        }
        
        //obtengo el indicador de evaluacion de galpon actual
        $galp = $this->Parametro_model->get_item('turno de galpon','par_nombre');
        $galp = $galp[0]['par_valor'];      
        if(!($galp=='0' && $fecha_fin=='')){//if(/*$galp=='1' &&*/ $balance){                
            $balance = $this->integracion->turnoGalpon($pidm, $periodo, $fecha_fin, $galp);
			//$balance = FALSE;
			if(!$balance){
				$causa .= ($causa!='') ? '-' : '';
				$causa .= '4';
			}
            //var_dump($balance); echo "4";                
        }
                    
        //obtengo el indicador de evaluacion de galpon actual
        $niveles = $this->Parametro_model->get_item('niveles','par_nombre');
        $niveles = $niveles[0]['par_valor'];
        if($niveles=='1' /*&& $balance*/){
            if($datos_estudiante['NIVEL']==PREGRADO && $datos_estudiante['NIVEL']==MAESTRIA){
                $balance = TRUE;
            }
			else
				$balance = FALSE;
			
			//$balance = FALSE;
			if(!$balance){
				$causa .= ($causa!='') ? '-' : '';
				$causa .= '5';
			}			
        } 
		$data['causa']=$causa;

		$this->load->view('prueba_form', $data);

	}
}