<?php

/**
 * This is the model class for table "comentario".
 *
 * The followings are the available columns in table 'comentario':
 * @property integer $com_id
 */
class Mensaje_model extends CI_Model
{
	var $com_id;
	var $com_login;
	var $com_nombre;
	var $com_texto;
	var $com_fecha;	
	var $sol_id;
	var $rol_id;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Departamento the static model class
	 */
	function __construct(){
		parent::__construct();
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ch_mensajes';
	}
	public function tableLlave()
	{
		return 'com_id';
	}
	
	public function insert($data){				
		return $this->db->insert($this->tableName(), $data); 
	}
	/*input: id - id de la fila a actualizar
	  input: $data - array info de los campos
	  input: $campo - campo de la tabla con el que se
			  hace la comparacion.
	*/
	public function update($id,$data,$campo=''){
		if(empty($campo)){
			$campo = $this->tableLlave();	
		}
		$this->db->where($campo,$id);
		return $this->db->update($this->tableName(),$data);		
	}
	public function delete($id,$campo=''){
		if(empty($campo)){
			$campo = $this->tableLlave();
		}
		$this->db->where($campo,$id);
		return $this->db->delete($this->tableName());		
	}
	public function get_count($id='',$campo=''){
		if(!empty($campo)&& !empty($id)){
			$this->db->where($campo,$id);
		}
		$query = $this->db->query('SELECT COUNT('.$this->tableLlave().') FROM '.$this->tableName());
		return $this->db->count_all_results();		
	}
	public function get_all(){		
		$query = $this->db->get($this->tableName());		
		return $query->result_array();
	}	
	public function get_item($id,$campo=''){
		if(empty($campo)){
			$campo = $this->tableLlave();
		}
		//$this->db->where($campo,$id);		
		//$query = $this->db->query('SELECT * FROM '.$this->tableName());
		$this->db->order_by("com_id", "asc");
		$query = $this->db->get_where($this->tableName(), array($campo => $id));		
		return $query->result_array();
	}
	public function get_dropdown(){		
		$lista = $this->get_all();
		$options = array('' => 'Seleccione');
		foreach($lista as $key=>$value){
			$options[$value[$this->tableLlave()]] = utf8_decode($value['com_login']);
		}
		return $options;	
	}
	public function get_last($id='',$campo=''){
		$this->db->select_max($this->tableLlave(), 'maximo');
		
		if(!empty($campo)&& !empty($id)){
			$this->db->where($campo,$id);
		}		
		$query = $this->db->get($this->tableName());		
		$res =  $query->result_array();
		return $res[0]['maximo'];
	}
	public function menPersonales($login)
	{
		$query = $this->db->query("SELECT * FROM ch_mensajes WHERE login='$login'");
		$login = $query->result();
		return $login;
	}


	public function insert_id(){				
		return $this->db->insert_id(); 
	}


	function agregarMensaje ($idmensaje,$crns,$mensaje,$login)
	{
		$login            = mysql_real_escape_string($login);
		$crns 			  = mysql_real_escape_string($crns);
		$mensaje 		  = mysql_real_escape_string($mensaje);
		//$idmensaje 		  = mysql_real_escape_string($idmensaje);
		//$idsValidosUser   = $this->listadoIDSComentarios($login);
		//echo $idmensaje;
		//exit;
		if (!empty($idmensaje)) //Si viene un ID se actualiza el comentario
		{

			$query = "UPDATE ch_mensajes SET login='".$login."', crn='".$crns."' , message='".$mensaje."' WHERE id = ".$idmensaje;

		}
		else
		{
			$query = "INSERT INTO ch_mensajes(login,crn,message) VALUES ('$login','$crns','$mensaje')";

		}

		$this->db->query($query);
		$id_ch_comenpersonales = $this->db->insert_id();
		return $id_ch_comenpersonales;
	}

	function borrarMensaje ($idmensaje)
	{
		$idmensaje = (int) mysql_real_escape_string($idmensaje);
		$query           = "DELETE FROM ch_mensajes WHERE id = $idmensaje";
		$this->db->query($query);
		return 1;
	}


	function consultarMaterias($crns)
	{
		$this->load->library('integracion');
		$materia = $this->integracion->consultarMateriasCrns($crns);
		return $materia;
	}




}