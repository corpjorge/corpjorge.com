<?php

/**
 * This is the model class for table "departamento".
 *
 * The followings are the available columns in table 'departamento':
 * @property integer $dep_id
 * @property string $dep_nombre
 * @property integer $lim_id
 * @property string $dep_externo
 */
class Departamento_model extends CI_Model 
{
	var $dep_id;
	var $dep_nombre;
	var $lim_id;
	var $dep_externo;
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
		return 'ch_departamento';
	}
	public function tableLlave()
	{
		return 'dep_id';
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
	
	public function get_limits(){
		$query = $this->db->query("SELECT dep_id, sol_creacion FROM ch_limite");
		return $query->result_array();
	}
	public function actSol($d){
		$this->db->query("UPDATE ch_limite SET sol_creacion='1' WHERE dep_id IN ($d)");
	}
	public function desSol($d){
		$this->db->query("UPDATE ch_limite SET sol_creacion='0' WHERE dep_id IN ($d)");
	}
	
	public function get_all($page='',$total='',$order='',$campo_order='',$qtype='',$qcampo=''){
		if(!empty($page)&&!empty($total)&&!empty($order)&&!empty($campo_order)){
		  //$this->db->order_by($this->tableLlave(), 'ASC');
		  //busca		  
		  if(!empty($qtype)&&!empty($qcampo)){
			$this->db->like($qtype,$qcampo);
			//var_dump($this->db);
		  }
		  $this->db->order_by($campo_order, $order);
		  $query = $this->db->get($this->tableName(),$total,$page);
		  //var_dump($this->db);
		}
		else
		  $query = $this->db->get($this->tableName());
		//var_dump($this->db);	
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
	public function get_dropdown(){		
		$lista = $this->get_all();
		$options = array('' => 'Seleccione');
		foreach($lista as $key=>$value){
			$options[$value[$this->tableLlave()]] = utf8_decode($value['dep_nombre']);
		}
		return $options;	
	} 
	
	public function programasActivos(){
		//programas en los coordinadores que no estan en la tabla ch_programas_act
		/*$coos = array('DERE', 'DERE', 'DCOM', 'DENI', 'DUPS', 'DEIN', 'DEPR', 'DPUB', 'DERE', 'ECON', 'IMEC', 'PSCL', 'PSIC', 'IIND', 'EGOB', 'GPOL', 'SPUB', 'CPOL', 'ICYA', 'IQUI', 'FILO', 'DEPR', 'CBIO', 'ARQU', 'EDUC', 'ADMI', 'MBAE', 'MADM', '', 'DADM', 'GEOC', 'PERI', 'ANTR', 'MUSI', 'MEDI', 'BIOL', 'FISI', 'HIST', 'MGEO', 'ISIS', 'ARTE', 'HART', 'FINA', 'MFIN', 'MMER', 'IDOC', 'MATE', 'MBAE', 'MECU', 'PLEN', 'HIST', 'PSIC', 'DISE', 'QUIM', 'LITE', 'MBIO', 'IELE', 'DPUB', 'MGAP', 'IBIO', 'FISI', 'GEOC', 'ADMI', 'LENG', 'CBIO', 'BIOL', 'MBIO');
		foreach($coos as $coo){
			$queryco = "SELECT COUNT(swtprnl_program_desc) AS CONTEO FROM ch_programas_act WHERE swtprnl_program = upper('".$coo."')";
			//echo $query;
			$resco = $this->db->query($queryco);
			$retornoco = $resco->result_array();			
			echo "$coo - ".$retornoco[0]['CONTEO']."<br>";
		}*/
		
		$query = "SELECT DISTINCT swtprnl_program, swtprnl_program_desc FROM ch_programas_act WHERE swtprnl_prog_activo_ind = 'Y' ORDER BY swtprnl_program_desc ASC";
		//echo $query;
		$res = $this->db->query($query);		
		return $res->result_array();
	}
	public function programasActivosNiveles(){
		$query = "SELECT DISTINCT swtprnl_program, swtprnl_levl_code FROM ch_programas_act WHERE swtprnl_prog_activo_ind = 'Y'";
		//echo $query;
		$res = $this->db->query($query);		
		return $res->result_array();
	}
	public function obtenerPrograma($programaId){
		$query = "SELECT swtprnl_program_desc FROM ch_programas_act WHERE swtprnl_program = upper('".$programaId."')";
		//echo $query;
		$res = $this->db->query($query);		
		$retorno = $res->result_array();
		if(@$retorno[0]['swtprnl_program_desc']!='')
			return @$retorno[0]['swtprnl_program_desc'];
		else
			return "Sin departamento";
	}
	
	function cruzarProgramas($programasBanner){
		$query = "SELECT GROUP_CONCAT(swtprnl_program SEPARATOR ',') as 'prog' FROM ch_programas_act WHERE swtprnl_prog_activo_ind = 'Y'";
		$res = $this->db->query($query);		
		$res = $res->result_array();
		$programasMySQL = explode(",",$res[0]["prog"]);
		$progbanner = array_keys($programasBanner);
		$eliminar = array_diff($programasMySQL, $progbanner);
		// echo "<pre>";
		// print_r($eliminar);
		// echo "</pre>";
		if(count($eliminar)>0){
			$eliminar = "'".implode("','", $eliminar)."'";
			$sql_Eliminar1 = "DELETE FROM ch_programas_act WHERE swtprnl_program IN ($eliminar)";
			$this->db->query($sql_Eliminar1); 
			
			$sql_Eliminar2 = "DELETE FROM ch_limite WHERE dep_id IN ($eliminar)";
			$res = $this->db->query($sql_Eliminar2);
		}

		foreach($programasBanner as $k=>$p){
			$accion = in_array($k, $programasMySQL) ? "UPDATE " : "INSERT INTO ";
			$cond = in_array($k, $programasMySQL) ? " WHERE swtprnl_program='".$k."'" : "";
			$qry =  $accion." ch_programas_act SET ";
			$qry .= "swtprnl_program='".$k."', ";
			$qry .=	"swtprnl_enfasis_desc='".mysql_escape_string($p["NOMBRE"])."', ";
			$qry .= "swtprnl_program_desc='".mysql_escape_string($p["NOMBRE"])."', ";
			$qry .= "swtprnl_levl_code='".implode("*",array_unique($p["NIVEL"]))."', ";
			$qry .= "swtprnl_prog_activo_ind='Y' ".$cond;
			// echo "<pre>";
			// print_r($qry);
			// echo "</pre>";
			$res = $this->db->query($qry);
		}
	}
}