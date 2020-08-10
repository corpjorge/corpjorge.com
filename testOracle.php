<?php
$user = 'horariolab';
$pass = 'law45_m8';
$htns = 'sisga.uniandes.edu.co';

define ('DB_USER', 'PORTAL_AYR');
define ('DB_PWD', 'PORTAL_AYR2011');
define ('DB_SID', 'nife');
//define ('DB_SERVER','sisga.uniandes.edu.co');
define ('DB_SERVER','(DESCRIPTION=
    (ADDRESS=
      (PROTOCOL=TCP)
      (HOST=beora01-scan.uniandes.edu.co)
      (PORT=1521)
    )
    (CONNECT_DATA=
      (SERVER=dedicated)
      (SERVICE_NAME=NIFE)
    )
  )');
define ('DB_PORT', '1521');
//$conn = oci_connect(DB_USER, DB_PWD, DB_SERVER.':'.DB_PORT.'/'.DB_SID);
$conn = oci_connect(DB_USER, DB_PWD, DB_SERVER);
echo '<pre>';
print_r(oci_error());
echo '</pre>';

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
echo '<pre>';
print_r($conn);
echo '</pre>';
exit;