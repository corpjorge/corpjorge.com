<?php

/**
 * This is the model class for table "estado".
 *
 * The followings are the available columns in table 'estado':
 * @property integer $est_id
 * @property string $est_descripcion
 */
class Estado_model extends CI_Model
{
	var $est_id;
	var $est_descripcion;
	
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
		return 'ch_estado';
	}
	public function tableLlave()
	{
		return 'est_id';
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
	public function get_all_peridos(){		
		$query = $this->db->query("SELECT s.sol_periodo AS period,CONVERT(s.sol_periodo,CHAR(50)) AS strperiod
								   FROM ch_solicitud AS s
								   WHERE s.sol_periodo IS NOT null
								   GROUP BY s.sol_periodo");
		return $query->result_array();
	}		
	public function get_item($id,$campo=''){
		if(empty($campo)){
			$campo = $this->tableLlave();
		}
		$query = $this->db->query("SELECT * FROM ".$this->tableName()." WHERE ".$campo."='".$id."' LIMIT 1");
		// $query = $this->db->get_where($this->tableName(), array($campo => $id));
		return $query->result_array();
	}	
	public function get_dropdown($cancelar=FALSE){		
		$lista = $this->get_tree(0);
		
		//$lista = $this->get_all();                
		$options = array('' => '- -Seleccione- -');
		foreach($lista as $key=>$value){
			$rol = $this->session->userdata('rol');

			if(($rol == 2) && ($value['est_id'] == 23) ){
				continue;
			}
			if($cancelar)
			 //if(($value['est_descripcion']=='Cancelado')|($value['est_descripcion']=='- Cancelado'))
			  //continue;
			if(!isset($value['est_descripcion'])){
                            $suboptions=array();
                            foreach ($value as $subkey => $subvalue) {
                                $suboptions[$subvalue[$this->tableLlave()]]=$subvalue['est_descripcion'];
                            }
                            $options[$key]=$suboptions;
                        }
                        else                            
                            $options[$value[$this->tableLlave()]] = $value['est_descripcion'];
		}                
		return $options;	
	}
	public function get_dropdown_peridos($cancelar=FALSE){		
		$lista = $this->get_all_peridos(0);
		$options = array('' => '- -Seleccione- -');
		foreach($lista as $key=>$value){
			$options[$value['period']] = $value['strperiod'];
		}                
		return $options;	
	}
        
        private function get_tree($level=0){
            if($level>0)$query = $this->db->query('SELECT est_id,est_descripcion as est_descripcion, est_padre FROM '.$this->tableName()." WHERE est_padre =".$level." AND est_est = 1");
            else$query = $this->db->get_where($this->tableName(), array('est_padre' => $level,'est_est'=>1));
            $rango= $query->result_array();            
            $resultado=array();
            $subResultado=array();
            foreach ($rango as $valor) {
                
                
                $subResultado=  $this->get_tree($valor['est_id']);
                if(count($subResultado)>0)$resultado[$valor['est_descripcion']]=$subResultado;
                else {
                    $resultado[$valor['est_descripcion']]=$valor;    
                }
                //$resultado=array_merge($resultado,$subResultado);
            }
            return $resultado;
        }
}