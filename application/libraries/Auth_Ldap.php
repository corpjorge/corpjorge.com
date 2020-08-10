<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth_Ldap {
	var $arrayStatusEnabled = array ('512','66048');
	var $arrayStatusDisabled = array ('514','66050');
	
	
    function __construct() {		
        $this->ci =& get_instance();
		$this->ci->load->library('integracion');
		
        log_message('debug', 'Auth_Ldap initialization commencing...');

        // Load the session library
        $this->ci->load->library('session');

        // Load the configuration
        $this->ci->load->config('auth_ldap');

        // Load the language file
        // $this->ci->lang->load('auth_ldap');

        $this->_init();
    }

    
    /**
     * @access private
     * @return void
     */
    private function _init() {

        // Verify that the LDAP extension has been loaded/built-in
        // No sense continuing if we can't
        if (! function_exists('ldap_connect')) {
            show_error('LDAP functionality not present.  Either load the module ldap php module or use a php with ldap support compiled in.');
            log_message('error', 'LDAP functionality not present in php.');
        }

        $this->hosts = $this->ci->config->item('hosts');
        $this->ports = $this->ci->config->item('ports');
        $this->basedn = $this->ci->config->item('basedn');
        $this->account_ou = $this->ci->config->item('account_ou');
        $this->login_attribute  = $this->ci->config->item('login_attribute');
        $this->use_ad = $this->ci->config->item('use_ad');
        $this->ad_domain = $this->ci->config->item('ad_domain');
        $this->proxy_user = $this->ci->config->item('proxy_user');
        $this->proxy_pass = $this->ci->config->item('proxy_pass');
        $this->roles = $this->ci->config->item('roles');
        $this->auditlog = $this->ci->config->item('auditlog');
        $this->member_attribute = $this->ci->config->item('member_attribute');
    }

    /**
     * @access public
     * @param string $username
     * @param string $password
     * @return bool 
     */
    function login($username, $password) {
        /*
         * For now just pass this along to _authenticate.  We could do
         * something else here before hand in the future.
         */

        $user_info = $this->_authenticate($username,$password);
		
//		echo "<pre>"; print_r($user_info); exit;
        if(!$user_info) {
            return FALSE;
        }
        // Record the login
        //$this->_audit("Successful login: ".$user_info['cn']."(".$username.") from ".$this->ci->input->ip_address());

        // Set the session data		
		
        $customdata = array('login' => $user_info['login'],
                            'uspd' => $this->encrypt($password,"SCH"),
                            'nombres' => $this->stripAccents($user_info['nombres']),
                            'apellidos' => $this->stripAccents($user_info['apellidos']),
                            'estatus' => $user_info['estatus'],
                            'uidNumber' => $user_info['uidNumber'],
                            'UACarnetEstudiante' => $user_info['UACarnetEstudiante'],                            
                            'logged_in' => TRUE);
        
    
        $this->ci->session->set_userdata($customdata);
        return TRUE;
    }

    /**
     * @access public
     * @return bool
     */
    function is_authenticated() {
        if($this->ci->session->userdata('logged_in')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * @access public
     */
    function logout() {
        // Just set logged_in to FALSE and then destroy everything for good measure
        $this->ci->session->set_userdata(array('logged_in' => FALSE));
        $this->ci->session->sess_destroy();
    }

    /**
     * @access private
     * @param string $msg
     * @return bool
     */
    private function _audit($msg){
        $date = date('Y/m/d H:i:s');
        if( ! file_put_contents($this->auditlog, $date.": ".$msg."\n",FILE_APPEND)) {
            log_message('info', 'Error opening audit log '.$this->auditlog);
            return FALSE;
        }
        return TRUE;
    }

    /**
     * @access private
     * @param string $username
     * @param string $password
     * @return array 
     */
    private function _authenticate($username, $password) {
		/*
        $needed_attrs = array('uidNumber',
                              'mail','mailUserStatus',
                              'uanumerodocumento',
                              'givenName',
                              'sn',
                              'cn',
                              'dn',
                              $this->login_attribute,
                              'UACarnetEstudiante',
                              'businessCategory'
                            );   
							*/
		//echo "<pre>"; print_r ($needed_attrs); exit;
        $needed_attrs = array('employeeid',
                              'mail','useraccountcontrol',
                              'employeeid',
                              'givenName',
                              'sn',
                              'cn',
                              'dn',
                              $this->login_attribute,
                              'employeeNumber',
                              'memberof'
                            );							      
        // At this point, $this->ldapconn should be set.  If not... DOOM!
        foreach($this->hosts as $host) {
            $this->ldapconn = ldap_connect($host);
            if($this->ldapconn) {
               break;
            }else {
                log_message('info', 'Error connecting to '.$uri);
            }
        }
        if(! @$this->ldapconn) {
            log_message('error', "Couldn't connect to any LDAP servers.  Bailing...");
            show_error('Error connecting to your LDAP server(s).  Please check the connection and try again.');
            return FALSE;
        }
        // We've connected, now we can attempt the login...
        
        // Find the DN of the user we are binding as
        // If proxy_user and proxy_pass are set, use those, else bind anonymously
        if($this->proxy_user) {
            $bind = ldap_bind($this->ldapconn, $this->proxy_user, $this->proxy_pass);
        }elseif($username) {
            //$ldapUser="uid=ctasinfo-ldap,ou=Directory Administrators,dc=uniandes,dc=edu,dc=co";
            //$ldapUser="uid=".$username.",ou=people,dc=uniandes,dc=edu,dc=co";
			$ldapUser="cn=".$username.",ou=people,dc=ad,dc=uniandes,dc=edu,dc=co";            
            //$ldapPwd="lolita";
            $ldapPwd=$password;
            $bind = @ldap_bind($this->ldapconn, $ldapUser, $ldapPwd);
        }else {
            $bind = ldap_bind($this->ldapconn);
        }

        if(!$bind){
            log_message('error', 'Unable to perform anonymous/proxy bind');
            //show_error('Unable to bind for user id lookup');}
			return false;
        }

        log_message('debug', 'Successfully bound to directory.  Performing dn lookup for '.$username);

        $filter = '('.$this->login_attribute.'='.$username.')';
        $search = ldap_search($this->ldapconn, $this->basedn, $filter, $needed_attrs);
        $entries = ldap_get_entries($this->ldapconn, $search);				
		
        if($entries['count']>0){
            $binddn = $entries[0]['dn'];            
            // Now actually try to bind as the user
            $bind = @ldap_bind($this->ldapconn, $binddn, $password);
            if(!$bind) {
            //  $this->_audit("Failed login attempt: ".$username." from ".$_SERVER['REMOTE_ADDR']);
                return FALSE;
            }
//			echo "<pre>"; print_r ($entries);
/*			
            $entrada = ldap_first_entry( $this->ldapconn, $search);
            $nombres = ldap_get_values($this->ldapconn,$entrada,'givenName');
            $apellidos = ldap_get_values($this->ldapconn,$entrada,'sn');			
            $estatus = ldap_get_values($this->ldapconn,$entrada,'mailuserstatus');
            $login = ldap_get_values($this->ldapconn,$entrada,'uid');
            $uid_number = ldap_get_values($this->ldapconn,$entrada,'uidNumber');
            $businessCategory = ldap_get_values($this->ldapconn,$entrada,'businessCategory');
            $ua_carnet_estudiante = FALSE;
			$j = 0;
			$ua_carnet_estudiante = @ldap_get_values($this->ldapconn,$entrada,'UACarnetEstudiante');
			*/
            $entrada = ldap_first_entry( $this->ldapconn, $search);
            $nombres = ldap_get_values($this->ldapconn,$entrada,'givenName');
            $apellidos = ldap_get_values($this->ldapconn,$entrada,'sn');			
			$tmpStatus = ldap_get_values($this->ldapconn,$entrada,'useraccountcontrol');
            $estatus = (in_array($tmpStatus[0], $this->arrayStatusEnabled)) ? 'Active' : 'Inactive';
            $login = ldap_get_values($this->ldapconn,$entrada,'cn');
            $uid_number = ldap_get_values($this->ldapconn,$entrada,'employeeid');
//            $businessCategory = ldap_get_values($this->ldapconn,$entrada,'businessCategory');
			$businessCategory[0] = FALSE;
            $ua_carnet_estudiante = FALSE;
			$j = 0;
			$ua_carnet_estudiante = @ldap_get_values($this->ldapconn,$entrada,'employeenumber');
			
			$memberof = ldap_get_values($this->ldapconn,$entrada,'memberof');
			$filtroEstudiante = '(&(memberOf:1.2.840.113556.1.4.1941:=CN=GG Estudiantes,OU=GROUPS,DC=fundacionuniandes,DC=edu,DC=co)(cn=' . $login[0] . '))';
			$buscarEsEstudiante = ldap_search($this->ldapconn, $this->basedn, $filtroEstudiante);
			$esEstudiante = ldap_get_entries($this->ldapconn, $buscarEsEstudiante);	
//			echo "<pre>";print_r ($esEstudiante);
			if ($esEstudiante['count'] < 1)
				$businessCategory[0] = 'EMPL';	

            if($businessCategory[0]!='EMPL'){
				for($i=0 ; $i<$ua_carnet_estudiante['count']; $i++){
					$pidm = $this->ci->integracion->obtenerPidm($ua_carnet_estudiante[$i]);
					$j = $pidm!='' ? $i : $j;
					$i = $pidm!='' ? $ua_carnet_estudiante['count'] : $i;
				}
				//if(!(@ldap_count_entries($this->ldapconn , $ua_carnet_estudiante) > 0))
				
				//el error 'Sus datos de registro no están completos' ya es lanzado en el controlador
				/*if(!(@$ua_carnet_estudiante['count'] > 0))
					@trigger_error((string)@ldap_error($this->ldapconn), E_USER_ERROR);*/
            }
            //$mail = ldap_get_values($this->ldapconn,$entrada,'mail');
        
            $datos['nombres']=utf8_decode($nombres[0]);
            $datos['apellidos']=utf8_decode($apellidos[0]);
/*            $datos['estatus'] = $estatus[0]; */
			$datos['estatus'] = $estatus;
            $datos['login'] = $login[0];
            $datos['uidNumber'] = $uid_number[0];
			
			//$datos['UACarnetEstudiante'] = $this->ci->integracion->obtenerCodigoActual($datos['login']);
            $datos['UACarnetEstudiante'] = $ua_carnet_estudiante[$j];
			//$datos['UACarnetEstudiante'] = $ua_carnet_estudiante[0];            
            //$datos['mail'] = $login[0];            
            //print_r($datos); exit;
//			echo "<pre>"; print_r ($datos); exit;
            return $datos;    
        }else{
            return FALSE;    
        }        
    }

    public function cargarDatos($codigo) { // Modificado JC 
/*        $needed_attrs = array('uidNumber',
                              'mail','mailUserStatus',
                              'uanumerodocumento',
                              'givenName',
                              'sn',
                              'cn',
                              'dn',
                              $this->login_attribute,
                              'UACarnetEstudiante',
                              'businessCategory'
                            );   
	*/
        $needed_attrs = array('employeeid',
                              'mail','useraccountcontrol',
                              'employeeid',
                              'givenName',
                              'sn',
                              'cn',
                              'dn',
                              $this->login_attribute,
                              'employeenumber',
                              'memberof'
                            );	 
        foreach($this->hosts as $host) {
            $this->ldapconn = ldap_connect($host);
            if($this->ldapconn) {
               break;
            }else {
                log_message('info', 'Error connecting to '.$uri);
            }
        }        
        

        if(! @$this->ldapconn) {
            log_message('error', "Couldn't connect to any LDAP servers.  Bailing...");
            show_error('Error connecting to your LDAP server(s).  Please check the connection and try again.');
            return FALSE;
        }
        if($this->proxy_user) {
            $bind = ldap_bind($this->ldapconn, $this->proxy_user, $this->proxy_pass);
        }elseif($this->decrypt($this->ci->session->userdata("uspd"),"SCH")) {
            //$ldapUser="uid=ctasinfo-ldap,ou=Directory Administrators,dc=uniandes,dc=edu,dc=co";
            $ldapUser="uid=".$this->ci->session->userdata("login").",ou=people,dc=uniandes,dc=edu,dc=co";            
            //$ldapPwd="lolita";
            $ldapPwd=$this->decrypt($this->ci->session->userdata("uspd"),"SCH");;
            $bind = ldap_bind($this->ldapconn, $ldapUser, $ldapPwd);            
        }else {
            $bind = ldap_bind($this->ldapconn);
        }
        if(!$bind){
            log_message('error', 'Unable to perform anonymous/proxy bind');
            show_error('Unable to bind for user id lookup');
        }

        log_message('debug', 'Successfully bound to directory.  Performing dn lookup for '.$codigo);
        //$filter = "(UACarnetEstudiante=$codigo)";
		$filter = "(employeenumber=$codigo)";
        $search = ldap_search($this->ldapconn, $this->basedn, $filter, $needed_attrs,0,0,0,3);
        $entries = ldap_get_entries($this->ldapconn, $search);
//		echo "<pre>"; print_r ($entries);
        if($entries['count']>0){/*
            $entrada = ldap_first_entry( $this->ldapconn, $search);
            $nombres = ldap_get_values($this->ldapconn,$entrada,'givenName');
            $apellidos = ldap_get_values($this->ldapconn,$entrada,'sn');
            $estatus = ldap_get_values($this->ldapconn,$entrada,'mailuserstatus');
            $login = ldap_get_values($this->ldapconn,$entrada,'uid');
            $uid_number = ldap_get_values($this->ldapconn,$entrada,'uidNumber');
            $businessCategory = ldap_get_values($this->ldapconn,$entrada,'businessCategory');
            $ua_carnet_estudiante = FALSE;
			$j = 0;
			$ua_carnet_estudiante = @ldap_get_values($this->ldapconn,$entrada,'UACarnetEstudiante'); */
            $entrada = ldap_first_entry( $this->ldapconn, $search);
            $nombres = ldap_get_values($this->ldapconn,$entrada,'givenName');
            $apellidos = ldap_get_values($this->ldapconn,$entrada,'sn');			
			$tmpStatus = ldap_get_values($this->ldapconn,$entrada,'useraccountcontrol');
            $estatus = (in_array($tmpStatus[0], $this->arrayStatusEnabled)) ? 'Active' : 'Inactive';
            $login = ldap_get_values($this->ldapconn,$entrada,'cn');
            $uid_number = ldap_get_values($this->ldapconn,$entrada,'employeeid');
//			echo "<pre>"; print_r ($tmpStatus);
//            $businessCategory = ldap_get_values($this->ldapconn,$entrada,'businessCategory');
			$businessCategory[0] = FALSE;
            $ua_carnet_estudiante = FALSE;
			$j = 0;
			$ua_carnet_estudiante = @ldap_get_values($this->ldapconn,$entrada,'employeenumber');
			
			$memberof = ldap_get_values($this->ldapconn,$entrada,'memberof');
			$filtroEstudiante = '(&(memberOf:1.2.840.113556.1.4.1941:=CN=GG Estudiantes,OU=GROUPS,DC=ad,DC=uniandes,DC=edu,DC=co)(cn=' . $login[0] . '))';
			$buscarEsEstudiante = ldap_search($this->ldapconn, $this->basedn, $filtroEstudiante);
			$esEstudiante = ldap_get_entries($this->ldapconn, $buscarEsEstudiante);	
//			echo "<pre>";print_r ($esEstudiante);
			if ($esEstudiante['count'] < 1)
				$businessCategory['count'] = 0;	

			
            if($businessCategory['count']=='0'){
				
				for($i=0 ; $i<$ua_carnet_estudiante['count']; $i++){
					$pidm = $this->ci->integracion->obtenerPidm($ua_carnet_estudiante[$i]);
					$j = $pidm!='' ? $i : $j;
					$i = $pidm!='' ? $ua_carnet_estudiante['count'] : $i;
				}
				//if(!(@ldap_count_entries($this->ldapconn , $ua_carnet_estudiante) > 0))
				
				//el error 'Sus datos de registro no están completos' ya es lanzado en el controlador
				/*if(!(@$ua_carnet_estudiante['count'] > 0))
					@trigger_error((string)@ldap_error($this->ldapconn), E_USER_ERROR);*/
            }
            $datos['nombres']=$nombres[0];
            $datos['apellidos']=$apellidos[0];
            $datos['estatus'] = $estatus;
            $datos['login'] = $login[0];
            $datos['correouniandes'] = $login[0]."@uniandes.edu.co";
            $datos['uidNumber'] = $uid_number[0];
			
			//$datos['UACarnetEstudiante'] = $this->ci->integracion->obtenerCodigoActual($datos['login']);
			$datos['UACarnetEstudiante'] = $ua_carnet_estudiante[$j];
            //$datos['UACarnetEstudiante'] = $ua_carnet_estudiante[0];
//			echo "<pre>"; print_r ($datos);
            return $datos;
        }else{
            return FALSE;    
        }
    }
    /**
     * Funcion para encriptar datos obtenidos privados de autenticación
     * 
     * @param type $string Cadena
     * @param type $key Llave de encripción
     * @return type cadena encriptada
     */
    private function encrypt($string, $key) {
        $result = '';
        for($i=0; $i<strlen($string); $i++) {
           $char = substr($string, $i, 1);
           $keychar = substr($key, ($i % strlen($key))-1, 1);
           $char = chr(ord($char)+ord($keychar));
           $result.=$char;
        }
        return base64_encode($result);
     }
     /**
      * Función para desencriptar datos privados de autenticación 
      * 
      * @param type $string Cadena encriptada
      * @param type $key llave de encripción
      * @return type cadena original
      */
     private function decrypt($string, $key) {
        $result = '';
        $string = base64_decode($string);
        for($i=0; $i<strlen($string); $i++) {
           $char = substr($string, $i, 1);
           $keychar = substr($key, ($i % strlen($key))-1, 1);
           $char = chr(ord($char)-ord($keychar));
           $result.=$char;
        }
        return $result;
     }
	 private function stripAccents($String)
	{			
		$String = ereg_replace("[äàâãª]","a",$String);	
		$String = ereg_replace("[ÀÂÃÄ]","A",$String);	
		$String = ereg_replace("[ÌÎÏ]","I",$String);	
		$String = ereg_replace("[ìîï]","i",$String);	
		$String = ereg_replace("[èêë]","e",$String);	
		$String = ereg_replace("[ÈÊË]","E",$String);	
		$String = ereg_replace("[òôõöº]","o",$String);	
		$String = ereg_replace("[ÒÔÕÖ]","O",$String);	
		$String = ereg_replace("[ùûü]","u",$String);	
		$String = ereg_replace("[ÙÛÜ]","U",$String);			
		$String = str_replace("ç","c",$String);	
		$String = str_replace("Ç","C",$String);					
		$String = str_replace("Ý","Y",$String);	
		$String = str_replace("ý","y",$String);			
		return $String;	
	}
}
	
?>
