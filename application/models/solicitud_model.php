<?php
/**
 * This is the model class for table "Solicitud".
 *
 * The followings are the available columns in table 'Solicitud':
 * @property integer $dep_id
 * @property string $dep_nombre
 * @property integer $lim_id
 * @property string $dep_externo
 */
class Solicitud_model extends CI_Model 
{
	var $sol_id; 	
	var $dep_id;//se obtiene del estudiante que crea la solicitud
	var $sol_ticket;
	var $sol_descripcion;
	var $sol_mag_crn_ins;//magistral a inscribir
	var $sol_mag_crn_ret;//magistral a retirar
	var $sol_com_crn_ins;//complementaria que se arrastra para inscribir
	var $sol_com_crn_ret;//complementaria que se arrastra al retirar
	var $sol_login;
	var $sol_email;
	var $sol_ip;
	var $sol_fec_creacion;
	var $sol_fec_actualizacion;
	var $tip_id;
	var $mov_id;
	var $est_id;
	
	var $sol_ins_seccion;
	var $sol_ins_instructor;
	var $sol_ins_tipo;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Solicitud the static model class
	 */
	function __construct(){
		parent::__construct();
		$this->load->library('integracion');
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ch_solicitud';
	}
	public function tableLlave()
	{
		return 'sol_id';
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
			  public function get_count($qtype='',$qcampo='',$where='',$campo_where='',$qtype2='',$qcampo2='', $qcampo3='', $fecha_inicial_listado=''){
			  	$this->db->join('ch_estado E_', 'E_.est_id = ch_solicitud.est_id',/*'inner'*/'left');
			  	$this->db->join('ch_tipo T_', 'T_.tip_id = ch_solicitud.tip_id',/*'inner'*/'left');
			  	$this->db->join('ch_motivo M_', 'M_.mov_id = ch_solicitud.mov_id',/*'inner'*/'left');

			  	$rr = @json_decode($this->input->post("query") ? $this->input->post("query") : $qcampo);
			  	if(isset($rr->solicitud)){
			  		$operadores[0] = "{cmp} = '{vr1}'";
			  		$operadores[1] = "{cmp} > '{vr1}'";
			  		$operadores[2] = "{cmp} < '{vr1}'";
			  		$operadores[3] = "{cmp} LIKE '%{vr1}%'";
			  		$operadores[4] = "{cmp} LIKE '{vr1}%'";
			  		$operadores[5] = "{cmp} LIKE '%{vr1}'";
			  		$operadores[6] = "{cmp} BETWEEN '{vr1}' AND '{vr2}'";
			  		$_where = " (";
			  		$qrys = $rr->solicitud;
			  		$_nn = count( (array) $qrys)-1;

			  		foreach($rr->solicitud as $k=>$s){
			  			@$valor = explode(":=:", @$s->valor);
			  			$_where .= ( @$s->operador==6 ? str_replace(array("{cmp}", "{vr1}", "{vr2}"), array($s->qtype, @$valor[0], @$valor[1]),$operadores[@$s->operador]) : str_replace(array("{cmp}", "{vr1}"), array($s->qtype, @$valor[0]),$operadores[@$s->operador]));
			  			if($k<$_nn){
			  				$_where .= @$s->operador2=="1" ? ") AND (" : " OR ";
			  			}else if($k==$_nn){
			  				$_where .= ") ";
			  			}

			  		}
			  		if($_where!=" ("){
			  			$this->db->where($_where, NULL, FALSE);
			  		}
			  	}else{
			  		if(!empty($qtype)&&!empty($qcampo)){
			  			if($qtype=="sol_creditos")
			  				$this->db->where($qtype." >=",$qcampo);
			  			else 
			  				$this->db->like($qtype,$qcampo);
			  		}
			  		if(!empty($qtype2)&&!empty($qcampo2)){
			  			if($qtype2=="sol_creditos")
			  				$this->db->where($qtype2." >=",$qcampo2);
			  			else 
			  				$this->db->like($qtype2,$qcampo2);
			  		}
			  		if(!empty($where)&&!empty($campo_where)){
			  			$this->db->where($campo_where,$where);
			  		}
			  	}
			  	if($qcampo3 && $qcampo3 != 'null' && $qcampo3 != null){	
			  		$noMostrar = explode(",",$qcampo3);
			  		if(count($noMostrar)){
			  			foreach($noMostrar as $no){
			  				if($no){
			  					$this->db->where("(ch_solicitud.est_id <> '$no' AND E_.est_padre <> '$no')");	
			  				}
			  			}
			  		}				
			  	}
			  	if($fecha_inicial_listado!=''){	
			  		$fecha_inicial_where = "(`sol_fec_creacion` >= '".$fecha_inicial_listado."' OR `sol_fec_actualizacion` >= '".$fecha_inicial_listado."')";  
			  		$this->db->where($fecha_inicial_where);
			  	}

			  	return $this->db->count_all_results($this->tableName());
		//si tiene filtro adiciona BINARY para b?squedas con tildes
		//if(!empty($qtype)&&!empty($qcampo)&&!empty($qtype2)&&!empty($qcampo2)){
          //  $query = $this->db->get($this->tableName());
           // $query = $this->db->last_query();
            //echo $query;
            //$query = str_replace(array ("�","�","�","�","�","�","�","�","�","�"), array ("a","e","i","o","u","A","E","I","O","U"), $query);
            /*$query = str_replace("LIKE '%", "LIKE BINARY UCASE('%", $query);
            $query = str_replace($qcampo."%'", $qcampo."%')", $query);
            $query = str_replace($qcampo2."%'", $qcampo2."%')", $query);*/
            //$query = str_replace("`$qtype`", "UCASE($qtype)", $query);
            //$query = str_replace("`$qtype2`", "UCASE($qtype2)", $query);
            //$query = str_replace("SELECT *", "SELECT COUNT(*) AS CONTEO", $query);
            //$res = $this->db->query($query);
            //$conteo = $res->result_array();
          //  return $conteo[0]['CONTEO'];
        //}else
			//return $this->db->count_all_results($this->tableName());	
        }
        public function get_count_coordinador($qtype='',$qcampo='',$where=array(),$campo_where='',$arr_prog,$arr_nivel,$qtype2='',$qcampo2='', $qcampo3='',$fecha_inicial_listado='', $materias){
		/*if(!empty($qtype)&&!empty($qcampo)){
			$this->db->like($qtype,$qcampo);
			//var_dump($this->db);
		  }
		  $count = 0;		  		  
		  foreach($where as $item){
			
			if($count==0)
				$this->db->where($campo_where,$item);
			else
				$this->db->or_where($campo_where,$item);
			//var_dump($this->db);
			$count++;
		  }	
		  return $this->db->count_all_results($this->tableName());*/		
		// echo $qcampo2;exit;
		// echo "<pre>";print_r($this->get_all_coordinador('','','','',$qtype,$qcampo,$where,$campo_where='',$arr_prog,$arr_nivel, $qtype2, $qcampo2, $fecha_inicial_listado));exit;
		  return count($this->get_all_coordinador('','','','',$qtype,$qcampo,$where,$campo_where='',$arr_prog,$arr_nivel, $qtype2, $qcampo2,$qcampo3, $fecha_inicial_listado, $materias));
		}
		public function get_all($page='',$total='',$order='',$campo_order='',$qtype='',$qcampo='',$where='',$campo_where='',$qtype2='',$qcampo2='',$qcampo3='', $imprimir=false, $fecha_inicial_listado='',$sol_id=""){		
		//if($imprimir)echo "<br>page $page, total $total, order $order, campo_order $campo_order, qtype $qtype, qcampo $qcampo, where $where, campo_where $campo_where, qtype2 $qtype2, qcampo2 $qcampo2";
		//echo "<li>".$where;
		//echo "<li>".$campo_where;

			
			if($page>=0&&$total>=0 /*!empty($total)*/&&!empty($order)&&!empty($campo_order)){
		  //$this->db->order_by($this->tableLlave(), 'ASC');
		  //busca	
				$this->db->join('ch_estado E_', 'E_.est_id = ch_solicitud.est_id',/*'inner'*/'left');
				$this->db->join('ch_tipo T_', 'T_.tip_id = ch_solicitud.tip_id',/*'inner'*/'left');
				$this->db->join('ch_motivo M_', 'M_.mov_id = ch_solicitud.mov_id',/*'inner'*/'left');
				$campo_order = $campo_order!='' ? 'ch_solicitud.'.$campo_order : $campo_order;	  
				$rr = @json_decode($this->input->post("query") ? $this->input->post("query") : $qcampo);
			// echo "<pre>";
			// print_r($rr->solicitud);
			// echo "</pre>";
				if(isset($rr->solicitud)){
					$operadores[0] = "{cmp} = '{vr1}'";
					$operadores[1] = "{cmp} > '{vr1}'";
					$operadores[2] = "{cmp} < '{vr1}'";
					$operadores[3] = "{cmp} LIKE '%{vr1}%'";
					$operadores[4] = "{cmp} LIKE '{vr1}%'";
					$operadores[5] = "{cmp} LIKE '%{vr1}'";
					$operadores[6] = "{cmp} BETWEEN '{vr1}' AND '{vr2}'";
					$_where = " (";
					$qrys = $rr->solicitud;
					$_nn = count( (array) $qrys)-1;
						
					foreach($rr->solicitud as $k=>$s){
						@$valor = explode(":=:", @$s->valor);
						$_where .= ( @$s->operador==6 ? str_replace(array("{cmp}", "{vr1}", "{vr2}"), array($s->qtype, @$valor[0], @$valor[1]),$operadores[@$s->operador]) : str_replace(array("{cmp}", "{vr1}"), array($s->qtype, @$valor[0]),$operadores[@$s->operador]));
						if($k<$_nn){
							$_where .= @$s->operador2=="1" ? ") AND (" : " OR ";
						}else if($k==$_nn){
							$_where .= ") ";
						}
					}
					// echo "<pre>";
					// print_r($_where);
					// exit;
					if($_where!=" ("){
						$this->db->where($_where, NULL, FALSE);
					}
				}else{
					if(!empty($qtype)&&!empty($qcampo)){
						if($qtype=="sol_creditos")
							$this->db->where($qtype." >=",$qcampo);
						else 
							$this->db->like($qtype,$qcampo);
					}
					if(!empty($qtype2)&&!empty($qcampo2)){
						if($qtype2=="sol_creditos")
							$this->db->where($qtype2." >=",$qcampo2);
						else 
							$this->db->like($qtype2,$qcampo2);
					}
					if(!empty($where)&&!empty($campo_where)){
						$this->db->where($campo_where,$where);
					}

				}
				if($qcampo3 && $qcampo3 != 'null' && $qcampo3 != null){	
					$noMostrar = explode(",",$qcampo3);
					if(count($noMostrar)){
						foreach($noMostrar as $no){
							if($no){
								$this->db->where("(ch_solicitud.est_id <> '$no' AND E_.est_padre <> '$no')");	
							}
						}
					}				
				}
				if($fecha_inicial_listado!=''){	
					$fecha_inicial_where = "(`sol_fec_creacion` >= '".$fecha_inicial_listado."' OR `sol_fec_actualizacion` >= '".$fecha_inicial_listado."')";  
					$this->db->where($fecha_inicial_where);
				}
		/*switch ($campo_order) {
			case 'est_id':
				$prefijo_campo_order = '';
				break;
			case 'tip_id':
				$prefijo_campo_order = '';
				break;
			case 'mov_id':
				$prefijo_campo_order = '';
				break;
			default:
			   $prefijo_campo_order = '';
		}
		$campo_order = $prefijo_campo_order.$campo_order*/
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";
		if($sol_id){
			// if( strtolower($order)=="asc"){
				// $order = "desc";
			// }else{
				// $order = "asc";
			// }
			$sol_id = str_replace("-","",$sol_id);
			// $this->db->limit(2);
		}else{
			$this->db->select("*, (SELECT COUNT(com_id) FROM ch_comentario WHERE estado='1' AND sol_id=ch_solicitud.sol_id) as cta");
			$sortnames = $this->session->userdata("sortnames");
			if (count($sortnames) < 1) {
				
				$this->db->order_by('sol_id','desc');

			}else{
				
				foreach ($sortnames as $sortname) {
                    $order = $sortname[0];
                    if($sortname[0] == "mov_id"){
                        $order = "ch_solicitud." . $sortname[0];
                    }
				if (strlen($sortname[0]) >= 3)
					$this->db->order_by($order,$sortname[1]);
				}
			}
			//$this->db->order_by($campo_order, $order);
		}
		
		// exit;
		if($total==0)
			$query = $this->db->get($this->tableName());
		else
			$query = $this->db->get($this->tableName(),$total,$page);

	}else{
		$query = $this->db->get($this->tableName());
	}

	if($sol_id){
		$query = str_replace("*", " ch1.sol_id ", $this->db->last_query());
		$query = str_replace("(`ch_solicitud`)", "ch_solicitud ch1", $query);
		$query = str_replace("`","", $query);
		$query = str_replace("ch_solicitud.", "ch1.", $query);
		$_order = $order;

		$pos = strpos("LIMIT 20", $query);
		$query = substr($query,$pos,strlen($query));
		$query = str_replace("LIMIT 20", " ", $query);

		$_query = $query;
		$_query .= "\nORDER BY ".(str_replace("ch_solicitud.","ch1.",($campo_order ? $campo_order : "sol_id")))." ".$order;
		$query = $_query;
		$query = $this->db->query($query);
			// echo "<pre>";
			// print_r($this->db->last_query());
			// echo "</pre>";
			// exit;
	}
		// echo "<pre>";
		// print_r($this->db->last_query());
		// echo "</pre>";
		//si tiene filtro adiciona BINARY para b?squedas con tildes
	if(!empty($qtype)&&!empty($qcampo)&&!empty($qtype2)&&!empty($qcampo2)){
		$query = $this->db->last_query();
			//$query = str_replace("LIKE '%", "LIKE BINARY UCASE('%", $query);
            //$query = str_replace(array ("�","�","�","�","�","�","�","�","�","�"), array ("a","e","i","o","u","A","E","I","O","U"), $query);
			//$query = str_replace($qcampo, $qcampo."%')", $query);
            //$query = str_replace($qcampo2, $qcampo2."%')", $query);
			//$query = str_replace("`$qtype`", "UCASE($qtype)", $query);
            //$query = str_replace("`$qtype2`", "UCASE($qtype2)", $query);
			// echo $query;
		$res = $this->db->query($query);
//if($qcampo!='')echo $query;			
		return $res->result_array();
	}else{
//if($qcampo!='')echo $this->db->last_query();
		return $query->result_array();
	}
}
	/*Adapta la funcion get all para que traiga las solicitudes
	de todos los programas a los que pertenece el coordinador*/
	public function get_all_coordinador($page='',$total='',$order='',$campo_order='',$qtype='',$qcampo='',$where=array(),$campo_where='',$arr_prog,$arr_nivel,$qtype2='',$qcampo2='',$qcampo3='', $fecha_inicial_listado='',$arr_materias=null){
		$niveles= $this->integracion->programasActivosNiveles();
		//print_r($niveles);

		$band = FALSE;
		$this->db->join('ch_estado E_', 'E_.est_id = ch_solicitud.est_id',/*'inner'*/'left');
		$this->db->join('ch_tipo T_', 'T_.tip_id = ch_solicitud.tip_id',/*'inner'*/'left');
		$this->db->join('ch_motivo M_', 'M_.mov_id = ch_solicitud.mov_id',/*'inner'*/'left');
		$campo_order = $campo_order!='' ? 'ch_solicitud.'.$campo_order : $campo_order;
		$this->db->select("*, (SELECT COUNT(com_id) FROM ch_comentario WHERE estado='1' AND sol_id=ch_solicitud.sol_id) as cta");
		if($page>=0&&$total>=0 /*!empty($total)*/&&!empty($order)&&!empty($campo_order))	{			
		  //$this->db->order_by($this->tableLlave(), 'ASC');
		  //busca		
			$rr = @json_decode($this->input->post("query") ? $this->input->post("query") : $qcampo);
			if(isset($rr->solicitud)){
				$operadores[0] = "{cmp} = '{vr1}'";
				$operadores[1] = "{cmp} > '{vr1}'";
				$operadores[2] = "{cmp} < '{vr1}'";
				$operadores[3] = "{cmp} LIKE '%{vr1}%'";
				$operadores[4] = "{cmp} LIKE '{vr1}%'";
				$operadores[5] = "{cmp} LIKE '%{vr1}'";
				$operadores[6] = "{cmp} BETWEEN '{vr1}' AND '{vr2}'";
				$_where = " (";
				$qrys = $rr->solicitud;
				$_nn = count((array)$qrys)-1;
				
				foreach($rr->solicitud as $k=>$s){
					@$valor = explode(":=:", @$s->valor);
					$_where .= ( @$s->operador==6 ? str_replace(array("{cmp}", "{vr1}", "{vr2}"), array($s->qtype, @$valor[0], @$valor[1]),$operadores[@$s->operador]) : str_replace(array("{cmp}", "{vr1}"), array($s->qtype, @$valor[0]),$operadores[@$s->operador]));
					if($k<$_nn){
						$_where .= @$s->operador2=="1" ? ") AND (" : " OR ";
					}else if($k==$_nn){
						$_where .= ") ";
					}
				}
				if($_where!=" ("){
					$this->db->where($_where, NULL, FALSE);
				}
			}else{
				if(!empty($qtype)&&!empty($qcampo)){
					if($qtype=="sol_creditos")
						$this->db->where($qtype." >= ",$qcampo);
					else 
						$this->db->like($qtype,$qcampo);          
					$band = TRUE;
				}
				if(!empty($qtype2)&&!empty($qcampo2)){
					if($qtype2=="sol_creditos")
						$this->db->where($qtype2." >= ",$qcampo2);
					else 
						// echo $qcampo2;exit;
						$this->db->like($qtype2,$qcampo2);
					$band = TRUE;
				}
			}
			if($qcampo3 && $qcampo3 != 'null' && $qcampo3 != null){
				$noMostrar = explode(",",$qcampo3);
				if(count($noMostrar)){
					foreach($noMostrar as $no){
						if($no){
							$this->db->where("(ch_solicitud.est_id <> '$no' AND E_.est_padre <> '$no')");	
						}
					}
				}				
			}
			if($fecha_inicial_listado!=''){	
				$fecha_inicial_where = "(`sol_fec_creacion` >= '".$fecha_inicial_listado."' OR `sol_fec_actualizacion` >= '".$fecha_inicial_listado."')";  
				$this->db->where($fecha_inicial_where);
				$band = TRUE;
			}

			$count = 0;

		  /*foreach($where as $item){
			
			if($count==0){
				$this->db->where($campo_where,$item);
				$band = TRUE;
			}				
			else{
				$this->db->or_where($campo_where,$item);
				$band = TRUE;
			}
			//var_dump($this->db);
			$count++;
		}*/		  		  
		$this->db->order_by($campo_order, $order);

		if($total==0)
			$query = $this->db->get($this->tableName());
		else
			$query = $this->db->get($this->tableName(),$total,$page);		  
	}else {
		
		$rr = @json_decode($this->input->post("query") ? $this->input->post("query") : $qcampo);
		if(isset($rr->solicitud)){
			$operadores[0] = "{cmp} = '{vr1}'";
			$operadores[1] = "{cmp} > '{vr1}'";
			$operadores[2] = "{cmp} < '{vr1}'";
			$operadores[3] = "{cmp} LIKE '%{vr1}%'";
			$operadores[4] = "{cmp} LIKE '{vr1}%'";
			$operadores[5] = "{cmp} LIKE '%{vr1}'";
			$operadores[6] = "{cmp} BETWEEN '{vr1}' AND '{vr2}'";
			$_where = " (";
			$qrys = $rr->solicitud;
			$_nn = count((array)$qrys)-1;

			foreach($rr->solicitud as $k=>$s){
				@$valor = explode(":=:", @$s->valor);
				$_where .= ( @$s->operador==6 ? str_replace(array("{cmp}", "{vr1}", "{vr2}"), array($s->qtype, @$valor[0], @$valor[1]),$operadores[@$s->operador]) : str_replace(array("{cmp}", "{vr1}"), array($s->qtype, @$valor[0]),$operadores[@$s->operador]));
				if($k<$_nn){
					$_where .= @$s->operador2=="1" ? ") AND (" : " OR ";
				}else if($k==$_nn){
					$_where .= ") ";
				}
			}
			if($_where!=" ("){
				$this->db->where($_where, NULL, FALSE);
			}
		}else{
			if(!empty($qtype)&&!empty($qcampo)){
				if($qtype=="sol_creditos")
					$this->db->where($qtype." >= ",$qcampo);
				else 
					$this->db->like($qtype,$qcampo);          
				$band = TRUE;
			}
			if(!empty($qtype2)&&!empty($qcampo2)){
				if($qtype2=="sol_creditos")
					$this->db->where($qtype2." >= ",$qcampo2);
				else 
						// echo $qcampo2;exit;
					$this->db->like($qtype2,$qcampo2);
				$band = TRUE;
			}
		}
		if($qcampo3 && $qcampo3 != 'null' && $qcampo3 != null){	
			$noMostrar = explode(",",$qcampo3);
			if(count($noMostrar)){
				foreach($noMostrar as $no){
					if($no){
						$this->db->where("(ch_solicitud.est_id <> '$no' AND E_.est_padre <> '$no')");	
					}
				}
			}				
		}
			//filtra por fecha inicial para el conteo de registros
		if($fecha_inicial_listado!=''){	
			$fecha_inicial_where = "(`sol_fec_creacion` >= '".$fecha_inicial_listado."' OR `sol_fec_actualizacion` >= '".$fecha_inicial_listado."')";  
			$this->db->where($fecha_inicial_where);
			$band = TRUE;
		}

		$query = $this->db->get($this->tableName());
	}
		// var_dump($this->db->queries);

		//separa la consulta e inserta los filtros para coordinador
	if(!empty($arr_prog) || !empty($arr_nivel)) {
		$query = $this->db->last_query();
		$querys = explode('ORDER BY', $query);
		$query = $querys[0];
	}

		//filtros para coordinador------------------------------------------------------------------------------------------------------------------------------------		
	if(!empty($arr_prog)){
			//if(empty($programa)||$programa==' '){
		$conector = ($band)?' AND':' WHERE';
		$query .= $conector.' (';
		$band2 = FALSE;			
		foreach($arr_prog as $item){
			$nivel = @$niveles[$item];
			$_nivel = explode("*", @$niveles[$item]);
			foreach($_nivel as $_n){
				switch (strtoupper($_n)) {
					case 'PR':
					$sol_nivel = '4';
					break;
					case 'MA':
					$sol_nivel = '4';
					break;
					case 'ES':
					$sol_nivel = '5';
					break;
					case 'DO':
					$sol_nivel = '6';
					break;
					default:
					$sol_nivel = '';
				}
			}
						//elimina prefijos para hacer igual MATERIA y programa
			$items = explode('-', $item);
			$item2 = $items[count($items) - 1];					
			$conector2 = ($band2)?' OR':'';
			$condicional = strtoupper($_n)=='PR' ? '<' : '=';
			$query .= $conector2.' (dep_id ="'.$item2.'") ';					
						//$query .= $conector2.' (dep_id ="'.$item2.'" AND sol_nivel '.$condicional.'"'.$sol_nivel.'") ';
			$band2 = TRUE;
		}
		$query .= ') ';
		$band = TRUE;	
			//}
	}

	if(!empty($arr_materias)&& is_array($arr_materias)){

			//if(empty($programa)||$programa==' '){
		$conector = ($band)?' AND':' WHERE';
		$query .= $conector.' (';
		$band2 = FALSE;			
		foreach($arr_materias as $item){					
					//elimina prefijos para hacer igual MATERIA y programa
			$items = explode('-', $item);
			$item2 = $items[count($items) - 1];
					// echo $item2."<br>";
			$conector2 = ($band2)?' OR':'';
					// $condicional = in_array('PR', explode("*", strtoupper(@$nivel)) ) ? '<' : '=';
					//$query .= $conector2.' (dep_id ="'.$item2.'" AND sol_nivel '.$condicional.'"'.$sol_nivel.'") ';
			$query .= $conector2.' (sol_ins_mat ="'.$item2.'") ';					
			$band2 = TRUE;
		}
		$query .= ') ';
		$band = TRUE;	
			//}
	}
		//en solicitud esta digito de la materia
	if(!empty($arr_nivel)){
		$conector = ($band)?' AND':' WHERE';
		$query .= $conector.' (';
		$band2 = FALSE;
		foreach($arr_nivel as $item){
			switch ($item) {
					case '1': //Pregrado
					$sol_nivel = '4';
					break;
					case '2': //Especializaci?n
					$sol_nivel = '5';
					break;
					case '3': //Maestr?a
					$sol_nivel = '4';
					break;
					case '4': //Doctorado
					$sol_nivel = '6';
					break;
					default:
					$sol_nivel = '';
				}				
				$conector2 = ($band2)?' OR':'';
				$query .= $item=='1' ? $conector2.' sol_nivel <'.$sol_nivel.' ' : $conector2.' sol_nivel ='.$sol_nivel.' ';
				$band2 = TRUE;
			}
			$query .= ')';
			$band = TRUE;			
		}
		//------------------------------------------------------------------------------------------------------------------------------------------------------------
		if(count($querys) > 1){
			$query .= 'ORDER BY'.$querys[1];
		}
		//si tiene filtro adiciona BINARY para b?squedas con tildes
		if(!empty($qtype)&&!empty($qcampo)&&!empty($qcampo2)){
			$query = str_replace("LIKE '%", "LIKE BINARY UCASE('%", $query);
			$query = str_replace("%'", "%')", $query);
			//$query = str_replace($qcampo."%'", $qcampo."%')", $query);
			//$query = str_replace($qcampo2."%'", $qcampo2."%')", $query);
			$query = str_replace("`$qtype`  LIKE", "UCASE($qtype) LIKE", $query);
			$query = str_replace("`$qtype2`  LIKE", "UCASE($qtype2) LIKE", $query);
			//$query = str_replace("UCASE( $qtype ) LIKE BINARYUCASE( '%$qcampo%'", "UCASE( $qtype ) LIKE BINARYUCASE( '%$qcampo%')", $query);
			//$query = str_replace("UCASE( $qtype2 ) LIKE BINARYUCASE( '%$qcampo2%'", "UCASE( $qtype2 ) LIKE BINARYUCASE( '%$qcampo2%')", $query);
			
			
		}
		if($qcampo3 && $qcampo3 != 'null' && $qcampo3 != null){	
			$noMostrar = explode(",",$qcampo3);
			if(count($noMostrar)){
				foreach($noMostrar as $no){
					if($no){
						$this->db->where("(ch_solicitud.est_id <> '$no' AND E_.est_padre <> '$no')");	
					}
				}
			}				
		}
		// $query .= " LIMIT 5";
		// echo "<pre>";
		// print_r($query);
		// echo "</pre>";
		// exit;
       // echo "<li>quiery fin". $query;
		$res = $this->db->query($query);
//if($qcampo!='')echo $query;

		return $res->result_array();
		
		//return $query->result_array();
	}
	
	public function get_item($id,$campo=''){
		if(empty($campo)){
			$campo = $this->tableLlave();
		}
		$query = $this->db->query("SELECT * FROM ".$this->tableName()." WHERE ".$campo."='".$id."' LIMIT 1");
		// $query = $this->db->get_where($this->tableName(), array($campo => $id));
		$resultado = $query->result_array();
		$resultado[0]['sol_fec_creacion'] = substr($resultado[0]['sol_fec_creacion'], 0, -3);

		return $resultado;
	}	
	public function validarItemCodigoCrn($codigo,$crn,$periodo,$tipo= ""){		
		// Condicion inicial
		// if(!$tipo)
		// 	$query = $this->db->get_where($this->tableName(), array('sol_uidnumber' => $codigo,'sol_ins_crn' => $crn,'sol_periodo' => $periodo, 'est_id <> ' => 6));
		// else
		// 	$query = $this->db->get_where($this->tableName(), array('sol_uidnumber' => $codigo,'sol_ins_crn' => $crn,'sol_periodo' => $periodo, 'tip_id' => $tipo, 'est_id <> ' => 6));
		
		if(!$tipo)
			$query = $this->db->get_where($this->tableName(), array(
				'sol_uidnumber' => $codigo,
				'sol_ins_crn' => $crn,
				'sol_periodo' => $periodo
				));
		else
			$query = $this->db->get_where($this->tableName(), array(
				'sol_uidnumber' => $codigo,
				'sol_ins_crn' => $crn,
				'sol_periodo' => $periodo, 
				'tip_id' => $tipo
				));

		$query_r = $this->db->last_query();
		// LS: Validacion para las solicitudes no cancelen en estados finales.
		$query_r = $query_r . " AND NOT est_id IN (6,3,14,2,17,18,19,20,21,23)";
		$q = $this->db->query($query_r);
		// $resultado = $query->result_array();
		$resultado = $q->result();
			//$resultado =$query->num_rows(); 		
		return $resultado;
	}		
	public function traerCodigoMateria($codigo,$periodo,$tipo= ""){		

		// if(!$tipo)
		// 	$query = $this->db->get_where($this->tableName(), array('sol_uidnumber' => $codigo,'sol_periodo' => $periodo, 'est_id <> ' => 6));
		// else
		// 	$query = $this->db->get_where($this->tableName(), array('sol_uidnumber' => $codigo,'sol_periodo' => $periodo, 'tip_id' => $tipo, 'est_id <> ' => 6));
		
		if(!$tipo)
			$query = $this->db->get_where($this->tableName(), array(
				'sol_uidnumber' => $codigo,
				'sol_periodo' => $periodo
				));
		else
			$query = $this->db->get_where($this->tableName(), array(
				'sol_uidnumber' => $codigo,
				'sol_periodo' => $periodo, 
				'tip_id' => $tipo
				));	

		$query_r = $this->db->last_query();
		// LS: Validacion para las solicitudes no cancelen en estados finales.
		$query_r = $query_r . " AND NOT est_id IN (6,3,14,2,17,18,19,20,21,23)";
		$q = $this->db->query($query_r);
		// $resultado = $query->result_array();
		$resultado = $q->result();
		return $resultado;
	}	
	public function validarCrnBloqueado($crn, $periodo = ""){	
		$where = array();			
		$where["crn"] = $crn;
		if($periodo != ""){
			$where["periodo"] = $periodo;
		}
		$query = $this->db->get_where("ch_crns_bloqueados", $where);
		$resultado = $query->result_array();	

		return $resultado;
	}	
	public function crnIsMagistral ($crn,$periodo)
	{
		$crnIsMagistral = $this->integracion->crnIsMagistral($crn,$periodo);
		return $crnIsMagistral;
	}
	public function get_dropdown(){		
		$lista = $this->get_all();
		$options = array('' => 'Seleccione');
		foreach($lista as $key=>$value){
			$options[$value[$this->tableLlave()]] = utf8_decode($value['sol_ticket']);
		}
		return $options;	
	}
	public function insert_id(){				
		return $this->db->insert_id(); 
	}
	
	public function reporte_solicitudes($conlimit,$programa='',$estado=0,$perido='', $fec_ini='',$fec_fin='',$inicio=0,$cantidad=20,$order='',$ordertype='ASC',$arr_prog,$arr_nivel){
		
		$niveles= $this->integracion->programasActivosNiveles();
		//print_r($niveles);
		$band = FALSE;
		$query = 'SELECT 
		sol_id,
		dep_id,
		dep_id_sec,
		sol_ticket,
		sol_descripcion,
		sol_ins_crn,
		sol_ins_seccion,
		sol_ins_instructor,
		sol_ins_tipo,
		sol_ret_crn,
		sol_ins_des,
		sol_lista_cruzada,
		sol_ret_des,
		sol_ins_mat,
		sol_ret_mat,
		sol_sug_ret_crn,
		sol_sug_ins_crn,
		sol_sug_ins_des,
		sol_sug_ret_des,
		sol_sug_ins_mat,
		sol_sug_ret_mat,
		sol_login,
		sol_email,
		sol_nombre,
		sol_apellido,
		sol_prog,
		sol_doble_prog,
		sol_creditos,
		sol_periodo,
		sol_pidm,
		sol_uidnumber,
		sol_ip,
		sol_fec_creacion,
		sol_fec_actualizacion,
		tip_id,
		mov_id,
		a.est_id,
		b.est_descripcion,
		sol_ssc,
		sol_primer_sem,
		sol_opcion_estud,
		sol_fec_est_actualiza
		FROM ch_solicitud a
		JOIN ch_estado b ON a.est_id = b.est_id';
		if(!empty($programa)&&$programa!=' '){
			$nivel = $niveles[$programa];
			switch (strtoupper($nivel)) {
				case 'PR':
				$sol_nivel = '4';
				break;
				case 'MA':
				$sol_nivel = '4';
				break;
				case 'ES':
				$sol_nivel = '5';
				break;
				case 'DO':
				$sol_nivel = '6';
				break;
				default:
				$sol_nivel = '';
			}
			//elimina prefijos para hacer igual MATERIA y programa
			$programas = explode('-', $programa);
			$programa2 = $programas[count($programas) - 1];
			$condicional = strtoupper($nivel)=='PR' ? '<' : '=';
			//$query .=' WHERE (a.dep_id ="'.$programa2.'" AND a.sol_nivel '.$condicional.'"'.$sol_nivel.'")';
			$query .=' WHERE (a.dep_id ="'.$programa2.'")';
			$band = TRUE;
		}
		if($estado>0){
			$conector = ($band)?'AND':'WHERE';
			$query .=' '.$conector.' a.est_id ="'.$estado.'"';
			$band = TRUE;
		}
		if ($perido > 0){
			$conector = ($band)?'AND':'WHERE';
			$query .= ' '.$conector.' a.sol_periodo = "'.$perido.'"';
			$band = TRUE;
		}elseif(!empty($fec_ini)&&$fec_ini!=' '&&$fec_fin!=' '&&!empty($fec_fin)){
			$conector = ($band)?'AND':'WHERE';
			$fec_ini2 = explode(' ', $fec_ini);
			$fec_ini2 = $fec_ini2[0];
			$fec_fin2 = explode(' ', $fec_fin);
			$fec_fin2 = $fec_fin2[0];
			$query .= $fec_ini2==$fec_fin2 ? ' '.$conector.' a.sol_fec_creacion like "'.$fec_ini2.'%"' : ' '.$conector.' a.sol_fec_creacion >="'.$fec_ini.'" AND a.sol_fec_creacion<="'.$fec_fin.'"';
			$band = TRUE;
		}
		//filtros para coordinador------------------------------------------------------------------------------------------------------------------------------------		
		if(!empty($arr_prog)){
			if(empty($programa)||$programa==' '){
				$conector = ($band)?' AND':' WHERE';
				$query .= $conector.' (';
				$band2 = FALSE;			
				foreach($arr_prog as $item){
					$nivel = $niveles[$item];
					switch (strtoupper($nivel)) {
						case 'PR':
						$sol_nivel = '4';
						break;
						case 'MA':
						$sol_nivel = '4';
						break;
						case 'ES':
						$sol_nivel = '5';
						break;
						case 'DO':
						$sol_nivel = '6';
						break;
						default:
						$sol_nivel = '';
					}
					//elimina prefijos para hacer igual MATERIA y programa
					$items = explode('-', $item);
					$item2 = $items[count($items) - 1];					
					$conector2 = ($band2)?' OR':'';
					$condicional = strtoupper($nivel)=='PR' ? '<' : '=';
					//$query .= $conector2.' (a.dep_id ="'.$item2.'" AND a.sol_nivel '.$condicional.'"'.$sol_nivel.'") ';
					$query .= $conector2.' (a.dep_id ="'.$item2.'") ';					
					$band2 = TRUE;
				}
				$query .= ') ';
				$band = TRUE;	
			}
		}
		//en solicitud esta digito de la materia
		if(!empty($arr_nivel)){
			$conector = ($band)?' AND':' WHERE';
			$query .= $conector.' (';
			$band2 = FALSE;
			foreach($arr_nivel as $item){
				switch ($item) {
					case '1': //Pregrado
					$sol_nivel = '4';
					break;
					case '2': //Especializaci?n
					$sol_nivel = '5';
					break;
					case '3': //Maestr?a
					$sol_nivel = '4';
					break;
					case '4': //Doctorado
					$sol_nivel = '6';
					break;
					default:
					$sol_nivel = '';
				}				
				$conector2 = ($band2)?' OR':'';
				$query .= $item=='1' ? $conector2.' a.sol_nivel <'.$sol_nivel.' ' : $conector2.' a.sol_nivel ='.$sol_nivel.' ';
				$band2 = TRUE;
			}
			$query .= ')';
			$band = TRUE;			
		}
		//------------------------------------------------------------------------------------------------------------------------------------------------------------
		
		if($order=='')//if($order!=' ')
		$order = $this->tableLlave();
		$query .=' ORDER BY '.$order.' '.$ordertype;
		
		if($conlimit)
			$query .=' LIMIT '.$inicio.','.$cantidad;
		
#		echo $query;	
#		$query .=' LIMIT 20001, 40000';	
#		exit;
		$res = $this->db->query($query);		
		return $res->result_array();		
	}

	public function reporte_solicitud_basico($conlimit,$programa='',$estado=0,$periodo=0,$fec_ini='',$fec_fin='',$inicio=0,$cantidad=20,$order='',$ordertype='ASC',$arr_prog,$arr_nivel){
		
		$niveles= $this->integracion->programasActivosNiveles();
		//print_r($niveles);
		$band = FALSE;
		$query = 'SELECT sol_id,

		sol_ins_crn,
		sol_ins_seccion,
		sol_ins_instructor,
		sol_ins_tipo,
		sol_ret_crn,
		sol_ins_des,
	    sol_lista_cruzada,		
		sol_ins_mat,				  
		sol_nombre,
		sol_apellido,
		sol_uidnumber,
		sol_fec_creacion,
		sol_periodo,
		sol_fec_actualizacion

		FROM ch_solicitud a
		JOIN ch_estado b ON a.est_id = b.est_id';
		if(!empty($programa)&&$programa!=' '){
			$nivel = $niveles[$programa];
			switch (strtoupper($nivel)) {
				case 'PR':
				$sol_nivel = '4';
				break;
				case 'MA':
				$sol_nivel = '4';
				break;
				case 'ES':
				$sol_nivel = '5';
				break;
				case 'DO':
				$sol_nivel = '6';
				break;
				default:
				$sol_nivel = '';
			}
			//elimina prefijos para hacer igual MATERIA y programa
			$programas = explode('-', $programa);
			$programa2 = $programas[count($programas) - 1];
			$condicional = strtoupper($nivel)=='PR' ? '<' : '=';
			//$query .=' WHERE (a.dep_id ="'.$programa2.'" AND a.sol_nivel '.$condicional.'"'.$sol_nivel.'")';
			$query .=' WHERE (a.dep_id ="'.$programa2.'")';
			$band = TRUE;
		}
		if($estado>0){
			$conector = ($band)?'AND':'WHERE';
			$query .=' '.$conector.' a.est_id ="'.$estado.'"';
			$band = TRUE;
		}
		if ($periodo > 0){
			$conector = ($band)?'AND':'WHERE';
			$query .= ' '.$conector.' a.sol_periodo = "'.$periodo.'"';
			$band = TRUE;
		}elseif(!empty($fec_ini)&&$fec_ini!=' '&&$fec_fin!=' '&&!empty($fec_fin)){
			$conector = ($band)?'AND':'WHERE';
			$fec_ini2 = explode(' ', $fec_ini);
			$fec_ini2 = $fec_ini2[0];
			$fec_fin2 = explode(' ', $fec_fin);
			$fec_fin2 = $fec_fin2[0];
			$query .= $fec_ini2==$fec_fin2 ? ' '.$conector.' a.sol_fec_creacion like "'.$fec_ini2.'%"' : ' '.$conector.' a.sol_fec_creacion >="'.$fec_ini.'" AND a.sol_fec_creacion<="'.$fec_fin.'"';
			$band = TRUE;
		}
		
		//filtros para coordinador------------------------------------------------------------------------------------------------------------------------------------		
		if(!empty($arr_prog)){
			if(empty($programa)||$programa==' '){
				$conector = ($band)?' AND':' WHERE';
				$query .= $conector.' (';
				$band2 = FALSE;			
				foreach($arr_prog as $item){
					$nivel = $niveles[$item];
					switch (strtoupper($nivel)) {
						case 'PR':
						$sol_nivel = '4';
						break;
						case 'MA':
						$sol_nivel = '4';
						break;
						case 'ES':
						$sol_nivel = '5';
						break;
						case 'DO':
						$sol_nivel = '6';
						break;
						default:
						$sol_nivel = '';
					}
					//elimina prefijos para hacer igual MATERIA y programa
					$items = explode('-', $item);
					$item2 = $items[count($items) - 1];					
					$conector2 = ($band2)?' OR':'';
					$condicional = strtoupper($nivel)=='PR' ? '<' : '=';
					//$query .= $conector2.' (a.dep_id ="'.$item2.'" AND a.sol_nivel '.$condicional.'"'.$sol_nivel.'") ';
					$query .= $conector2.' (a.dep_id ="'.$item2.'") ';					
					$band2 = TRUE;
				}
				$query .= ') ';
				$band = TRUE;	
			}
		}
		//en solicitud esta digito de la materia
		if(!empty($arr_nivel)){
			$conector = ($band)?' AND':' WHERE';
			$query .= $conector.' (';
			$band2 = FALSE;
			foreach($arr_nivel as $item){
				switch ($item) {
					case '1': //Pregrado
					$sol_nivel = '4';
					break;
					case '2': //Especializaci?n
					$sol_nivel = '5';
					break;
					case '3': //Maestr?a
					$sol_nivel = '4';
					break;
					case '4': //Doctorado
					$sol_nivel = '6';
					break;
					default:
					$sol_nivel = '';
				}				
				$conector2 = ($band2)?' OR':'';
				$query .= $item=='1' ? $conector2.' a.sol_nivel <'.$sol_nivel.' ' : $conector2.' a.sol_nivel ='.$sol_nivel.' ';
				$band2 = TRUE;
			}
			$query .= ')';
			$band = TRUE;			
		}
		//------------------------------------------------------------------------------------------------------------------------------------------------------------
		
		if($order=='')//if($order!=' ')
		$order = $this->tableLlave();
		$query .=' ORDER BY '.$order.' '.$ordertype;
		
		if($conlimit)
			$query .=' LIMIT '.$inicio.','.$cantidad;
		
		// echo $query;		
		$res = $this->db->query($query);		
		return $res->result_array();		
	}
	
	public function reporte_solicitud_estado($conlimit,$programa='',$estado=0,$periodo=0,$fec_ini='',$fec_fin='',$inicio=0,$cantidad=20,$order='',$ordertype='ASC',$arr_prog,$arr_nivel){
		
		$niveles= $this->integracion->programasActivosNiveles();
		$band = FALSE;
		$query = 'SELECT a.dep_id, a.est_id, b.est_descripcion, a.sol_fec_creacion, count(sol_id) as total
		FROM `ch_solicitud` a
		JOIN ch_estado b ON a.est_id = b.est_id';
		if(!empty($programa)&&$programa!=' '){
			$nivel = $niveles[$programa];
			switch (strtoupper($nivel)) {
				case 'PR':
				$sol_nivel = '4';
				break;
				case 'MA':
				$sol_nivel = '4';
				break;
				case 'ES':
				$sol_nivel = '5';
				break;
				case 'DO':
				$sol_nivel = '6';
				break;
				default:
				$sol_nivel = '';
			}
			//elimina prefijos para hacer igual MATERIA y programa
			$programas = explode('-', $programa);
			$programa2 = $programas[count($programas) - 1];
			$condicional = strtoupper($nivel)=='PR' ? '<' : '=';
			//$query .=' WHERE (a.dep_id ="'.$programa2.'" AND a.sol_nivel '.$condicional.'"'.$sol_nivel.'")';
			$query .=' WHERE (a.dep_id ="'.$programa2.'")';
			$band = TRUE;
		}
		if($estado>0){
			$conector = ($band)?'AND':'WHERE';
			$query .=' '.$conector.' a.est_id ="'.$estado.'"';
			$band = TRUE;
		}

		if ($periodo > 0){
			$conector = ($band)?'AND':'WHERE';
			$query .= ' '.$conector.' a.sol_periodo = "'.$periodo.'"';
			$band = TRUE;
		}elseif(!empty($fec_ini)&&$fec_ini!=' '&&$fec_fin!=' '&&!empty($fec_fin)){
			$conector = ($band)?'AND':'WHERE';
			$fec_ini2 = explode(' ', $fec_ini);
			$fec_ini2 = $fec_ini2[0];
			$fec_fin2 = explode(' ', $fec_fin);
			$fec_fin2 = $fec_fin2[0];
			$query .= $fec_ini2==$fec_fin2 ? ' '.$conector.' a.sol_fec_creacion like "'.$fec_ini2.'%"' : ' '.$conector.' a.sol_fec_creacion >="'.$fec_ini.'" AND a.sol_fec_creacion<="'.$fec_fin.'"';
			$band = TRUE;			
		}
		
		//filtros para coordinador------------------------------------------------------------------------------------------------------------------------------------		
		if(!empty($arr_prog)){
			if(empty($programa)||$programa==' '){
				$conector = ($band)?' AND':' WHERE';
				$query .= $conector.' (';
				$band2 = FALSE;			
				foreach($arr_prog as $item){
					$nivel = $niveles[$item];
					switch (strtoupper($nivel)) {
						case 'PR':
						$sol_nivel = '4';
						break;
						case 'MA':
						$sol_nivel = '4';
						break;
						case 'ES':
						$sol_nivel = '5';
						break;
						case 'DO':
						$sol_nivel = '6';
						break;
						default:
						$sol_nivel = '';
					}
					//elimina prefijos para hacer igual MATERIA y programa
					$items = explode('-', $item);
					$item2 = $items[count($items) - 1];					
					$conector2 = ($band2)?' OR':'';
					$condicional = strtoupper($nivel)=='PR' ? '<' : '=';
					//$query .= $conector2.' (a.dep_id ="'.$item2.'" AND a.sol_nivel '.$condicional.'"'.$sol_nivel.'") ';
					$query .= $conector2.' (a.dep_id ="'.$item2.'") ';					
					$band2 = TRUE;
				}
				$query .= ') ';
				$band = TRUE;	
			}
		}
		//en solicitud esta digito de la materia
		if(!empty($arr_nivel)){
			$conector = ($band)?' AND':' WHERE';
			$query .= $conector.' (';
			$band2 = FALSE;
			foreach($arr_nivel as $item){
				switch ($item) {
					case '1': //Pregrado
					$sol_nivel = '4';
					break;
					case '2': //Especializaci?n
					$sol_nivel = '5';
					break;
					case '3': //Maestr?a
					$sol_nivel = '4';
					break;
					case '4': //Doctorado
					$sol_nivel = '6';
					break;
					default:
					$sol_nivel = '';
				}				
				$conector2 = ($band2)?' OR':'';
				$query .= $item=='1' ? $conector2.' a.sol_nivel <'.$sol_nivel.' ' : $conector2.' a.sol_nivel ='.$sol_nivel.' ';
				$band2 = TRUE;
			}
			$query .= ')';
			$band = TRUE;			
		}
		//------------------------------------------------------------------------------------------------------------------------------------------------------------
		
		if($order=='')//if($order!=' ')
		$order = $this->tableLlave();
		$query .=' GROUP BY a.dep_id, b.est_descripcion';	
		$query .=' ORDER BY '.$order;
		
		if($conlimit)
			$query .=' LIMIT '.$inicio.','.$cantidad;
		
		$res = $this->db->query($query);		
		return $res->result_array();
		
	}
	
	public function reporte_solicitud_crn($conlimit,$programa='',$estado=0,$periodo=0,$fec_ini='',$fec_fin='',$inicio=0,$cantidad=20,$order='',$ordertype='ASC',$arr_prog,$arr_nivel){
		
		$niveles= $this->integracion->programasActivosNiveles();	
		$band = FALSE;
		$query = 'SELECT a.sol_ins_crn, a.dep_id, a.est_id, b.est_descripcion, a.sol_fec_creacion, count(sol_id) as total
		FROM `ch_solicitud` a
		JOIN ch_estado b ON a.est_id = b.est_id';
		if(!empty($programa)&&$programa!=' '){
			$nivel = $niveles[$programa];
			switch (strtoupper($nivel)) {
				case 'PR':
				$sol_nivel = '4';
				break;
				case 'MA':
				$sol_nivel = '4';
				break;
				case 'ES':
				$sol_nivel = '5';
				break;
				case 'DO':
				$sol_nivel = '6';
				break;
				default:
				$sol_nivel = '';
			}
			//elimina prefijos para hacer igual MATERIA y programa
			$programas = explode('-', $programa);
			$programa2 = $programas[count($programas) - 1];
			$condicional = strtoupper($nivel)=='PR' ? '<' : '=';
			//$query .=' WHERE (a.dep_id ="'.$programa2.'" AND a.sol_nivel '.$condicional.'"'.$sol_nivel.'")';
			$query .=' WHERE (a.dep_id ="'.$programa2.'") ';
			$band = TRUE;
		}
		if($estado>0){
			$conector = ($band)?'AND':'WHERE';
			$query .=' '.$conector.' a.est_id ="'.$estado.'"';
			$band = TRUE;
		}
		if ($periodo > 0){
			$conector = ($band)?'AND':'WHERE';
			$query .= ' '.$conector.' a.sol_periodo = "'.$periodo.'"';
			$band = TRUE;
		}elseif(!empty($fec_ini)&&$fec_ini!=' '&&$fec_fin!=' '&&!empty($fec_fin)){
			$conector = ($band)?'AND':'WHERE';
			$fec_ini2 = explode(' ', $fec_ini);
			$fec_ini2 = $fec_ini2[0];
			$fec_fin2 = explode(' ', $fec_fin);
			$fec_fin2 = $fec_fin2[0];
			$query .= $fec_ini2==$fec_fin2 ? ' '.$conector.' a.sol_fec_creacion like "'.$fec_ini2.'%"' : ' '.$conector.' a.sol_fec_creacion >="'.$fec_ini.'" AND a.sol_fec_creacion<="'.$fec_fin.'"';
			$band = TRUE;
		}
		
		//filtros para coordinador------------------------------------------------------------------------------------------------------------------------------------		
		if(!empty($arr_prog)){
			if(empty($programa)||$programa==' '){
				$conector = ($band)?' AND':' WHERE';
				$query .= $conector.' (';
				$band2 = FALSE;			
				foreach($arr_prog as $item){
					$nivel = $niveles[$item];
					switch (strtoupper($nivel)) {
						case 'PR':
						$sol_nivel = '4';
						break;
						case 'MA':
						$sol_nivel = '4';
						break;
						case 'ES':
						$sol_nivel = '5';
						break;
						case 'DO':
						$sol_nivel = '6';
						break;
						default:
						$sol_nivel = '';
					}
					//elimina prefijos para hacer igual MATERIA y programa
					$items = explode('-', $item);
					$item2 = $items[count($items) - 1];					
					$conector2 = ($band2)?' OR':'';
					$condicional = strtoupper($nivel)=='PR' ? '<' : '=';
					//$query .= $conector2.' (a.dep_id ="'.$item2.'" AND a.sol_nivel '.$condicional.'"'.$sol_nivel.'") ';	
					$query .= $conector2.' (a.dep_id ="'.$item2.'") ';
					$band2 = TRUE;
				}
				$query .= ') ';
				$band = TRUE;	
			}
		}
		//en solicitud esta digito de la materia
		if(!empty($arr_nivel)){
			$conector = ($band)?' AND':' WHERE';
			$query .= $conector.' (';
			$band2 = FALSE;
			foreach($arr_nivel as $item){
				switch ($item) {
					case '1': //Pregrado
					$sol_nivel = '4';
					break;
					case '2': //Especializaci?n
					$sol_nivel = '5';
					break;
					case '3': //Maestr?a
					$sol_nivel = '4';
					break;
					case '4': //Doctorado
					$sol_nivel = '6';
					break;
					default:
					$sol_nivel = '';
				}				
				$conector2 = ($band2)?' OR':'';
				$query .= $item=='1' ? $conector2.' a.sol_nivel <'.$sol_nivel.' ' : $conector2.' a.sol_nivel ='.$sol_nivel.' ';
				$band2 = TRUE;
			}
			$query .= ')';
			$band = TRUE;			
		}
		//------------------------------------------------------------------------------------------------------------------------------------------------------------
		
		if($order=='')//if($order!=' ')
		$order = $this->tableLlave();
		$query .=' GROUP BY a.sol_ins_crn';	
		$query .=' ORDER BY '.$order;
		
		if($conlimit)
			$query .=' LIMIT '.$inicio.','.$cantidad;
		
		//echo $query;
		$res = $this->db->query($query);		
		return $res->result_array();
		
	}
	
	public function count_reporte_solicitudes($programa='',$estado=0,$periodo=0,$fec_ini='',$fec_fin='',$inicio=0,$cantidad=20,$order='',$ordertype='ASC',$arr_prog,$arr_nivel){
		/*$band = FALSE;
		$query = 'SELECT sol_id,
				 dep_id,
				 dep_id_sec,
				 sol_ticket,
				 sol_descripcion,
				 sol_ins_crn,
				 sol_ins_seccion,
				 sol_ins_instructor,
				 sol_ins_tipo,
				 sol_ret_crn,
				 sol_ins_des,
				 sol_ret_des,
				 sol_ins_mat,
				 sol_ret_mat,
				 sol_sug_ret_crn,
				 sol_sug_ins_crn,
				 sol_sug_ins_des,
				 sol_sug_ret_des,
				 sol_sug_ins_mat,
				 sol_sug_ret_mat,
				 sol_login,
				 sol_email,
				 sol_nombre,
				 sol_apellido,
				 sol_pidm,
				 sol_uidnumber,
				 sol_ip,
				 sol_fec_creacion,
				 sol_fec_actualizacion,
				 tip_id,
				 mov_id,
				 a.est_id,
				 b.est_descripcion
			  FROM ch_solicitud a
			  JOIN ch_estado b ON a.est_id = b.est_id';
		if(!empty($programa)&&$programa!=' '){
			$query .=' WHERE a.dep_id ="'.$programa.'"';
			$band = TRUE;
		}
		if($estado>0){
			$conector = ($band)?'AND':'WHERE';
			$query .=' '.$conector.' a.est_id ="'.$estado.'"';
			$band = TRUE;
		}
		if(!empty($fec_ini)&&$fec_ini!=' '&&$fec_fin!=' '&&!empty($fec_fin)){
			$conector = ($band)?'AND':'WHERE';
			$query .=' '.$conector.' a.sol_fec_creacion >="'.$fec_ini.'" AND a.sol_fec_creacion<="'.$fec_fin.'"';			
		}
		if($order!=' ')
			$order = $this->tableLlave();
		$query .=' ORDER BY '.$order.' '.$ordertype;				
		
		$res = $this->db->query($query);
		
		return count($res->result_array());*/
		return count($this->reporte_solicitudes(false,$programa,$estado,$periodo,$fec_ini,$fec_fin,$inicio,$cantidad,$order,$ordertype,$arr_prog,$arr_nivel));
	}
	public function count_reporte_solicitud_basico($programa='',$estado=0,$periodo=0,$fec_ini='',$fec_fin='',$inicio=0,$cantidad=20,$order='',$ordertype='ASC',$arr_prog,$arr_nivel){		
		return count($this->reporte_solicitud_basico(false,$programa,$estado,$periodo,$fec_ini,$fec_fin,$inicio,$cantidad,$order,$ordertype,$arr_prog,$arr_nivel));
	}
	
	public function count_reporte_solicitud_estado($programa='',$estado=0,$periodo=0,$fec_ini='',$fec_fin='',$inicio=0,$cantidad=20,$order='',$ordertype='ASC',$arr_prog,$arr_nivel){
		
		/*$band = FALSE;
		$query = 'SELECT a.dep_id, a.est_id, b.est_descripcion, a.sol_fec_creacion, count(sol_id) as total
			  FROM `ch_solicitud` a
			  JOIN ch_estado b ON a.est_id = b.est_id';
		if(!empty($programa)&&$programa!=' '){
			$query .=' WHERE a.dep_id ="'.$programa.'"';
			$band = TRUE;
		}
		if($estado>0){
			$conector = ($band)?'AND':'WHERE';
			$query .=' '.$conector.' a.est_id ="'.$estado.'"';
			$band = TRUE;
		}
		if(!empty($fec_ini)&&$fec_ini!=' '&&$fec_fin!=' '&&!empty($fec_fin)){
			$conector = ($band)?'AND':'WHERE';
			$query .=' '.$conector.' a.sol_fec_creacion >="'.$fec_ini.'" AND a.sol_fec_creacion<="'.$fec_fin.'"';			
		}
		if($order!=' ')
			$order = $this->tableLlave();
		$query .=' GROUP BY b.est_descripcion';	
		$query .=' ORDER BY '.$order;				
		
		//echo $query;
		$res = $this->db->query($query);
		
		return count($res->result_array());*/
		return count($this->reporte_solicitud_estado(false,$programa,$estado,$periodo,$fec_ini,$fec_fin,$inicio,$cantidad,$order,$ordertype,$arr_prog,$arr_nivel));
	}
	
	public function count_reporte_solicitud_crn($programa='',$estado=0,$periodo=0,$fec_ini='',$fec_fin='',$inicio=0,$cantidad=20,$order='',$ordertype='ASC',$arr_prog,$arr_nivel){
		
		/*$band = FALSE;
		$query = 'SELECT a.sol_ins_crn, a.dep_id, a.est_id, b.est_descripcion, a.sol_fec_creacion, count(sol_id) as total
			  FROM `ch_solicitud` a
			  JOIN ch_estado b ON a.est_id = b.est_id';
		if(!empty($programa)&&$programa!=' '){
			$query .=' WHERE a.dep_id ="'.$programa.'"';
			$band = TRUE;
		}
		if($estado>0){
			$conector = ($band)?'AND':'WHERE';
			$query .=' '.$conector.' a.est_id ="'.$estado.'"';
			$band = TRUE;
		}
		if(!empty($fec_ini)&&$fec_ini!=' '&&$fec_fin!=' '&&!empty($fec_fin)){
			$conector = ($band)?'AND':'WHERE';
			$query .=' '.$conector.' a.sol_fec_creacion >="'.$fec_ini.'"  AND a.sol_fec_creacion<="'.$fec_fin.'"';			
		}
		if($order!=' ')
			$order = $this->tableLlave();
		$query .=' GROUP BY a.sol_ins_crn';	
		$query .=' ORDER BY '.$order;		
		
		$res = $this->db->query($query);
		
		return count($res->result_array());*/
		return count($this->reporte_solicitud_crn(false,$programa,$estado,$periodo,$fec_ini,$fec_fin,$inicio,$cantidad,$order,$ordertype,$arr_prog,$arr_nivel));
	}
	
	
	function getEstados(){
		$query = $this->db->get("ch_estado");
		return $query->result_array();
		
	}
	
	function actEstado($id){
		$query = $this->db->query("UPDATE ch_comentario SET estado='0' WHERE sol_id='$id'");
	}
	
	function cargarHistorico($id,$periodo){
		$query = $this->db->query("SELECT sol_login FROM ch_solicitud WHERE sol_id='$id' LIMIT 1");
		$login = $query->result();
		$login = @$login[0]->sol_login;
		$query = $this->db->query("
			SELECT 
			S.*,
			T.tip_descripcion,
			E.est_descripcion
			FROM 
			ch_solicitud S 
			LEFT JOIN 
			ch_tipo T ON (T.tip_id = S.tip_id) 
			LEFT JOIN
			ch_estado E ON (S.est_id = E.est_id)
			WHERE 
			S.sol_login = '".mysql_real_escape_string($login)."'
			AND 
			S.sol_periodo = '" . $periodo . "'
			ORDER BY 
			S.sol_fec_creacion DESC ");
		return $query->result();
	}

	function agregarComentarioPersonal ($idcomenpersonal,$comentariotitulo,$comentariocont,$login)
	{
		$login            = mysql_real_escape_string($login);
		$comentariotitulo = mysql_real_escape_string($comentariotitulo);
		$comentariocont   = mysql_real_escape_string($comentariocont);
		$idsValidosUser   = $this->listadoIDSComentarios($login);
		if (!empty($idcomenpersonal)) //Si viene un ID se actualiza el comentario
		{
			if ( in_array($idcomenpersonal, $idsValidosUser) ) //Se valida que el ID corresponda a uno del usuario logueado.
			{
				$query = "UPDATE ch_comenpersonales SET comentariotitulo='".$comentariotitulo."', comentariocont='".$comentariocont."' WHERE id = ".$idcomenpersonal;
			}
			else
			{
				return "idsinvalidos";
			}
		}
		else
		{
			$query = "INSERT INTO ch_comenpersonales (login,comentariotitulo,comentariocont) VALUES ('$login','$comentariotitulo','$comentariocont')";
		}
		//$this->db->insert_string('ch_comenpersonales',array('login'=>$login,'comentariotitulo'=>$comentariotitulo,'comentariocont'=>$comentariocont));
		$this->db->query($query);
		$id_ch_comenpersonales = $this->db->insert_id();
		return $id_ch_comenpersonales;
	}
	
	function listadoIDSComentarios($login)
	{
		$query  = $this->db->query("SELECT id FROM ch_comenpersonales WHERE login='".$login."' ");
		$return = array();
		foreach ($query->result() as $key => $row)
		{
			$return[] = $row->id;
		}
		return $return;
	}

	function borrarComentarioPersonal ($idcomenpersonal)
	{
		$idcomenpersonal = (int) mysql_real_escape_string($idcomenpersonal);
		$query           = "DELETE FROM ch_comenpersonales WHERE id = $idcomenpersonal";
		$this->db->query($query);
		return 1;
	}

	public function msgCRN($crn)
	{
		if(empty($crn)){
			return "";
		}
		$query = $this->db->query("SELECT message FROM ch_mensajes WHERE crn LIKE '%".$crn."%' LIMIT 1");
		$resultado = $query->result_array();
		return $resultado[0]['message'];                
	}

	public function getProgramas ()
	{
		$query = $this->db->query("SELECT swtprnl_enfasis_desc FROM ch_programas_act");
		$resultado = $query->result_array();
		return $resultado;
	}

	public function conultarHorarioCRN ($crn,$periodo)
	{
		$horarioCRN = $this->integracion->consultarHorarioCRN($crn,$periodo);
		return $horarioCRN;
	}
}
