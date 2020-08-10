# Sistema conflicto de horario
Aplicación de admisiones y registro para la gestión de conflicto de horario.

## Requisitos:

- PHP = 5.2.17
- oci_connect:
  *https://www.php.net/manual/es/function.oci-connect.php*

**Nota:** Código obsoleto y vulnerable, al igual que tiene archivos sin uso

## Ambiente producción:

- La rama master se encuentra desplegada en el servidor de producción con la URL:  *https://sch.uniandes.edu.co/* 

## Ambiente QA:

El ambiente de pruebas tiene desplegada la rama QA debido a las diferencias de código en cuanto:  

- A las conexiones a la base de datados tanto de MySql como de Oracle. 

  ```sh
    // ruta: aplicacion/config/database.php (MySql)
    $db['default']['hostname'] = 'altamira.uniandes.edu.co';  

    // ruta: aplicacion/config/oci_constants.php (Oracle)  
    define ('DB_USER', 'PORTAL_AYR');
    define ('DB_PWD', 'PORTAL_AYR2011'); 
  ```

- las conexiones por medio del LDAP.

  ```sh
    // ruta: aplicacion/controllers/auth_ldap.php
    $config['hosts'] = array('adua.uniandes.edu.co');      
  ```

- Él envió de correo.

  ```sh
    // ruta: aplicacion/controllers/solicitud.php (Se encuentra en diferentes líneas)
    $this->enviarCorreo('crear', $datos['sol_email'], 'Creación solicitud', $id_sol);       
  ```
