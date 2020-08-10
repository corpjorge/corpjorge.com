<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth_Ldap {
    function __construct() {
        $this->ci =& get_instance();

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
        if(!$user_info) {
            return FALSE;
        }
        // Record the login
        //$this->_audit("Successful login: ".$user_info['cn']."(".$username.") from ".$this->ci->input->ip_address());

        // Set the session data
        $customdata = array('login' => $user_info['login'],
                            'nombres' => $user_info['nombres'],
                            'apellidos' => $user_info['apellidos'],
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
        }else {
            $bind = ldap_bind($this->ldapconn);
        }

        if(!$bind){
            log_message('error', 'Unable to perform anonymous/proxy bind');
            show_error('Unable to bind for user id lookup');
        }

        log_message('debug', 'Successfully bound to directory.  Performing dn lookup for '.$username);
        $filter = '('.$this->login_attribute.'='.$username.')';
        $search = ldap_search($this->ldapconn, $this->basedn, $filter, $needed_attrs);
        $entries = ldap_get_entries($this->ldapconn, $search);
        if($entries['count']>0){
            $binddn = $entries[0]['dn'];            
            // Now actually try to bind as the user
            $bind = @ldap_bind($this->ldapconn, $binddn, $password);
            if(! $bind) {
            //  $this->_audit("Failed login attempt: ".$username." from ".$_SERVER['REMOTE_ADDR']);
                return FALSE;
            }
            $entrada = ldap_first_entry( $this->ldapconn, $search);
            $nombres = ldap_get_values($this->ldapconn,$entrada,'givenName');
            $apellidos = ldap_get_values($this->ldapconn,$entrada,'sn');
            $estatus = ldap_get_values($this->ldapconn,$entrada,'mailuserstatus');
            $login = ldap_get_values($this->ldapconn,$entrada,'uid');
            $uid_number = ldap_get_values($this->ldapconn,$entrada,'uidNumber');
            $businessCategory = ldap_get_values($this->ldapconn,$entrada,'businessCategory');
            $ua_carnet_estudiante = FALSE;
            if($businessCategory[0]!='EMPL'){
                $ua_carnet_estudiante = ldap_get_values($this->ldapconn,$entrada,'UACarnetEstudiante');                
            }
            //$mail = ldap_get_values($this->ldapconn,$entrada,'mail');
        
            $datos['nombres']=$nombres[0];
            $datos['apellidos']=$apellidos[0];
            $datos['estatus'] = $estatus[0];
            $datos['login'] = $login[0];
            $datos['uidNumber'] = $uid_number[0];
            $datos['UACarnetEstudiante'] = $ua_carnet_estudiante[0];            
            //$datos['mail'] = $login[0];            
            
            return $datos;    
        }else{
            return FALSE;    
        }        
    }

    public function cargarDatos($codigo) { // Modificado JC
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
        }else {
            $bind = ldap_bind($this->ldapconn);
        }
        if(!$bind){
            log_message('error', 'Unable to perform anonymous/proxy bind');
            show_error('Unable to bind for user id lookup');
        }

        log_message('debug', 'Successfully bound to directory.  Performing dn lookup for '.$codigo);
        $filter = "(UACarnetEstudiante=$codigo)";
        $search = ldap_search($this->ldapconn, $this->basedn, $filter, $needed_attrs,0,0,0,3);
        $entries = ldap_get_entries($this->ldapconn, $search);
        if($entries['count']>0){
            $entrada = ldap_first_entry( $this->ldapconn, $search);
            $nombres = ldap_get_values($this->ldapconn,$entrada,'givenName');
            $apellidos = ldap_get_values($this->ldapconn,$entrada,'sn');
            $estatus = ldap_get_values($this->ldapconn,$entrada,'mailuserstatus');
            $login = ldap_get_values($this->ldapconn,$entrada,'uid');
            $uid_number = ldap_get_values($this->ldapconn,$entrada,'uidNumber');
            $businessCategory = ldap_get_values($this->ldapconn,$entrada,'businessCategory');
            $ua_carnet_estudiante = FALSE;
            if($businessCategory['count']=='0'){
                $ua_carnet_estudiante = ldap_get_values($this->ldapconn,$entrada,'UACarnetEstudiante');                
            }
            $datos['nombres']=$nombres[0];
            $datos['apellidos']=$apellidos[0];
            $datos['estatus'] = $estatus[0];
            $datos['login'] = $login[0];
            $datos['correouniandes'] = $login[0]."@uniandes.edu.co";
            $datos['uidNumber'] = $uid_number[0];
            $datos['UACarnetEstudiante'] = $ua_carnet_estudiante[0];
            return $datos;
        }else{
            return FALSE;    
        }
    }

}

?>
