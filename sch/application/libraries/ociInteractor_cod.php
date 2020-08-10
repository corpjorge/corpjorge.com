<?php
/**
 * Clase encargada de la interacción con bases de datos oracle, definida por defecto con la inclusión la ejecución de procedimientos almacenados
 * 
 * La clase se construye a partir de unas constantes predefinidas (K de conexión), y apartir de allì se crean las funciones denámicas para 
 * interacción con base de datos
 *
 * @author John Jimenez
 */

class ociInteractor {
        protected $server;
	protected $port;
	protected $schema;
	protected $login;
	protected $password;
	protected $db_conn;
	public $error_transaccion = false;
	public $error_sentencia_sql = false;
	public $ultimo_error;
	public $esta_conectado;
	function __construct(){	            
		$this->server = DB_SERVER;
		$this->login = DB_USER;
		$this->password =DB_PWD;
		$this->database =DB_SID;
		$this->port =DB_PORT;
                //establece la conección con base de datos
                //$this->db_conn = oci_connect($this->login, $this->password, $this->server);
                $this->db_conn = ocilogon ($this->login, $this->password, '//'.$this->server.':'.$this->port.'/'.$this->database) or die( "Could not connect to Oracle database!");
                //$this->db_conn = oci_connect($this->login, $this->password);
		if (!$this->db_conn) {
			$error = oci_error();
			$this->ultimo_error = $error;		    
			$this->esta_conectado = false;
		} else {
			$this->esta_conectado = true;
		}
	}
        /**
         * Funcion para hacer el llamado de un procedimiento almacenado de Oracle
         * @global type $variable_salida variable variable para generar las salidas
         * @param type $query_procedure nombre del proceimiento almacenado a ejecutar
         * @param type $vector_variables_entrada array asociativo cuyas llaves son las variables de entrada y el contenido es el valor 
         * @param type $vector_variables_salida array simple con los campos de salida del procedimiento
         * @return type 
         */
        public function ejecutar_procedure($query_procedure,$vector_variables_entrada,$vector_variables_salida){
		if ($this->esta_conectado){
			//error_reporting(63);
			//ini_set("display_errors",1);
			// Prepara la sentencia SQL
                        $declaracionRetornos="";
                        foreach ($vector_variables_salida as $valor) {
                            $declaracionRetornos .= ":".$valor." ";
                        }
                        $declaracionEntradas="(";
                        $separator="";
                        foreach ($vector_variables_entrada as $variable => $entrada) {
                            $declaracionEntradas .= ":".$variable.$separator;
                        }
                        $declaracionEntradas.=")";
			$sentencia_sql = "BEGIN ". $declaracionRetornos .":= ". $query_procedure . $declaracionEntradas . "; END;";
			$sentencia = oci_parse($this->db_conn,$sentencia_sql);
			// Asocia las variables de entrada
			foreach ($vector_variables_entrada as $variable => $valor) {
				global $$variable;
				//echo "<br>";
				$$variable = $valor;
                                //echo $variable . " = " . $$variable;                                
				$r=oci_bind_by_name($sentencia,':'.$variable,$$variable,strlen($$variable));
                                if($r===FALSE){
                                    echo "No realizo el bind de la variable : ".$variable;
                                } 
			}

			// Asocia las variables de salida
			foreach ($vector_variables_salida as $variable_salida) {
				global $$variable_salida;
				oci_bind_by_name($sentencia,":" . $variable_salida,$$variable_salida,255);
				//echo "<br>";
                                
			}
			//echo "<li>".$sentencia_sql;
			// Ejecuta
			@oci_execute($sentencia);
			foreach ($vector_variables_salida as $variable_salida) {
                                $$variable_salida = ($$variable_salida==null)?false:$$variable_salida;
				$variablesSalida [$variable_salida] = $$variable_salida;
			}
                        
                        //print_r($error = oci_error($sentencia));
                        return $variablesSalida;
                 }
	}
        public function ejecutar_consulta($query,$inicial=0,$registros=-1){
		if ($this->esta_conectado){
			$resultado = oci_parse($this->db_conn, $query);
			if ($resultado){
				$respuesta = oci_execute($resultado);
				if ($respuesta)
				{
					$cantidad_registros = oci_fetch_all($resultado, $matriz_resultados,$inicial,$registros,OCI_FETCHSTATEMENT_BY_ROW);
					
					$retorno=array();
					if ($cantidad_registros > 0) {                                            
                                            foreach ($matriz_resultados as $row => $data) {                                                
                                                $sretorno=array();
                                                foreach ($data as $campo => $valor) {
                                                    $sretorno[$campo]=utf8_encode($valor);
                                                    $sretorno[]=utf8_encode($valor);
                                                }
                                                $retorno[]=$sretorno;
                                            }
						return $retorno;
					} else {
					   	return "";
					}
					oci_free_statement($resultado);
					return true;
				} else {
                                    $error = oci_error($resultado);
                                    $this->ultimo_error = $error;				    
                                    $this->error_sentencia_sql = true;
                                    return false;
				}
			}else{
                            $error = oci_error($resultado);
                            $this->ultimo_error = $error;			    
			    $this->error_sentencia_sql = true;
                            return false;
			}
		}
	}
        function commit(){
		oci_commit($this->db_conn);
	}
	function rollback(){
		$this->error_transaccion = true;
		oci_rollback($this->db_conn);
	}

	function __destruct(){
		if ($this->error_transaccion){
			oci_rollback($this->db_conn);
		} else {
			oci_commit($this->db_conn);
		}

		if (is_object($this->db_conn)){
			oci_close($this->db_conn);
		}
	}
}

?>
