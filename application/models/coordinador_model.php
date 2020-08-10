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
	
	function cColumnas(){
		$user = $this->session->userdata["login"];
		$sec = $this->input->post("seccion");
		$query = $this->db->query("SELECT columnas FROM ch_coordinador WHERE coo_login='$user' LIMIT 1");
		$items = $query->result_array();
		echo "<pre>";
		print_r($items);
		exit;
		$items = json_decode($items[0]["columnas"], TRUE);
		$items = @$items[$sec];

		@$items["orden"] = explode("=", @$items["orden"]);
		@$items["orden"] = @$items["orden"][1];
		
		@$items["ocultar"] = explode("=", @$items["ocultar"]);
		@$items["ocultar"] = @$items["ocultar"][1];
		return json_encode($items);
	}
	
	public function updOrderColumn(){
		$user = $this->session->userdata["login"];
		$_d = $this->db->query("SELECT columnas FROM ch_coordinador WHERE coo_login='".$user."'");
		$_d = $_d->result();
		$_d = json_decode($_d[0]->columnas, true);
		$datos = $this->input->post();
		$_d[$datos["seccion"]]["orden"] = $datos["orden"];
		$_d[$datos["seccion"]]["ocultar"] = $datos["ocultar"];
		$_d = json_encode($_d);
		$this->db->query("UPDATE ch_coordinador SET columnas='".$_d."' WHERE coo_login='".$user."'");
		echo $this->db->affected_rows();
	}

	public function updFiltros()
	{
		$user = $this->session->userdata["login"];
		$_d = $this->db->query("SELECT columnas FROM ch_coordinador WHERE coo_login='".$user."'");
		$_d = $_d->result();
		$dtemp['count'] = count(json_decode($_d[0]->columnas,true));
		$dtemp['json_decode'] = json_decode($_d[0]->columnas,true);
		$dtemp['json'] = $_d[0]->columnas;
		$_d = json_decode($_d[0]->columnas, true);
		$datos = $this->input->post();
		$_d['solicitud']["filtros"] = json_decode($this->session->userdata["query"], true);;
		$_d = json_encode($_d);
		$this->db->query("UPDATE ch_coordinador SET columnas='".$_d."' WHERE coo_login='".$user."'");
		return $dtemp;
	}
	public function ClearFiltros($user='', $columna='')
	{
		$user = $this->session->userdata["login"];
		$_d = $this->db->query("SELECT columnas FROM ch_coordinador WHERE coo_login='".$user."'");
		$_d = $_d->result();
		$dtemp['count'] = count(json_decode($_d[0]->columnas,true));
		$dtemp['json_decode'] = json_decode($_d[0]->columnas,true);
		$dtemp['json'] = $_d[0]->columnas;
		$_d = json_decode($_d[0]->columnas, true);
		$datos = $this->input->post();
		$_d['solicitud']["filtros"] = array();
	
		$_d = json_encode($_d);
		$this->db->query("UPDATE ch_coordinador SET columnas='".$_d."' WHERE coo_login='".$user."'");
		return $dtemp;
	}

	public function BDFiltros()
	{
		$user = $this->session->userdata["login"];
		$_d = $this->db->query("SELECT columnas FROM ch_coordinador WHERE coo_login='".$user."'");
		$_d = $_d->result();
		$_d = json_decode($_d[0]->columnas, true);
		if ( count($_d['solicitud']["filtros"])==0 )
		{
			return "";
		}
		else
		{
			return json_encode($_d['solicitud']["filtros"]);
		}
	}

	public function cargarPermisos(){
		$_d = $this->db->query("SELECT materia_id2, dep_id2 FROM ch_coordinador WHERE coo_login='".$this->input->post("login")."' LIMIT 1");
		$_d = $_d->result(); $_d = $_d[0];
		$_d->materia_id2 = explode("*", $_d->materia_id2);
		$_d->dep_id2 = explode("*", $_d->dep_id2);
		return json_encode($_d);
	}
	
	public function actualizarPermisos($cood_id, $dep_id, $materia_id){
		$this->db->query("UPDATE ch_coordinador SET dep_id='".$dep_id."', materia_id='".$materia_id."' WHERE coo_id='".$cood_id."'");
		$this->db->affected_rows();
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
			$options[$value[$this->tableLlave()]] = utf8_decode($value['coo_nombre']);
		}
		return $options;	
	}
        public function get_selMats($id){
            $query = $this->db->get_where($this->tableName(), array($this->tableLlave() => $id));
            return $query->result_array();
        }
		
		public function getColumns(){
			$query = $this->db->get_where("ch_orderColumns", array("rol" => 1, "login" => "mgonzal"));
             return $query->result_array();
		}

	public function updateCustomData($column,$currentUser)
	{
		$data = array(
               'columnas' => $column,
            );

		$this->db->where('coo_login',$currentUser);
		$this->db->update('ch_coordinador',$data);

	}
}