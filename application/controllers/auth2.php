<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * This file is part of Auth_Ldap.

    Auth_Ldap is free software: you can redistribute it and/or modify
    it under the terms of the GNU Lesser General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Auth_Ldap is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Auth_Ldap.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */

/**
 * @author      Greg Wojtak <gwojtak@techrockdo.com>
 * @copyright   Copyright © 2010,2011 by Greg Wojtak <gwojtak@techrockdo.com>
 * @package     Auth_Ldap
 * @subpackage  auth demo
 * @license     GNU Lesser General Public License
 */
class Auth extends CI_Controller {
    function __construct() {
        parent::__construct();
        
        $this->load->helper('form');
        $this->load->library('Form_validation');
        $this->load->library('Auth_Ldap');                
        $this->load->helper('url');
        $this->load->library('table');        
        $this->load->model('Rol_model','',TRUE);
        $this->load->model('Coordinador_model','',TRUE);
        $this->load->model('Parametro_model','',TRUE);
        $this->load->library('integracion');
        
    }

    function index($causa='') {
        $this->session->keep_flashdata('tried_to');

		$mensaje = ($causa!='') ? 'Acceso denegado, por favor revise:' : '';
		$arcausa = explode ('-', $causa);
		foreach($arcausa as $c){
			switch ($c) {
				case '1':
					$mensaje .= '\nSuspensiones Académicas';
					break;
				case '2':
					$mensaje .= '\nSuspensiones Disciplinarias';
					break;
				case '3':
					$mensaje .= '\nRetenciones';
					break;
				case '4':
					$mensaje .= '\nTurno Galpón';
					break;
				case '5':
					$mensaje .= '\nNiveles';
					break;
				case '61':
					$mensaje = 'No existe un registro compatible para este usuario';//'No se encuentra pidm con el uidnumber';
					break;	
				case '62':
					$mensaje = 'Sus datos de registro no están completos';//'No se encuentra uidnumber o no tiene 9 dígitos';
					break;
				case '63':
					$mensaje = 'No es posible el acceso';//'No se encuentra pidm con el UACarnetEstudiante';
					break;
			}
		}
        $this->login($mensaje);        
    }

    function login($errorMsg = NULL){                
        $this->session->keep_flashdata('tried_to');
        if(!$this->auth_ldap->is_authenticated()) {
            // Set up rules for form validation
            $rules = $this->form_validation;
            $rules->set_rules('username', 'Nombre de usuario', 'required');
            $rules->set_rules('password', 'Contraseña', 'required');

            // Do the login...
            if($rules->run() && $this->auth_ldap->login(
                    $rules->set_value('username'),
                    $rules->set_value('password'))) {
                // Login WIN!
                if($this->session->flashdata('tried_to')) {
                    redirect($this->session->flashdata('tried_to'));
                }else {
                    //que tipo de usuario
                    $login = $this->session->userdata('login');
                    $this->_check_rol($login);                    
                    //
                    redirect('/solicitud/');
                }
            }else {
                // Login FAIL
				if($rules->set_value('username')!='' && $rules->set_value('password')!='') //logout no muestra $errorMsg
					$errorMsg = 'Usuario o contraseña incorrecta';
                $this->load->view('auth/login_form_test', array('login_fail_msg'
                                        => $errorMsg,'titulo'=>'Login'));
            }
        }else{
                // Already logged in...
                redirect('/solicitud/');
        }
    }	
	

    function logout($causa='') {
        if($this->session->userdata('logged_in')) {            
            $this->auth_ldap->logout();
        } else {
            $data['logged_in'] = FALSE;
        }
        redirect('/auth/index/'.$causa);
    }
    
    private function _check_rol($login){
        $coordinador = $this->Coordinador_model->get_item($login,'coo_login');
        
        //obtengo el periodo actual
        $periodo = $this->Parametro_model->get_item('periodo','par_nombre');
        $periodo = $periodo[0]['par_valor'];
		$fecha_fin = $this->Parametro_model->get_item('fecha final','par_nombre');
        $fecha_fin = $fecha_fin[0]['par_valor'];

        if(count($coordinador)>0){
            $dato_sesion = array('rol'=>$coordinador[0]['rol_id'],'programas'=>$coordinador[0]['dep_id'],'niveles'=>$coordinador[0]['niv_id']);
            
        }else{//estudiante
			
			//$this->session->set_userdata(array('UACarnetEstudiante'=>'200520490', 'uidnumber'=>''));//prueba
			$pidm = '';
            if(!$this->session->userdata('UACarnetEstudiante')){
				if($this->session->userdata('uidnumber') && strlen($this->session->userdata('uidnumber'))==9){
					$pidm = $this->integracion->obtenerPidm($this->session->userdata('uidnumber'));
					if($pidm=='')
						$causa = '61';					
				}
				else
					$causa = '62';
            }
			else {
				$pidm = $this->integracion->obtenerPidm($this->session->userdata('UACarnetEstudiante'));
				if($pidm=='')
					$causa = '63';
			}
			if($pidm==''){
				redirect('/auth/logout/'.$causa);
				die;
			}
            //$pidm = $this->integracion->obtenerPidm('200420415');            
            
            $datos_estudiante = $this->integracion->datosEstudiante($pidm,$periodo);            
            
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
            if(!$balance){				
                redirect('/auth/logout/'.$causa);
                die;
            }            
            $dato_sesion = array('rol'=>3,'pidm'=>$pidm,'programas'=>$datos_estudiante['CODIGO_PROGRAMA']);
        }        
        $this->session->set_userdata($dato_sesion);
    }
}

?>
