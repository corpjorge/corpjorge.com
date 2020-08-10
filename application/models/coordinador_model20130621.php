<?php

/**
 * This is the model class for table "coordinador".
 *
 * The followings are the available columns in table 'coordinador':
 * @property integer $coo_id
 */
class Coordinador_model extends CI_Model
{
	var $coo_id;
	var $coo_email;
	var $coo_asistente;
	var $coo_activo;
	var $coo_nombre;
	var $coo_login;
	var $niv_id;
	var $dep_id;
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
		return 'ch_coordinador';
	}
	public function tableLlave()
	{
		return 'coo_id';
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
	public function get_count(){				
		return 	$this->db->count_all_results($this->tableName());
	}
	public function get_all($page='',$total='',$order='',$campo_order='',$qtype='',$qcampo=''){
		if(!empty($page)&&!empty($total)&&!empty($order)&&!empty($campo_order)){
		  //$this->db->order_by($this->tableLlave(), 'ASC');
		  //busca		  
		  
		  //$this->db->order_by($campo_order, $order);
		  //$query = $this->db->get($this->tableName(),$total,$page);		  
		}
		if(!empty($qtype)&&!empty($qcampo)){
			$this->db->like($qtype,$qcampo);
			//var_dump($this->db);
		  }
                if(!empty($order)&&!empty($campo_order)){
                  $this->db->order_by($campo_order, $order);  
                }
                $query = $this->db->get($this->tableName());
		//var_dump($this->db);	
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
			$options[$value[$this->tableLlave()]] = utf8_decode($value['coo_nombre']);
		}
		return $options;	
	}
        public function get_selMats($id){
            $query = $this->db->get_where($this->tableName(), array($this->tableLlave() => $id));
            return $query->result_array();
        }
}