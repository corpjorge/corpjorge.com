<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| OCI database conection
|--------------------------------------------------------------------------
|
| These constants are used in the ociInteractor class, calling and connecting to "BANNER"
|
*/
define ('DB_USER', 'PORTAL_AYR');
define ('DB_PWD', 'PORTAL_AYR2011');
define ('DB_SID', 'NIFE');
define ('DB_SERVER','beora01-scan.uniandes.edu.co');
define ('DB_PORT', '1521');

/**
 * These constants are used in the Integracion class and describe the oci functions output
 */
define ('DATOS_ESTUDIANTE','CARNET,APELLIDOS,NOMBRES,NIVEL,CODIGO_PROGRAMA,PROGRAMA,DOBLE_PROGRAMA,OPC,OPCION,CRED_INS,PROM_ACUM,SSC,CRED_MAX');
define ('TURNO_GALPON','codEstudiante,fechaInicio,horaInicio,fechaFin,horaFin,tanda');
define ('OPCION1','CRN');
define ('OPCION21','MATERIA');
define ('OPCION22','MATERIA||CURSO');
define ('OPCION23','SECCION');
define ('OPCION31','TITULO');
define ('OPCION32','SECCION');
define ('OPCION41', 'PROFESOR_1');
define ('OPCION42', 'PROFESOR_2');
define ('OPCION43', 'PROFESOR_3');
define ('BUSQUEDAS_LIKE','MATERIA||CURSO,TITULO,PROFESOR_1,PROFESOR_2,PROFESOR_3');
define ('PAGINAS',10);
define ('PREGRADO','PR');
define ('MAESTRIA','MA');
/* End of file constants.php */
/* Location: ./application/config/constants.php */

define ('AMBIENTE_PRUEBAS','0');
//define ('CORREO_PRUEBAS','amoncada@ifactum.com');
define ('CORREO_PRUEBAS','cafanador@uniandes.edu.co');
define ('PROGRAMAS_MYSQL','1');
