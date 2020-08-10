<?php

/**
 * This is the model class for table "limite".
 *
 * The followings are the available columns in table 'limite':
 * @property integer $lim_id
 */
class Limite_model extends CI_Model
{
	var $lim_id;
	var $lim_fec_a_sol;
	var $lim_fec_c_sol;
	var $lim_fec_a_ges;
	var $lim_fec_c_ges;
	
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
		return 'ch_limite';
	}
	public function tableLlave()
	{
		return 'lim_id';
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
		if(!empty($campo)&& !empty($campo)){
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
		$query = $this->db->get_where($this->tableName(), array($campo => $id));		
		return $query->result_array();
	}
	public function get_dropdown(){		
		$lista = $this->get_all();
		$options = array('' => 'Seleccione');
		foreach($lista as $key=>$value){
			$options[$value[$this->tableLlave()]] = utf8_decode($value['lim_fec_a_sol']);
		}
		return $options;	
	}
	
	public function validar_rango_fechas($inicio,$fin,$validar){
		$v_inicio = explode(' ',$inicio);
		$v_fecha_inicio = explode('-',$v_inicio[0]);
		$v_tiempo_inicio = explode(':',$v_inicio[1]);
		
		$v_fin = explode(' ',$fin);
		$v_fecha_fin = explode('-',$v_fin[0]);
		$v_tiempo_fin = explode(':',$v_fin[1]);
		
		$v_validar = explode(' ',$validar);
		$v_fecha_validar = explode('-',$v_validar[0]);
		$v_tiempo_validar = explode(':',$v_validar[1]);
		
		$c_inicio = mktime((int)$v_tiempo_inicio[0],(int)$v_tiempo_inicio[1],(int)$v_tiempo_inicio[2],(int)$v_fecha_inicio[1],(int)$v_fecha_inicio[2],(int)$v_fecha_inicio[0]);
		$c_fin = mktime((int)$v_tiempo_fin[0],(int)$v_tiempo_fin[1],(int)$v_tiempo_fin[2],(int)$v_fecha_fin[1],(int)$v_fecha_fin[2],(int)$v_fecha_fin[0]);
		$c_validar = mktime((int)$v_tiempo_validar[0],(int)$v_tiempo_validar[1],(int)$v_tiempo_validar[2],(int)$v_fecha_validar[1],(int)$v_fecha_validar[2],(int)$v_fecha_validar[0]);
		
		//var_dump($c_inicio);
		//var_dump($c_fin);
		//var_dump($c_validar);
		
		if($c_validar>=$c_inicio && $c_validar<=$c_fin)
			return TRUE;
		else
			return FALSE;
		
		
	}
}