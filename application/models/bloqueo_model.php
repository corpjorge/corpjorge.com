<?php

/**
 * This is the model class for table "motivo".
 *
 * The followings are the available columns in table 'motivo':
 * @property integer $mov_id
 * @property string $mov_descripcion
 */
class Bloqueo_model extends CI_Model
{
	var $blq_id;
	var $crn;
	
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
		return 'ch_crns_bloqueados';
	}
	public function tableLlave()
	{
		return 'blq_id';
	}
	
	public function insert($data){
			$periodo		= 	$data['periodo'];
            $crn			=  $this->get_item($data['crn'],'crn');
			$periodo_crn	=	$crn[0]['periodo'];
			$registrado =	0;
		if (count($crn)>=0){
			foreach($crn as $datoscrn){
				if( $datoscrn['periodo'] == $periodo){
					$registrado =	1;  
				}
				
			}
		}
		if($registrado == 0){
			return $this->db->insert($this->tableName(), $data);
		}else { 
			 return ", CRN repetido para el período seleccionado";
		 }
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
}