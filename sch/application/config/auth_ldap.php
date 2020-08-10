<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['hosts'] = array('ldappr.uniandes.edu.co');
$config['ports'] = array(389);
$config['basedn'] = 'ou=people,dc=uniandes,dc=edu,dc=co';
$config['login_attribute'] = 'uid';
$config['use_ad'] = false;
$config['ad_domain'] = '';
$config['proxy_user'] = '';
$config['proxy_pass'] = '';
$config['roles'] = array(1 => 'User', 
    3 => 'Power User',
    5 => 'Administrator');
$config['member_attribute'] = 'memberUid';
$config['auditlog'] = 'application/logs/audit.log';  // Some place to log attempted logins (separate from message log)
// Autenticacion LDAP

/*$config['LDAP_SUCCESS'];
$config['LDAP_INVALID_CREDENTIALS'];
$config['PUERTOLDAP'] =  '389';
$config['SERVIDOR_LDAP'] =  'ldappr.uniandes.edu.co';
$config['BASE_BUSQUEDA'] = 'ou=people,dc=uniandes,dc=edu,dc=co';
$config['BINDLDAP_USER'] = 'cn=Directory manager';
$config['BINDLDAP_CLAVE']= 'lolita';
$config['LDAP_ESTADO'] = 'mailUserStatus';
$config['LDAP_USUARIO']= 'uid';
$config['LDAP_IDENTIFICACION'] ='uanumerodocumento';
$config['LDAP_CORREO' ]='mail'; 
$config['LDAP_FORWARD'] =  'mailRoutingAddress';
$config['LDAP_ALIAS']= 'mailAlternateAddress';
$config['LDAP_NOMBRES'] = 'givenName';
$config['LDAP_APELLIDOS'] =  'sn';
$config['LDAP_CN_CORREOS'] = 'cn';
$config['APELLIDO_CORREO'] = '@egresados.uniandes.edu.co';*/
?>
