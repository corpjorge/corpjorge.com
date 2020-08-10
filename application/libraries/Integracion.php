<?php

/**
 * Description of conflictos
 *
 * @author John Jimenez
 */
require_once 'ociInteractor.php';
class integracion {
    private $_db;
	private $CI;
    public function integracion(){
		 $this->CI =& get_instance();
		 $this->CI->load->model('Departamento_model','',TRUE);
	}

    public function proc1 () {
        $this->_db = new ociInteractor();
        $this->_db->ejecutar_procedure($query_procedure, $vector_variables_entrada, $vector_variables_salida);

    }

	/*
     * esPrimiparo
     * $pidm   : PIDM del usuario a validar
     * periodo : Periodo sobre el cual validar si el estudiante es primiparo
     * Retorna : N si el estudiante NO está en primer semestre
     * Retorna : S si el estudiante ESTÁ en primer semestre
     */
    public function esPrimiparo ($pidm,$periodo)
    {
        if(empty ($pidm) || empty ($periodo))
        {
            return false;
        }
        else
        {
            $datosSalida      = array();
            $this->_db        = new ociInteractor();
            $periodo          = max(explode(",", $periodo));
            $variablesEntrada = array('pidm'=>$pidm,'periodo'=>$periodo);
            $variablesSalida  = array('resultado');
            $resultado        = $this->_db->ejecutar_consulta("SELECT PKG_CONFLICTO.F_PRIMIPARO ($pidm,'$periodo') FROM dual");
            if ($resultado[0][0] == null)
            {
                return array('MSG'=>'','PRIMIPARO'=>'N');
            }
            else
            {	$resultado = ltrim ($resultado[0][0],";");
                return array('MSG'=>$resultado,'PRIMIPARO'=>'S');
            }
        }
    }

    public function datosEstudiante($pidm,$periodo){
		header('Content-Type: text/html; charset=utf-8');
        if(empty ($pidm)||empty ($periodo)){
            return false;
        }else{
            $datosSalida=array();
            $this->_db = new ociInteractor();

			$periodo = max(explode(",", $periodo));

            $variablesEntrada=array('pidm'=>$pidm,'periodo'=>$periodo);
            $variablesSalida=array('resultado');
            $resultado=$this->_db->ejecutar_consulta("select PKG_CONFLICTO.F_DATOS_ESTUDIANTE ($pidm,'$periodo') from dual");
            //echo "select PKG_CONFLICTO.F_DATOS_ESTUDIANTE ($pidm,'$periodo') from dual";
			$datosRegistro=explode(";", $resultado[0][0]);
            $datosSalida= explode(",", DATOS_ESTUDIANTE);
            $datosEstudiante=array_combine($datosSalida, $datosRegistro);
            if($datosEstudiante){
                $datosEstudiante['CRED_MAX'] = (float) str_replace(",", ".", $datosEstudiante['CRED_MAX']);
            }
			// echo "<pre>e";
			// print_r($pidm);
			// print_r(explode(";" ,$resultado[0][0]));
            // print_r($resultado[0][0]);
			// print_r($datosEstudiante);
			// exit;
            return $datosEstudiante;
        }

    }

    public function materiasInscritas($pidm,$periodo){
        if(empty ($pidm)||empty ($periodo)){
            return false;
        }else{
			$periodo = max(explode(",", $periodo));
			$datosSalida=array();
            $this->_db = new ociInteractor();
            $variablesEntrada=array('pidm'=>$pidm,'per'=>$periodo);
            $variablesSalida=array('crnInscritos');
            //$retorno=$this->_db->ejecutar_procedure('PKG_CONFLICTO.F_MATERIAS_INSCRITAS', $variablesEntrada, $variablesSalida);
            $resultado=$this->_db->ejecutar_consulta("select PKG_CONFLICTO.F_MATERIAS_INSCRITAS ($pidm,'$periodo') from dual");
			//echo "select PKG_CONFLICTO.F_MATERIAS_INSCRITAS ($pidm,'$periodo') from dual<br>";

			//$resultado[0][0] .= ";40324";
			$datosRegistro=explode(";", $resultado[0][0]);
            foreach ($datosRegistro as $fila) {
                if(!empty ($fila)){
                    //$nombreMateria=$this->_db->ejecutar_consulta("select titulo from cartelera_conflicto where crn=$fila");
                    //$datosSalida[$fila]=$nombreMateria[0][0];
					$nombreMateria=$this->_db->ejecutar_consulta("select crn ,materia||curso as materia,seccion,titulo,profesor_1||','||profesor_2||','||profesor_3 as profesores, atributo_curso from cartelera_conflicto where crn=$fila");
                    //echo "select crn ,materia||curso as materia,seccion,titulo,profesor_1||','||profesor_2||','||profesor_3 as profesores from cartelera_conflicto where crn=$fila<br>";
					if(is_array($nombreMateria)){
						foreach ($nombreMateria as $registro) {
							if (substr($registro['PROFESORES'], -4)==", , ")$registro['PROFESORES']=str_replace(", , ", "", $registro['PROFESORES']);
							if (substr($registro['PROFESORES'], -1)==",")$registro['PROFESORES']=substr_replace($registro['PROFESORES'],"",-1);
							if (substr($registro['PROFESORES'], -2)==", ")$registro['PROFESORES']=substr_replace($registro['PROFESORES'],"",-2);
						}
						$datosSalida[$fila]=$registro;
					}
                }
            }
			//prueba
			/*$datosSalida['12259'] = array('TITULO'=>'MICROECONOMIA 3');
			$datosSalida['33154'] = array('TITULO'=>'COMPL MICROECONOMIA 3');
			$datosSalida['40228'] = array('TITULO'=>'COMUNICACIONES');
			$datosSalida['42484'] = array('TITULO'=>'COMPL COMUNICACIONES');*/

            return $datosSalida;
        }
    }

    public function esMagistral($crn,$periodo){
        if(empty ($crn)||empty ($periodo)){
            return false;
        }else{
            $periodo = max(explode(",", $periodo));
            // echo "M".$periodo."-";
            $datosSalida=array();
            $this->_db = new ociInteractor();
            $variablesEntrada=array('crn'=>$crn,'periodo'=>$periodo);
            $variablesSalida=array('nombres','apellidos','program','doblePrograma','creditosInscritosSemestreActual','opcion','pga','ssc');
            //$resultado=$this->_db->ejecutar_consulta("select PKG_CONFLICTO.F_MAGISTRAL_COMPL ($crn,'$periodo') from dual");
            $resultado=$this->_db->ejecutar_consulta("select PKG_CONFLICTO.F_CORREQUISITO_M_C ($crn,'$periodo') from dual");
            //echo "select PKG_CONFLICTO.F_MAGISTRAL_COMPL ($crn,'$periodo') from dual<br>";
            $datosRegistro=explode(";", $resultado[0][0]);

            foreach ($datosRegistro as $fila) {
                if(!empty ($fila)){
                    //$nombreMateria=$this->_db->ejecutar_consulta("select titulo from cartelera_conflicto where crn=$fila");
                    //$datosSalida[$fila]=$nombreMateria[0][0];
                    $nombreMateria=$this->_db->ejecutar_consulta("select crn ,materia||curso as materia,seccion,titulo,profesor_1||','||profesor_2||','||profesor_3 as profesores, atributo_curso from cartelera_conflicto where crn=$fila");
                    if(is_array($nombreMateria)){
                        foreach ($nombreMateria as $registro) {
                            if (substr($registro['PROFESORES'], -4)==", , ")$registro['PROFESORES']=str_replace(", , ", "", $registro['PROFESORES']);
                            if (substr($registro['PROFESORES'], -1)==",")$registro['PROFESORES']=substr_replace($registro['PROFESORES'],"",-1);
                            if (substr($registro['PROFESORES'], -2)==", ")$registro['PROFESORES']=substr_replace($registro['PROFESORES'],"",-2);
                        }
                        $datosSalida[$fila]=$registro;
                    }
                }
            }
            if(count($datosSalida)>0){
                return $datosSalida;
            }  else {
                return FALSE;
            }
        }
    }

    public function magistrales($materia,$crn){

        $whereCrn = '';
        foreach ($crn as $key => $value) {
            $whereCrn .= "AND CRN != '" .$crn[$key]. "' ";
        }

        $periodo = max(explode(",", $periodo));
        $datosSalida=array();
        $this->_db = new ociInteractor();
        $nombreMateria=$this->_db->ejecutar_consulta("select crn ,materia||curso as materia,seccion,titulo,profesor_1||','||profesor_2||','||profesor_3 as profesores from cartelera_conflicto where materia||CURSO='$materia' ".$whereCrn.'ORDER BY crn asc');
        if(is_array($nombreMateria)){
            foreach ($nombreMateria as $registro) {
                if (substr($registro['PROFESORES'], -4)==", , ")$registro['PROFESORES']=str_replace(", , ", "", $registro['PROFESORES']);
                if (substr($registro['PROFESORES'], -1)==",")$registro['PROFESORES']=substr_replace($registro['PROFESORES'],"",-1);
                if (substr($registro['PROFESORES'], -2)==", ")$registro['PROFESORES']=substr_replace($registro['PROFESORES'],"",-2);
                $datosSalida[$registro['CRN']]=$registro;
            }
        }
        if(count($datosSalida)>0){
            return $datosSalida;
        }  else {
            return false;
        }
    }
    public function alternativas($materia,$crn,$nombre){
        
        $whereCrn = '';
        foreach ($crn as $key => $value) {
            $whereCrn .= "AND CRN != '" .$crn[$key]. "' ";
        }

    	$periodo = max(explode(",", $periodo));
    	$datosSalida=array();
        $this->_db = new ociInteractor();
        $nombreMateria=$this->_db->ejecutar_consulta("select crn ,materia||curso as materia,seccion,titulo,profesor_1||','||profesor_2||','||profesor_3 as profesores from cartelera_conflicto where materia||CURSO='$materia' ".$whereCrn.'ORDER BY crn asc');
        if(is_array($nombreMateria)){
    		foreach ($nombreMateria as $registro) {
    			if (substr($registro['PROFESORES'], -4)==", , ")$registro['PROFESORES']=str_replace(", , ", "", $registro['PROFESORES']);
    			if (substr($registro['PROFESORES'], -1)==",")$registro['PROFESORES']=substr_replace($registro['PROFESORES'],"",-1);
    			if (substr($registro['PROFESORES'], -2)==", ")$registro['PROFESORES']=substr_replace($registro['PROFESORES'],"",-2);
                $datosSalida[$registro['CRN']]=$registro;
    		}
    	}
        if(count($datosSalida)>0){
            return $datosSalida;
        }  else {
            return false;
        }
    }
    public function esComplementaria($crn,$periodo){
        if(empty ($crn)||empty ($periodo)){
            return false;
        }else{
			$periodo = max(explode(",", $periodo));
			// echo "C".$periodo."-";
			$datosSalida=array();
            $this->_db = new ociInteractor();
            $variablesEntrada=array('crn'=>$crn,'periodo'=>$periodo);
            $variablesSalida=array('nombres','apellidos','program','doblePrograma','creditosInscritosSemestreActual','opcion','pga','ssc');
            //$resultado=$this->_db->ejecutar_consulta("select PKG_CONFLICTO.F_COMPLEMENTARIA_MAG($crn,'$periodo') from dual");
			$resultado=$this->_db->ejecutar_consulta("select PKG_CONFLICTO.F_CORREQUISITO_C_M($crn,'$periodo') from dual");
            $datosRegistro=explode(";", $resultado[0][0]);
            foreach ($datosRegistro as $fila) {
                if(!empty ($fila)){
                    $nombreMateria=$this->_db->ejecutar_consulta("select titulo from cartelera_conflicto where crn=$fila");
                    $datosSalida[$fila]=$nombreMateria[0][0];
                }
            }
            if(count($datosSalida)>0){
                return $datosSalida;
            }  else {
                return FALSE;
            }
        }

    }
    public function vistaMinicartelera($filtros=null,$inicio=0,$registros=10,$campo_orden='crn',$orden='asc', $titulo='')
    {

            $extraQuery='';
            $or_profesores='no';
            $periodo = @$_POST["periodo"];
            // echo $periodo;
            $this->_db = new ociInteractor();
            if(count($filtros)>0){
                $and=$extraQuery='';
                $extraQ=array();
                $busquedaLike=explode(",",BUSQUEDAS_LIKE);
                foreach ($filtros as $indice => $valor) {
                    $like=(in_array($indice, $busquedaLike))?'LIKE':'=';
                    $likeFill=(in_array($indice, $busquedaLike))?'%':'';
                    if(strlen($valor)>0 && $valor!='0'){
                        if($indice=='PROFESOR_1' || $indice=='PROFESOR_2' || $indice=='PROFESOR_3'){
                            $or_profesores = 'si';
                            $valor_profesores[$indice] = $valor;
                        }
                        else{
                            if($indice==OPCION21){ //programa
                                //elimina prefijos para hacer igual MATERIA y programa
                                $valores = explode('-', $valor);
                                $valorprog = $valores[count($valores) - 1];
                                $extraQ[] ="$indice $like '$likeFill".strtoupper($valorprog)."$likeFill'";


                            }
                            //Para cambio de secci?n CRN Inscripci?n debe tener el mismo t?tulo que CRN Retiro
                            elseif($indice=='TITULO_RET'){
                                $extraQ[] ="TITULO='$valor'";
                            }elseif($indice=='CRN__RET'){
                                $qry = "select COMPLEMENTARIAS,crn ,materia||curso as materia,seccion,titulo,profesor_1||','||profesor_2||','||profesor_3 as profesores, atributo_curso FROM cartelera_conflicto WHERE COMPLEMENTARIAS LIKE ';%$valor%' AND PERIODO='".$periodo."' ORDER BY $campo_orden $orden";
                                $rr = $this->_db->ejecutar_consulta($qry);

                                $op = "";
                                if($rr!=""){
                                    $esMag = $this->_db->ejecutar_consulta("select PKG_CONFLICTO.F_CORREQUISITO_M_C ('".$rr[0]["CRN"]."','".$periodo."') from dual");
                                    $esMag = trim(@$esMag[0][0],";");
                                    if($esMag && $valor!=$esMag){
                                        $esMag = "'".str_replace(";", "','", $esMag)."'";
                                        $op = "CRN IN ($esMag)";
                                    }
                                }
//                                $extraQ[] = $op ? $op : "COMPLEMENTARIAS LIKE '%$valor%'";
                                $extraQ[] = $op ? $op : "";
                            }
                            else
                                $extraQ[] ="$indice $like '$likeFill".strtoupper($valor)."$likeFill'";
                        }

                        if($indice==OPCION21){ //programa busca tambien por nivel
                            $niveles= @$this->programasActivosNiveles();
                            $nivel = $niveles[$valor];
                            $num_nivel = '';
                            switch (strtoupper($nivel)) {
                                case 'PR':
                                    $num_nivel = '123';
                                    break;
                                case 'MA':
                                    $num_nivel = '4';
                                    break;
                                case 'ES':
                                    $num_nivel = '5';
                                    break;
                                case 'DO':
                                    $num_nivel = '6';
                                    break;
                            }
                            $extraQ[] = $num_nivel=='123' ? "(CURSO like '1%' or CURSO like '2%' or CURSO like '3%')" : "CURSO like '$num_nivel%'";
                        }
                    }
                }
                $conector_profesores = 'where';
                $extraQ[] = "PERIODO='$periodo'";
                if(count($extraQ)>0){
                    $extraQuery=" where ";
                    $conector_profesores = 'and';
                    $extraQuery.= implode(" and ", $extraQ);
                }
                if($or_profesores=='si'){
                    //$extraQuery .= $extraQ!='' ? ' and' : '';
                    $extraQuery .= " ".$conector_profesores." (profesor_1 LIKE '%".strtoupper($valor_profesores['PROFESOR_1'])."%' or profesor_2 LIKE '%".strtoupper($valor_profesores['PROFESOR_2'])."%' or profesor_3 LIKE '%".strtoupper($valor_profesores['PROFESOR_3'])."%')";
                }
            }
            // echo "<pre>";
            // print_r($extraQuery);
            // echo "</pre>";
            if($extraQuery==""){
                $extraQuery = " where periodo='$periodo'";
            }
            $datosSalida=array();

            // $query="select crn,crn ,materia||curso as materia,seccion,titulo,profesor_1||','||profesor_2||','||profesor_3 as profesores from cartelera_conflicto $extraQuery order by $campo_orden $orden";


/*
            $qry = "select crn ,materia||curso as materia,seccion,titulo,profesor_1||','||profesor_2||','||profesor_3 as profesores, atributo_curso, PARTE_PERIODO from cartelera_conflicto".$extraQuery." order by $campo_orden $orden";
*/
              $qry = "select crn ,materia||curso as materia,seccion,titulo,profesor_1||','||profesor_2||','||profesor_3 as profesores, atributo_curso, lista_cruzada from cartelera_conflicto".$extraQuery." order by $campo_orden $orden";


            // echo "<b style='color: #FF0000'>".$qry."</b>";
            $resultado=$this->_db->ejecutar_consulta($qry,$inicio,$registros);


            //echo (string)$this->_db->last_query();
            //echo "select crn ,materia||curso as materia,seccion,titulo,profesor_1||','||profesor_2||','||profesor_3 as profesores from cartelera_conflicto".$extraQuery." order by $campo_orden $orden<br>";
            $cantidadRespuesas=$this->_db->ejecutar_consulta("select count(crn) from cartelera_conflicto $extraQuery order by $campo_orden $orden");
            $datosSalida=array();
            //echo "select count(crn) from cartelera_conflicto $extraQuery order by $campo_orden $orden<br>";
            if(is_array($resultado)){
                foreach ($resultado as $registro) {
				
                    if (substr($registro['PROFESORES'], -4)==", , ")$registro['PROFESORES']=str_replace(", , ", "", $registro['PROFESORES']);
                    if (substr($registro['PROFESORES'], -1)==",")$registro['PROFESORES']=substr_replace($registro['PROFESORES'],"",-1);
                    if (substr($registro['PROFESORES'], -2)==", ")$registro['PROFESORES']=substr_replace($registro['PROFESORES'],"",-2);                          $datosSalida[]=$registro;
                }
            }
            array_unshift($datosSalida,$cantidadRespuesas[0][0]);
            return $datosSalida;
    }
    public function vistaMinicartelera2($filtros=null,$inicio=0,$registros=10,$campo_orden='crn',$orden='asc', $titulo='')
    {
            $extraQuery='';
			$or_profesores='no';
			$periodo = @$_POST["periodo"];
			// echo $periodo;
			$this->_db = new ociInteractor();
            if(count($filtros)>0){
                $and=$extraQuery='';
                $extraQ=array();
                $busquedaLike=explode(",",BUSQUEDAS_LIKE);
                foreach ($filtros as $indice => $valor) {
                    $like=(in_array($indice, $busquedaLike))?'LIKE':'=';
                    $likeFill=(in_array($indice, $busquedaLike))?'%':'';
                    if(strlen($valor)>0 && $valor!='0'){
						if($indice=='PROFESOR_1' || $indice=='PROFESOR_2' || $indice=='PROFESOR_3'){
							$or_profesores = 'si';
							$valor_profesores[$indice] = $valor;
						}
						else{
							if($indice==OPCION21){ //programa
								//elimina prefijos para hacer igual MATERIA y programa
								$valores = explode('-', $valor);
								$valorprog = $valores[count($valores) - 1];
								$extraQ[] ="$indice $like '$likeFill".strtoupper($valorprog)."$likeFill'";
							}
							//Para cambio de secci?n CRN Inscripci?n debe tener el mismo t?tulo que CRN Retiro
							elseif($indice=='TITULO_RET'){
								$extraQ[] ="TITULO='$valor'";
							}elseif($indice=='CRN__RET'){
								$qry = "select crn ,materia||curso as materia,seccion,titulo,profesor_1||','||profesor_2||','||profesor_3 as profesores FROM cartelera_conflicto WHERE COMPLEMENTARIAS LIKE ';%$valor%' AND PERIODO='".$periodo."' ORDER BY $campo_orden $orden";
								$rr = $this->_db->ejecutar_consulta($qry);
								$op = "";
								if($rr!=""){
									$esMag = $this->_db->ejecutar_consulta("select PKG_CONFLICTO.F_CORREQUISITO_M_C ('".$rr[0]["CRN"]."','".$periodo."') from dual");
									$esMag = trim(@$esMag[0][0],";");
									if($esMag && $valor!=$esMag){
										$esMag = "'".str_replace(";", "','", $esMag)."'";
										$op = "CRN IN ($esMag)";
									}
								}
								$extraQ[] = $op ? $op : "COMPLEMENTARIAS LIKE '%$valor%'";
							}
							else
								$extraQ[] ="$indice $like '$likeFill".strtoupper($valor)."$likeFill'";
						}

						if($indice==OPCION21){ //programa busca tambien por nivel
							$niveles= @$this->programasActivosNiveles();
							$nivel = $niveles[$valor];
							$num_nivel = '';
							switch (strtoupper($nivel)) {
								case 'PR':
									$num_nivel = '123';
									break;
								case 'MA':
									$num_nivel = '4';
									break;
								case 'ES':
									$num_nivel = '5';
									break;
								case 'DO':
									$num_nivel = '6';
									break;
							}
							$extraQ[] = $num_nivel=='123' ? "(CURSO like '1%' or CURSO like '2%' or CURSO like '3%')" : "CURSO like '$num_nivel%'";
						}
                    }
                }
				$conector_profesores = 'where';
				$extraQ[] = "PERIODO='$periodo'";
                if(count($extraQ)>0){
                    $extraQuery=" where ";
					$conector_profesores = 'and';
                    $extraQuery.= implode(" and ", $extraQ);
                }
				if($or_profesores=='si'){
					//$extraQuery .= $extraQ!='' ? ' and' : '';
					$extraQuery .= " ".$conector_profesores." (profesor_1 LIKE '%".strtoupper($valor_profesores['PROFESOR_1'])."%' or profesor_2 LIKE '%".strtoupper($valor_profesores['PROFESOR_2'])."%' or profesor_3 LIKE '%".strtoupper($valor_profesores['PROFESOR_3'])."%')";
				}
            }
			// echo "<pre>";
			// print_r($extraQuery);
			// echo "</pre>";
			if($extraQuery==""){
				$extraQuery = " where periodo='$periodo'";
			}
            $datosSalida=array();

            // $query="select crn,crn ,materia||curso as materia,seccion,titulo,profesor_1||','||profesor_2||','||profesor_3 as profesores from cartelera_conflicto $extraQuery order by $campo_orden $orden";



			$qry = "select crn ,materia||curso as materia,seccion,titulo,profesor_1||','||profesor_2||','||profesor_3 as profesores from cartelera_conflicto".$extraQuery." order by $campo_orden $orden";
			// echo "<b style='color: #FF0000'>".$qry."</b>";
			$resultado=$this->_db->ejecutar_consulta($qry,$inicio,$registros);
			//echo (string)$this->_db->last_query();
			//echo "select crn ,materia||curso as materia,seccion,titulo,profesor_1||','||profesor_2||','||profesor_3 as profesores from cartelera_conflicto".$extraQuery." order by $campo_orden $orden<br>";
			$cantidadRespuesas=$this->_db->ejecutar_consulta("select count(crn) from cartelera_conflicto $extraQuery order by $campo_orden $orden");
			$datosSalida=array();
            //echo "select count(crn) from cartelera_conflicto $extraQuery order by $campo_orden $orden<br>";
			if(is_array($resultado)){
		        foreach ($resultado as $registro) {
		            if (substr($registro['PROFESORES'], -4)==", , ")$registro['PROFESORES']=str_replace(", , ", "", $registro['PROFESORES']);
		            if (substr($registro['PROFESORES'], -1)==",")$registro['PROFESORES']=substr_replace($registro['PROFESORES'],"",-1);
		            if (substr($registro['PROFESORES'], -2)==", ")$registro['PROFESORES']=substr_replace($registro['PROFESORES'],"",-2);        		          $datosSalida[]=$registro;
		        }
            }
            array_unshift($datosSalida,$cantidadRespuesas[0][0]);
            return $datosSalida;
    }
    public function obtenerTitulosMaterias(){
        $this->_db = new ociInteractor();
        $resultado=$this->_db->ejecutar_consulta("select titulo from cartelera_conflicto");
        return $resultado;
    }
	public function obtenerTituloMateria($crn){
        $this->_db = new ociInteractor();
        $resultado=$this->_db->ejecutar_consulta("select titulo from cartelera_conflicto where crn=$crn");
        return $resultado;
    }

    public function obtenerMaterias(){
        $this->_db = new ociInteractor();
        $resultado=$this->_db->ejecutar_consulta("select materia||curso as materia from cartelera_conflicto");
        return $resultado;
    }
    public function existenSuspensionesDisciplinarias($pidm){
        if(empty ($pidm)){
            return false;
        }else{
	    $datosSalida=array();
            $this->_db = new ociInteractor();
            $resultado=$this->_db->ejecutar_consulta("select PKG_CONFLICTO.F_SUSPENSIONES_DISCIPLINARIAS($pidm) from dual");
            $datosSalida= ($resultado[0][0]=='Y')?FALSE:TRUE;
            return $datosSalida;
        }
    }
    public function existenSuspensionesAcademicas($pidm){
        if(empty ($pidm)){
            return false;
        }else{
	    $datosSalida=array();
            $this->_db = new ociInteractor();
            $resultado=$this->_db->ejecutar_consulta("select PKG_CONFLICTO.F_T_SUSPENSION_ACADEMICA($pidm) from dual");
            $datosSalida= ($resultado[0][0]=='Y')?FALSE:TRUE;
            return $datosSalida;
        }
    }
    public function existenRestricciones($pidm){ //aclarar si F_RETENCION_HORARIO si es la funcion correspondiente
        if(empty ($pidm)){
            return false;
        }else{
			$datosSalida=array();
            $this->_db = new ociInteractor();
            $resultado=$this->_db->ejecutar_consulta("select PKG_CONFLICTO.F_RETENCION_HORARIO($pidm) from dual");
            $datosSalida= ($resultado[0][0]=='Y')?FALSE:TRUE;
            return $datosSalida;
        }
    }

    public function turnoGalpon($pidm,$periodo, $fecha_fin='', $galp='1'){
//        --201688;28/06/11;08:00;07/10/11;18:00;28_0800
        if(empty ($pidm)||empty ($periodo)){
            return false;
        }else{
			$periodo = max(explode(",", $periodo));
            $this->_db = new ociInteractor();
            $resultado=$this->_db->ejecutar_consulta("select PKG_CONFLICTO.F_TURNO_CONFLICTO($pidm,'$periodo') from dual");
            $datosRegistro=explode(";", $resultado[0][0]);
			//print_r($resultado);
        }
        if(count($datosRegistro)>0 && $resultado[0][0]!=''/**asegura que la bd no retorne null*/){
            $arrayIndices=array('codEstudiante','fechaInicio','horaInicio','fechaFin','horaFin','tanda');
			//print_r($arrayIndices);
			//print_r($datosRegistro);
            $arrayRetorno=array_combine($arrayIndices, $datosRegistro);
            $fechaInicio=strtotime($arrayRetorno['fechaInicio']." ".$arrayRetorno['horaInicio']);
            $fechaActual=strtotime(date('Y-m-d H:i'/*'d/m/y H:i'*/));
            $fechaFin=strtotime($arrayRetorno['fechaFin']." ".$arrayRetorno['horaFin']);

			//datos de prueba
			/*$fechaInicio = strtotime('2012-01-05 11:00');
			$fechaActual = strtotime('2012-01-04 11:35');
			$fechaFin = strtotime('2012-01-05 14:00');*/

			//si recibe fecha_fin compara con esta en lugar de la del galp?n
			if($fecha_fin!='')
				$fechaFin=strtotime($fecha_fin);
			//si no valida turno galp?n la fecha inicial no limita
			if($galp=='0')
				$fechaInicio=$fechaActual;

			//echo "pidm $pidm, periodo $periodo, result ".(($fechaInicio<=$fechaActual)&&($fechaActual<=$fechaFin)).",galp $galp, fecha_fin ".strtotime($fecha_fin)."->$fecha_fin, fechaInicio $fechaInicio->".date('Y-m-d H:i', $fechaInicio).", fechaActual $fechaActual->".date('Y-m-d H:i', $fechaActual).", fechaFin $fechaFin->".date('Y-m-d H:i', $fechaFin).", fechaInicioGalpon ".$arrayRetorno['fechaInicio']." ".$arrayRetorno['horaInicio'].", fechaFinGalpon ".$arrayRetorno['fechaFin']." ".$arrayRetorno['horaFin'];
            return (($fechaInicio<=$fechaActual)&&($fechaActual<=$fechaFin));
        }  else {
			//no obtiene turno galpï¿½n de la bd, solo puede entrar por fecha final------------------------------
			//si recibe fecha_fin compara con esta en lugar de la del galp?n
			if($fecha_fin!='' && $galp=='0'){
				$fechaActual=strtotime(date('Y-m-d H:i'/*'d/m/y H:i'*/));
				$fechaFin=strtotime($fecha_fin);
				//si no valida turno galp?n la fecha inicial no limita
				$fechaInicio=$fechaActual;
				//echo "pidm $pidm, periodo $periodo, result ".(($fechaInicio<=$fechaActual)&&($fechaActual<=$fechaFin)).",galp $galp, fecha_fin ".strtotime($fecha_fin)."->$fecha_fin, fechaInicio $fechaInicio->".date('Y-m-d H:i', $fechaInicio).", fechaActual $fechaActual->".date('Y-m-d H:i', $fechaActual).", fechaFin $fechaFin->".date('Y-m-d H:i', $fechaFin).", fechaInicioGalpon ".$arrayRetorno['fechaInicio']." ".$arrayRetorno['horaInicio'].", fechaFinGalpon ".$arrayRetorno['fechaFin']." ".$arrayRetorno['horaFin'];
				return (($fechaInicio<=$fechaActual)&&($fechaActual<=$fechaFin));
			}
			else
			//--------------------------------------------------------------------------------------------------
				return false;
        }


    }


    public function programasActivos(){
		if(PROGRAMAS_MYSQL=='1'){
			//$CI =& get_instance();
			//$CI->load->model('Departamento_model','Departamento_model_programasActivos',TRUE);
			//$retorno = $CI->Departamento_model_programasActivos->programasActivos();
			$retorno = $this->CI->Departamento_model->programasActivos();
			//unset($CI->Departamento_model_programasActivos); //este era el unico descomentado
			$arrayProgramas=array();
			foreach ($retorno as $row) {
				$arrayProgramas[$row['swtprnl_program']]=$row['swtprnl_program_desc'];
			}
			//print_r($arrayProgramas);
			return $arrayProgramas;
		}

        $this->_db = new ociInteractor();
        $retorno= $this->_db->ejecutar_consulta("select distinct swtprnl_program,swtprnl_program_desc from vista_programas_act where swtprnl_prog_activo_ind = 'Y' ORDER BY swtprnl_program_desc ASC");

        $arrayProgramas=array();
        foreach ($retorno as $row) {
            //$arrayProgramas[$row[0]]= strtr(ucfirst(strtolower($row[1])),utf8_encode("???????????????????????????"),utf8_encode("???????????????????????????"));
			$arrayProgramas[$row[0]]= strtr(ucfirst(mb_strtolower($row[1], 'UTF-8')),utf8_encode("ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½"),utf8_encode("ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½"));
        }
		//print_r($arrayProgramas);
        return $arrayProgramas;
    }

	public function programasActivosNiveles(){
		if(PROGRAMAS_MYSQL=='1'){
			//$CI =& get_instance();
			//$CI->load->model('Departamento_model','Departamento_model_programasActivosNiveles',TRUE);
			//$retorno = $CI->Departamento_model_programasActivosNiveles->programasActivosNiveles();
			$retorno = $this->CI->Departamento_model->programasActivosNiveles();
			//unset($CI->Departamento_model_programasActivosNiveles);;
			$arrayProgramas=array();
			foreach ($retorno as $row) {
				$arrayProgramas[$row['swtprnl_program']]=ucfirst(strtolower($row['swtprnl_levl_code']));
			}
			//print_r($arrayProgramas);
			return $arrayProgramas;
		}

        $this->_db = new ociInteractor();
        $retorno= $this->_db->ejecutar_consulta("select distinct swtprnl_program,swtprnl_levl_code from vista_programas_act where swtprnl_prog_activo_ind = 'Y'");
        $arrayProgramas=array();
        foreach ($retorno as $row) {
            $arrayProgramas[$row[0]]= strtr(ucfirst(strtolower($row[1])),utf8_encode("ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½"),utf8_encode("ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½"));
        }
		//print_r($arrayProgramas);
        return $arrayProgramas;
    }

    public function obtenerPrograma($programaId){
		if(PROGRAMAS_MYSQL=='1'){
			//$CI =& get_instance();
			//$CI->load->model('Departamento_model','Departamento_model_obtenerPrograma2',TRUE);
			//$retorno = $CI->Departamento_model_obtenerPrograma2->obtenerPrograma($programaId);
			$retorno = $this->CI->Departamento_model->obtenerPrograma($programaId);
			//unset($CI->Departamento_model_obtenerPrograma2);
			return $retorno;
		}
        if(empty ($programaId)){
            return "Sin departamento";//"El c?digo de programa no puede ser vac?o";
        }  else {
            $this->_db = new ociInteractor();
            $retorno= $this->_db->ejecutar_consulta("select swtprnl_program_desc from vista_programas_act where swtprnl_program = upper('".$programaId."')");
			if(is_array($retorno)){
				if($retorno[0][0]!='')
					return $retorno[0][0];
				else
					return "Sin departamento";
			}
			else
				return "Sin departamento";
        }
    }

    public function obtenerPidm($codigo){
        if(empty ($codigo)){
            throw new Exception("El código no puede ser vacio");
            return "El código no puede ser vacio";
        }  else {
            $this->_db = new ociInteractor();
            $variablesEntrada=array('codigo'=>$codigo);
            $variablesSalida=array('pidm');
            $pidm=$this->_db->ejecutar_procedure('PKG_COMUN.F_PIDM', $variablesEntrada, $variablesSalida);
			if($pidm['pidm'])
				return $pidm['pidm'];
			else
				return '';
       }
    }

	public function obtenerCodigoActual($login){
	}

        public function getAutocomplete($term,$prog=null,$periodo = ""){
            if(empty($term))
                    return false;
            else{
                $this->_db = new ociInteractor();
                $extraQuery=($prog==null || $prog=='0')?"":" and materia in ('$prog')";
                $extraQuery .= $periodo ? " AND periodo = '" . $periodo . "'" : "";
                $query="select crn||' - '||materia||curso||' - ' ||titulo as value,crn,materia||curso as materia,seccion,titulo from cartelera_conflicto where crn like '".$term."%'".$extraQuery;
                $resultado=$this->_db->ejecutar_consulta($query);
                return $resultado;
            }

        }

        public function materiasPorDepto($depto){
            if(empty($depto))
                    return false;
            else{
                $this->_db = new ociInteractor();
                $query="select distinct(materia),curso,titulo from cartelera_conflicto where materia='".$depto."'";
                $resultado=$this->_db->ejecutar_consulta($query);
                return $resultado;
            }
        }
	function randomColor() {
		$str = '#';
		for($i = 0 ; $i < 6 ; $i++) {
			$randNum = rand(0 , 15);
			switch ($randNum) {
				case 10: $randNum = 'A'; break;
				case 11: $randNum = 'B'; break;
				case 12: $randNum = 'C'; break;
				case 13: $randNum = 'D'; break;
				case 14: $randNum = 'E'; break;
				case 15: $randNum = 'F'; break;
			}
			$str .= $randNum;
		}
		return $str;
	}

	function color_inverse($color){
		$color = str_replace('#', '', $color);
		if (strlen($color) != 6){ return '000000'; }
		$rgb = '';
		for ($x=0;$x<3;$x++){
			$c = 255 - hexdec(substr($color,(2*$x),2));
			$c = ($c < 0) ? 0 : dechex($c);
			$rgb .= (strlen($c) < 2) ? '0'.$c : $c;
		}
		return '#'.$rgb;
	}

	public function horario_estudiantes($pidm, $periodo, $nombre, $apellido, $materias){
		$this->_db = new ociInteractor();
		$query="SELECT PKG_CONFLICTO.F_HORARIO_ALUMNOS('$pidm','$periodo') FROM dual";
		$i=$this->_db->ejecutar_consulta($query);


		$datos = explode(";".$periodo.";",@$i[0][0]);
		$html = "<style>";
		$html .= "*{font-family: Arial; padding: 3px;} table{border: #CCC solid 1px; background-color: #F2F2F2; } table thead td{font-weight: bold; text-align: center; background-color: #444; color: #FFF;}";
		$html .= "</style>";
		$html .= "<h2>HORARIO</h2>";
		$html .= "<h3>".$nombre." ".$apellido." [<small>Periodo: </small><small style='color: #FF0000'>$periodo</small>]</h3>";
		$rango_min = 30;
		$hora_ini = date("Y-m-d")." 06:30";
		$hora_fin = date("Y-m-d")." 21:00";
		$horas = array();
		$dias = explode(",","D,L,M,I,J,V,S");
		while($hora_ini < $hora_fin){
			$hora_ini = date("Y-m-d H:i",mktime(date("H", strtotime($hora_ini)), date("i", strtotime($hora_ini))+$rango_min,0,date("m"),date("d"), date("Y")));
			$horas[] = date("Hi", strtotime($hora_ini));
		}

        $hSolicitud = $this->horariosSolicitud($materias,$periodo);
        $datos = array_merge($datos,$hSolicitud);

        $horario = $datos;
		$_h = array();
		$j = 0;
        $cruze = array();
		foreach($horario as $h){
			$d = explode(";", $h);
			for($k=5;$k<count($d);$k++){
				if(@$d[$k]!=""){
					$h_ini = @$d[3];
					$h_fin = @$d[4];
					$color=$this->randomColor();
					while($h_ini <= $h_fin){
                        if (count($_h[array_search($h_ini,$horas)][array_search(@$d[$k],$dias)])>0)
                        {   if (@$d[13] != 'Retiro') {

                            $codigoTmp = $_h[array_search($h_ini,$horas)][array_search(@$d[$k],$dias)]["codigo"];
                            $crnTmp = $_h[array_search($h_ini,$horas)][array_search(@$d[$k],$dias)]["crn"];
                            $_h[array_search($h_ini,$horas)][array_search(@$d[$k],$dias)]["crn"] =  $codigoTmp . " - " . $crnTmp . " <br> " . @$d[1]." - ". @$d[2];
                            $_h[array_search($h_ini,$horas)][array_search(@$d[$k],$dias)]["codigo"] = "<i>Conflicto</i>";
                            $_h[array_search($h_ini,$horas)][array_search(@$d[$k],$dias)]["color"] = "#FF0000";
                            $_h[array_search($h_ini,$horas)][array_search(@$d[$k],$dias)]["solicitud"] = @$d[12];
                            $cruze[array_search($h_ini,$horas)][array_search(@$d[$k],$dias)] = "cruze";
                            }
                            

                        }else
                        {
    						$_h[array_search($h_ini,$horas)][array_search(@$d[$k],$dias)]["codigo"] = @$d[1];
    						$_h[array_search($h_ini,$horas)][array_search(@$d[$k],$dias)]["crn"] = @$d[2];
    						$_h[array_search($h_ini,$horas)][array_search(@$d[$k],$dias)]["color"] = $color;
                            $_h[array_search($h_ini,$horas)][array_search(@$d[$k],$dias)]["solicitud"] = @$d[12];
                        }

						$h_ini = date("Y-m-d H:i",mktime(date("H", strtotime($h_ini)), date("i", strtotime($h_ini))+$rango_min,0,date("m"),date("d"), date("Y")));
						$h_ini = date("Hi", strtotime($h_ini));

					}
				}
			}
			$j++;
		}
		$horario = $_h;

		$html .= "<table border='0' width='100%' style='font-size: 9px'>";
		$html .= "<thead>";
		$html .= "<tr>";
		if(count($datos)>1){
			$html .= "<td>HORA</td>";
			// $html .= "<td>DOMINGO</td>";
			$html .= "<td>LUNES</td>";
			$html .= "<td>MARTES</td>";
			$html .= "<td>MIERCOLES</td>";
			$html .= "<td>JUEVES</td>";
			$html .= "<td>VIERNES</td>";
			$html .= "<td>SABADO</td>";
		}else{
			$html .= "<td>No se encontr&oacute; el horario para el per&iacute;odo indicado.</td>";
		}
		$html .= "</tr>";
		$html .= "</thead>";
        $img=(AMBIENTE_PRUEBAS=='1')?$_SERVER['SERVER_NAME']."/css/images/advertencia.png":$_SERVER['SERVER_NAME']."/css/images/advertencia.png";
        $img_cruce=(AMBIENTE_PRUEBAS=='1')?$_SERVER['SERVER_NAME']."/css/images/cruce.fw.png":$_SERVER['SERVER_NAME']."/css/images/cruce.fw.png";
        $img_cal=(AMBIENTE_PRUEBAS=='1')?$_SERVER['SERVER_NAME']."/css/images/add_to_cal.png":$_SERVER['SERVER_NAME']."/css/images/add_to_cal.png";
		if(count($datos)>1){
			$r = 0;
			for($k=0; $k<count($horas)-1; $k++){
				$html .= "<tr style='background-color: ".($r++ % 2 ? "#CCC" : "#FFF")."'>";
				$html .= "<td align='center'>".$this->styleTime($horas[$k])." a ".$this->styleTime(@$horas[$k+1])."</td>";
				// $html .= "<td align='center'></td>";
				for($a=1; $a<7;$a++){
                    if (isset($cruze[$k][$a])) {
                        $icon = '<img style="position:absolute;left:0;width: 25px;" src="http://' . $img_cruce . '" alt="">';
                    }else{
                        $icon = '';
                    }
                    if ($horario[$k][$a]['solicitud'] == 'solicitud') {
                        $icon2 = '<img style="position:absolute;right:0;width: 18px;" src="http://' . $img_cal . '" alt="">';
                    }else{
                        $icon2 = '';
                    }
					$html .= "<td align='center' ".(@$horario[$k][$a]["color"]!="" ? "style=' position: relative;font-size: 11px; text-shadow: 1px 1px 1px ".$this->color_inverse(@$horario[$k][$a]["color"])."; color: #FFF; font-weight: bold; background: ".@$horario[$k][$a]["color"].";'" : "").">".$icon.$icon2.str_replace(" ","",@$horario[$k][$a]["codigo"])."<br><small>".@$horario[$k][$a]["crn"]."</small>"."</td>";
				}
				$html .= "</tr>";
			}
		}
		$html .= "</table>";

		$html .= "<br>";

		$html .= "<table border='0' style='font-size: 9px' width='100%'>";
		$html .= "<thead>";
		$html .= "<tr>";
		$html .= "<td>CODIGO - CRN</td>";
		$html .= "<td>NOMBRE</td>";
		$html .= "</tr>";
		$html .= "</thead>";
		$html .= "<tbody>";
        $tmp = '';
		foreach($datos as $r=>$l){

            $_d = explode(";",$l);

            if ($_d[0] != $tmp) {
                $tmp = $_d[0];

                $html .= "<tr style='background-color: ".($r++ % 2 ? "#CCC" : "#FFF")."'>";
                
                $html .= "<td>".str_replace(" ","",@$_d[1])." - ".@$_d[2]."</td>";
                $html .= "<td>".@$_d[0]."</td>";
                $html .= "</tr>";
            }

		}
		$html .= "</tbody>";
		$html .= "</table>";
		return $html;
	}

    private function styleTime($time)
    {   
        $time = str_split($time,2);
        return $time[0].":".$time[1];
        
    }

    private function horariosSolicitud($materias,$periodo)
    {
        $parseMaterias = array();
        foreach ($materias as $key => $value) {
            $materias[$key]['datos'] = $this->consultarHorarioCRN($materias[$key]['crn'],$periodo); 
        }



        foreach ($materias as $materia) {
            foreach ($materia['datos'] as $dataMateria) {

            $parseMaterias[] = $dataMateria ['NOMBRE']." -> ".$materia['tipo'].";".
                             "Solicitud: ".$dataMateria ['MATERIA']." ".$dataMateria ['CURSO'].";".
                             $materia['crn'].";".
                             $dataMateria   ['HINI'].";".
                             $dataMateria   ['HFIN'].";".
                             $dataMateria   ['DOMINGO'].";".
                             $dataMateria   ['LUNES'].";".
                             $dataMateria   ['MARTES'].";".
                             $dataMateria   ['MIERCOLES'].";".
                             $dataMateria   ['JUEVES'].";".
                             $dataMateria   ['VIERNES'].";".
                             $dataMateria   ['SABADO'].";solicitud;".
                             $materia['tipo'];
            }


        }
        
        return $parseMaterias;
    }

	public function cupos_magistral_complementaria($crn, $periodo){
		$this->_db = new ociInteractor();
		$query="SELECT PKG_CONFLICTO.F_CUPO_M_C ('$crn','$periodo') FROM dual";
		$resultado=$this->_db->ejecutar_consulta($query);
		return $resultado;
	}

	//Valida si un CRN corresponde a una materia magistral
	public function crnIsMagistral($crn, $periodo)
	{
		$this->_db = new ociInteractor();
		$query="SELECT PKG_CONFLICTO.F_CUPO_M_C ('$crn','$periodo') FROM dual";
		$resultado=$this->_db->ejecutar_consulta($query);
		$strResult = $resultado[0][0];
		if (strpos($strResult,'M'.$crn) === false && strpos($strResult,'N'.$crn) === false) {
			return false;
		} else {
			return true;
		}
	}

	public function cupos_inscritos($crn, $periodo){
		$datos = array();
		if($crn!="" && $periodo!=""){
			$this->_db = new ociInteractor();
			$query="SELECT PKG_CONFLICTO.F_CUPO_INS('$crn','$periodo') FROM dual";
			$i=$this->_db->ejecutar_consulta($query);
			$datos = explode(";",@$i[0][0]);
		}
		return $datos;
	}

	public function obtenerProgramas($periodos){
		$this->_db = new ociInteractor();
		$periodos = @explode(",", $periodos);
		$p1 = $periodos[0] ? $periodos[0] : "000000";
		$p2 = $periodos[1] ? $periodos[1] : "000000";
		//Ajuste realizado porque la funcion oracle falla cuando el resultado sobrepasa los 4000 carácteres-- eamaya- ga.perez
		$query="SELECT PKG_CONFLICTO.F_SUBJ_C_2('$p1','$p2','1') dato FROM dual";
		$query2="SELECT PKG_CONFLICTO.F_SUBJ_C_2('$p1','$p2','2') dato FROM dual";
		$resultado	=	$this->_db->ejecutar_consulta($query);
		$resultado2	=	$this->_db->ejecutar_consulta($query2);
		
		$resultado = $resultado[0]['DATO'].$resultado2[0]['DATO'];
		$resultado = substr($resultado,1,strlen($resultado));
		$resultado = explode(";",$resultado);
		$programas = array();
		foreach($resultado as $r){
			$d = explode(":", $r);
			$programas[$d[0]]["NOMBRE"] = $d[1];
			$programas[$d[0]]["NIVEL"][] = $d[2];
		}
		return $programas;
	}

    public function consultarMateriasCrns($crn){
        $this->_db = new ociInteractor();
        $resultado=$this->_db->ejecutar_consulta("select materia, crn from cartelera_conflicto where crn in (".$crn.") ");
        return $resultado;
    }

    /*
     * consultarHorarioCRN
    */
    public function consultarHorarioCRN($crn,$periodo)
    {
        $this->_db = new ociInteractor();
        $resultado=$this->_db->ejecutar_consulta("SELECT
                                                  l.SSRMEET_BEGIN_TIME                         HINI
                                                  ,l.SSRMEET_END_TIME                          HFIN
                                                  ,REPLACE(l.SSRMEET_SUN_DAY,'U','D')          DOMINGO
                                                  ,REPLACE(l.SSRMEET_MON_DAY,'M','L')          LUNES
                                                  ,REPLACE(l.SSRMEET_TUE_DAY,'T','M')          MARTES
                                                  ,REPLACE(l.SSRMEET_WED_DAY,'W','I')          MIERCOLES
                                                  ,REPLACE(l.SSRMEET_THU_DAY,'R','J')          JUEVES
                                                  ,REPLACE(l.SSRMEET_FRI_DAY,'F','V')          VIERNES
                                                  ,l.SSRMEET_SAT_DAY                           SABADO
                                                  ,c.MATERIA                                   materia
                                                  ,c.TITULO                                    nombre
                                                  ,c.CURSO                                     curso 
												  ,SSRMEET_START_DATE                          fechainicio
                                                  ,SSRMEET_END_DATE                            fechafin												  
                                                  FROM ssrmeet l                                                   
                                                  LEFT JOIN cartelera_conflicto c ON CRN = $crn 
                                                  WHERE ssrmeet_term_code = '$periodo' and ssrmeet_crn = $crn"
                                                );
        return (isset($resultado))?$resultado:false;
    }

    public function dataHorarioEstudiante ($pidm,$periodo)
    {
        $this->_db = new ociInteractor();
        $query="SELECT PKG_CONFLICTO.F_HORARIO_ALUMNOS('$pidm','$periodo') FROM dual";
        $i=$this->_db->ejecutar_consulta($query);
        $datos = explode(";".$periodo.";",@$i[0][0]);
        foreach ($datos as $key => $value) {
            $temparray = explode(';', $value);
            $keys = array('nombremat','codigo','crn','hini','hfin','domingo','lunes','martes','miercoles','jueves','viernes','sabado','fechainicio','fechafin');
            $datos[$key] = array_combine($keys,explode(';', $value));
        }
        return $datos;
    }

    public function crnsRelacionados($crn,$periodo)
    {
        $this->_db = new ociInteractor();
        $query="SELECT PKG_CONFLICTO.F_CUPO_M_C('$crn','$periodo') FROM dual";
        $crnsRelacionados=$this->_db->ejecutar_consulta($query);
        return $crnsRelacionados[0][0];
    }

    public function listarCorrequisitos ($crn_cc)
    {
        $crn_cc = str_replace('-',"','",$crn_cc);
        $crn_cc = "'".str_replace('CC','',$crn_cc)."'";
        $this->_db = new ociInteractor();
        $query="select crn ,materia||curso as materia,seccion,titulo,profesor_1||','||profesor_2||','||profesor_3 as profesores, atributo_curso from cartelera_conflicto where crn in ($crn_cc) ORDER BY crn asc";
        $crnsRelacionados=$this->_db->ejecutar_consulta($query);
        return $crnsRelacionados;
    }

    public function listarCruzes ($crn)
    {   
        $i = 0;
        $where = '(';
        foreach ($crn as $key => $value) {
            if ($i == 0) {
 
                $where .= 'crn = '.$crn[$key]["sol_ins_crn"];

            }else{

                $where .= ' OR crn = '.$crn[$key]["sol_ins_crn"];
            }
            $i++;
 
        }
        $where .= ')';
        $this->_db = new ociInteractor();
        $query="select crn ,materia||curso as materia from cartelera_conflicto where ".$where;
        $materia=$this->_db->ejecutar_consulta($query);
        return $materia;
    }
} 
?>