<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
* Excel library for Code Igniter applications
* Author: Derek Allard, Dark Horse Consulting, www.darkhorse.to, April 2006
*/
class Excel{
     function __construct() {
        
     }
     /*
      cabeceras array - arreglo con los strings de la cabecera de cada columna
      datos array - datos de cada celda      
     */
    public function to_excel($cabeceras,$datos, $filename='exceloutput'){
         
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
                        $line .= $value;
                   }
                   $data .= trim($line)."\n";
              }              
              $data = str_replace("\r","",$data);                             
              header("Content-type: application/x-msdownload");
              header("Content-Disposition: attachment; filename=$filename.xls");
              echo "$headers\n$data";  
         }
    }    
}
?>

