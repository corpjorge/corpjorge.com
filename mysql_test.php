<?php
exit; 
$enlace =  mysql_connect('altamira.uniandes.edu.co', 'usdbconflicto', 'hhZmN8F1');
if (!$enlace) {
    die('No pudo conectarse: ' . mysql_error());
}
echo 'Conectado satisfactoriamente';
mysql_close($enlace);

echo "<pre>";
print_r($_SERVER);
exit;
?>
