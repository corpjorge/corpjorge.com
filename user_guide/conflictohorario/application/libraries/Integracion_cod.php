<?php

/**
 * Description of conflictos
 *
 * @author John Jimenez
 */
require_once 'ociInteractor.php';
class integracion {
    private $_db;
    public function integracion(){}
    
    public function proc1 () {
        $this->_db = new ociInteractor();
        $this->_db->ejecutar_procedure($query_procedure, $vector_variables_entrada, $vector_variables_salida);
        
    }
    
    public function datosEstudiante($pidm,$periodo){
        if(empty ($pidm)||empty ($periodo)){
            return false;
        }else{
            $datosSalida=array();
            $this->_db = new ociInteractor();
            $variablesEntrada=array('pidm'=>$pidm,'periodo'=>$periodo);
            $variablesSalida=array('resultado');
            $resultado=$this->_db->ejecutar_consulta("select PKG_CONFLICTO.F_DATOS_ESTUDIANTE ($pidm,'$periodo') from dual");              
            $datosRegistro=explode(";", $resultado[0][0]);
            $datosSalida= explode(",", DATOS_ESTUDIANTE);
            $datosEstudiante=array_combine($datosSalida, $datosRegistro);            
            return $datosEstudiante;
        }
        
    }
    
    public function materiasInscritas($pidm,$periodo){
        if(empty ($pidm)||empty ($periodo)){
            return false;
        }else{
			$datosSalida=array();
            $this->_db = new ociInteractor();
            $variablesEntrada=array('pidm'=>$pidm,'per'=>$periodo);
            $variablesSalida=array('crnInscritos');
            //$retorno=$this->_db->ejecutar_procedure('PKG_CONFLICTO.F_MATERIAS_INSCRITAS', $variablesEntrada, $variablesSalida);
            $resultado=$this->_db->ejecutar_consulta("select PKG_CONFLICTO.F_MATERIAS_INSCRITAS ($pidm,'$periodo') from dual");                          
            $datosRegistro=explode(";", $resultado[0][0]);
            foreach ($datosRegistro as $fila) {
                if(!empty ($fila)){
                    //$nombreMateria=$this->_db->ejecutar_consulta("select titulo from cartelera_conflicto where crn=$fila");   
                    //$datosSalida[$fila]=$nombreMateria[0][0];
					$nombreMateria=$this->_db->ejecutar_consulta("select crn ,materia||curso as materia,seccion,titulo,profesor_1||','||profesor_2||','||profesor_3 as profesores from cartelera_conflicto where crn=$fila");   
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
			$datosSalida=array();
            $this->_db = new ociInteractor();
            $variablesEntrada=array('crn'=>$crn,'periodo'=>$periodo);
            $variablesSalida=array('nombres','apellidos','program','doblePrograma','creditosInscritosSemestreActual','opcion','pga','ssc');
            $resultado=$this->_db->ejecutar_consulta("select PKG_CONFLICTO.F_MAGISTRAL_COMPL ($crn,'$periodo') from dual");
            $datosRegistro=explode(";", $resultado[0][0]);
            
            foreach ($datosRegistro as $fila) {
                if(!empty ($fila)){
					//$nombreMateria=$this->_db->ejecutar_consulta("select titulo from cartelera_conflicto where crn=$fila");   
                    //$datosSalida[$fila]=$nombreMateria[0][0];
                    $nombreMateria=$this->_db->ejecutar_consulta("select crn ,materia||curso as materia,seccion,titulo,profesor_1||','||profesor_2||','||profesor_3 as profesores from cartelera_conflicto where crn=$fila");
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
    public function esComplementaria($crn,$periodo){
        if(empty ($crn)||empty ($periodo)){
            return false;
        }else{
			$datosSalida=array();
            $this->_db = new ociInteractor();
            $variablesEntrada=array('crn'=>$crn,'periodo'=>$periodo);
            $variablesSalida=array('nombres','apellidos','program','doblePrograma','creditosInscritosSemestreActual','opcion','pga','ssc');
            $resultado=$this->_db->ejecutar_consulta("select PKG_CONFLICTO.F_COMPLEMENTARIA_MAG($crn,'$periodo') from dual");
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
    public function vistaMinicartelera($filtros=null,$inicio=0,$registros=10,$campo_orden='titulo',$orden='asc', $titulo=''){            
            $extraQuery='';
			$or_profesores='no';
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
							//Para cambio de secci�n CRN Inscripci�n debe tener el mismo t�tulo que CRN Retiro
							elseif($indice=='TITULO_RET'){
								$extraQ[] ="TITULO='$valor'";
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
            $datosSalida=array();
            $this->_db = new ociInteractor();            
            $query="select crn,crn ,materia||curso as materia,seccion,titulo,profesor_1||','||profesor_2||','||profesor_3 as profesores from cartelera_conflicto $extraQuery order by $campo_orden $orden";            
			$resultado=$this->_db->ejecutar_consulta("select crn ,materia||curso as materia,seccion,titulo,profesor_1||','||profesor_2||','||profesor_3 as profesores from cartelera_conflicto".$extraQuery." order by $campo_orden $orden",$inicio,$registros); 
			//echo "select crn ,materia||curso as materia,seccion,titulo,profesor_1||','||profesor_2||','||profesor_3 as profesores from cartelera_conflicto".$extraQuery." order by $campo_orden $orden";
			$cantidadRespuesas=$this->_db->ejecutar_consulta("select count(crn) from cartelera_conflicto $extraQuery order by $campo_orden $orden");            $datosSalida=array();
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
            $this->_db = new ociInteractor();            
            $resultado=$this->_db->ejecutar_consulta("select PKG_CONFLICTO.F_TURNO_CONFLICTO($pidm,'$periodo') from dual");
            $datosRegistro=explode(";", $resultado[0][0]);
        }
        if(count($datosRegistro)>0){
            $arrayIndices=array('codEstudiante','fechaInicio','horaInicio','fechaFin','horaFin','tanda');
            $arrayRetorno=array_combine($arrayIndices, $datosRegistro);
            $fechaInicio=strtotime($arrayRetorno['fechaInicio']." ".$arrayRetorno['horaInicio']);
            $fechaActual=strtotime(date('Y-m-d H:i'/*'d/m/y H:i'*/));
            $fechaFin=strtotime($arrayRetorno['fechaFin']." ".$arrayRetorno['horaFin']);
			
			//datos de prueba
			/*$fechaInicio = strtotime('2012-01-05 11:00');
			$fechaActual = strtotime('2012-01-04 11:35');
			$fechaFin = strtotime('2012-01-05 14:00');*/
			
			//si recibe fecha_fin compara con esta en lugar de la del galp�n
			if($fecha_fin!='')
				$fechaFin=strtotime($fecha_fin);
			//si no valida turno galp�n la fecha inicial no limita
			if($galp=='0')
				$fechaInicio=$fechaActual;
				
			//echo "pidm $pidm, periodo $periodo, result ".(($fechaInicio<=$fechaActual)&&($fechaActual<=$fechaFin)).",galp $galp, fecha_fin ".strtotime($fecha_fin)."->$fecha_fin, fechaInicio $fechaInicio->".date('Y-m-d H:i', $fechaInicio).", fechaActual $fechaActual->".date('Y-m-d H:i', $fechaActual).", fechaFin $fechaFin->".date('Y-m-d H:i', $fechaFin).", fechaInicioGalpon ".$arrayRetorno['fechaInicio']." ".$arrayRetorno['horaInicio'].", fechaFinGalpon ".$arrayRetorno['fechaFin']." ".$arrayRetorno['horaFin'];
            return (($fechaInicio<=$fechaActual)&&($fechaActual<=$fechaFin));
        }  else {
            return false;
        }      
        
        
    }


    public function programasActivos(){
        $this->_db = new ociInteractor();
        $retorno= $this->_db->ejecutar_consulta("select distinct swtprnl_program,swtprnl_program_desc from vista_programas_act where swtprnl_prog_activo_ind = 'Y'");
        $arrayProgramas=array();
        foreach ($retorno as $row) {
            //$arrayProgramas[$row[0]]= strtr(ucfirst(strtolower($row[1])),utf8_encode("���������������������������"),utf8_encode("���������������������������"));
	    $arrayProgramas[$row[0]]= strtr(ucfirst(mb_strtolower($row[1], 'UTF-8')),utf8_encode("���������������������������"),utf8_encode("���������������������������"));
        }        
        return $arrayProgramas;        
    }
	
	public function programasActivosNiveles(){
        $this->_db = new ociInteractor();
        $retorno= $this->_db->ejecutar_consulta("select distinct swtprnl_program,swtprnl_levl_code from vista_programas_act where swtprnl_prog_activo_ind = 'Y'");
        $arrayProgramas=array();
        foreach ($retorno as $row) {
            $arrayProgramas[$row[0]]= strtr(ucfirst(strtolower($row[1])),utf8_encode("���������������������������"),utf8_encode("���������������������������"));            
        }        
        return $arrayProgramas;        
    }
    
    public function obtenerPrograma($programaId){
        if(empty ($programaId)){
            return "Sin departamento";//"El c�digo de programa no puede ser vac�o";
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
            throw new Exception("El c�digo no puede ser vacio");
            return "El c�digo no puede ser vacio";
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
}
?>
