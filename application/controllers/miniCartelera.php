<?php

class miniCartelera extends CI_Controller {

        public function __construct(){
		parent::__construct();
                $this->load->library('form_validation');
		//$this->load->model('crnSelector_model','',FALSE);		
		//$this->load->library('conflictos');
	}
        
        public function index(){           
//		$data = array('titulo' => 'Hola mundito prueba 1');
////		$this->_prepare_list($data);
////		print_r($data);
//		//$this->load->view('crnSelector', $data);
//                $this->load->library('integracion');                
//                //$retorno= $this->integracion->programasActivos();
//                $retorno= $this->integracion->obtenerPidm('200420415');
//                echo "<pre>";
//                var_dump($retorno);
//                echo "</pre>";
        }
        public function busquedaMinicartelera(){
            //
            $parametros['titulo'] = 'ADMINISTRADOR DE Solicitudes';
            $crn=$this->input->post('crn');
            $programa=$this->input->post('programa_id');
            $materia1=$this->input->post('materia1');
            $seccion1=$this->input->post('seccion1');
            $materia2=$this->input->post('materia2');
            $seccion2=$this->input->post('seccion2');
            $btn1=$this->input->post('buscar1');
            $btn2=$this->input->post('buscar2');
            $btn3=$this->input->post('buscar3');
            if(!empty ($btn1))$parametros['busqueda']['crn']=$crn;
            if(!empty ($btn2)){
                $parametros['busqueda']['programa']=$programa;
                $parametros['busqueda']['materia']=$materia1;
                $parametros['busqueda']['seccion']=$seccion1;                
            }
            if(!empty ($btn3)){
                $parametros['busqueda']['materia']=$materia2;
                $parametros['busqueda']['seccion']=$seccion2;
            }
            //echo "entro"; exit();
            $this->load->view('resultados_mini_cartelera',$parametros);
        }

}
?>
