<?php
//$this->load->view("header");
//echo "<pre>";
//var_dump($registros);
//var_dump($id_input);
echo "</pre>";



?>

<div id="minicartelera">
    <?php
    if($total>0){
    ?>
    <!--<table cellspacing=0 cellpadding="0" width="100%">
        <th class="headerCartelera" colspan="3"><p>Herramienta de Conflictos de Horario</p><h1>OFICINA DE ADMISIONES Y REGISTRO</h1></th>
    
    </table>-->
    <h3>Se Encontraron <?=$total?> Registros</h3>
    <table width="100%" border="0" cellspacing="10" cellpadding="0">
        <th>
            <td class="th"><a href="javascript:void(0)" onclick="$('[name=\'campo_orden\']').val('CRN'); if($('[name=\'orden\']').attr('value')=='asc') $('[name=\'orden\']').val('desc'); else $('[name=\'orden\']').val('asc'); buscar(0,'<?php echo PAGINAS; ?>',$('[name=\'ultimo_buscar\']').attr('value'));">CRN</a></td>
            <td class="th"><a href="javascript:void(0)" onclick="$('[name=\'campo_orden\']').val('MATERIA'); if($('[name=\'orden\']').attr('value')=='asc') $('[name=\'orden\']').val('desc'); else $('[name=\'orden\']').val('asc'); buscar(0,'<?php echo PAGINAS; ?>',$('[name=\'ultimo_buscar\']').attr('value'));">MATERIA</a></td>
            <td class="th"><a href="javascript:void(0)" onclick="$('[name=\'campo_orden\']').val('SECCION'); if($('[name=\'orden\']').attr('value')=='asc') $('[name=\'orden\']').val('desc'); else $('[name=\'orden\']').val('asc'); buscar(0,'<?php echo PAGINAS; ?>',$('[name=\'ultimo_buscar\']').attr('value'));">SECCI&Oacute;N</a></td>
            <td class="th"><a href="javascript:void(0)" onclick="$('[name=\'campo_orden\']').val('TITULO'); if($('[name=\'orden\']').attr('value')=='asc') $('[name=\'orden\']').val('desc'); else $('[name=\'orden\']').val('asc'); buscar(0,'<?php echo PAGINAS; ?>',$('[name=\'ultimo_buscar\']').attr('value'));">T&Iacute;TULO</a></td>
            <td class="th"><a href="javascript:void(0)" onclick="$('[name=\'campo_orden\']').val('PROFESORES'); if($('[name=\'orden\']').attr('value')=='asc') $('[name=\'orden\']').val('desc'); else $('[name=\'orden\']').val('asc'); buscar(0,'<?php echo PAGINAS; ?>',$('[name=\'ultimo_buscar\']').attr('value'));">PROFESOR(ES)</a></td>
			<td class="th"><a href="javascript:void(0)" onclick="$('[name=\'campo_orden\']').val('LISTA_CRUZADA'); if($('[name=\'orden\']').attr('value')=='asc') $('[name=\'orden\']').val('desc'); else $('[name=\'orden\']').val('asc'); buscar(0,'<?php echo PAGINAS; ?>',$('[name=\'ultimo_buscar\']').attr('value'));">LISTA CRUZADA</a></td>			
			 
			<!--<td class="th" style="color:#FF0000">TIPO</td>
			<td class="th" style="color:#FF0000">CRN MAGISTRAL</td>
			<td class="th" style="color:#FF0000">T&Iacute;TULO MAGISTRAL</td>
			<td class="th" style="color:#FF0000">MATERIA MAGISTRAL</td>
			<td class="th" style="color:#FF0000">SECCI&Oacute;N MAGISTRAL</td>
			<td class="th" style="color:#FF0000">INSTRUCTOR MAGISTRAL</td>-->
        </th>
        <?php 
                
        foreach ($registros as $registro) {
            echo "<tr><td class='th'><input type=\"radio\" name=\"sec\" onclick=\"enviar(".$registro["CRN"].",'".$registro["TITULO"]."','".$registro["tipo"]."','".@$registro["key2"]."','".@$registro["seccion2"]."','".@$registro["MATERIA"]."','".@$registro["PROFESORES"]."','".$registro['SECCION']."','".@$registro['materias2']."','".@$registro['las_secciones2']."','".@$registro['profesores2']."','".@$registro['CRNs_CC']."','".@$registro['ATRIBUTO_CURSO']."','".@$registro['LISTA_CRUZADA']."')\" value='".$registro["CRN"]."'></td>";
            echo "<td class='td'>&nbsp;".($registro['CRN'])."</td>";
            echo "<td class='td'>&nbsp;".($registro['MATERIA'])."</td>";
            echo "<td class='td'>&nbsp;".($registro['SECCION'])."</td>";
            echo "<td class='td'>&nbsp;".($registro['TITULO'])."</td>";
            echo "<td class='td profe'>&nbsp;".($registro['PROFESORES'])."</td>";
			echo "<td class='td profe'>&nbsp;".($registro['LISTA_CRUZADA'])."</td>";
			
			/*echo "<td class='td' style='color:#FF0000'>&nbsp;".$registro['tipo']."</td>";
			echo "<td class='td' style='color:#FF0000'>&nbsp;".@$registro['key2']."</td>";
			echo "<td class='td' style='color:#FF0000'>&nbsp;".@$registro['seccion2']."</td>";	
			echo "<td class='td' style='color:#FF0000'>&nbsp;".@$registro['materias2']."</td>";
			echo "<td class='td' style='color:#FF0000'>&nbsp;".@$registro['las_secciones2']."</td>";
			echo "<td class='td' style='color:#FF0000'>&nbsp;".@$registro['profesores2']."</td>";*/			
			echo "</tr>";
            
        }         
        $total;	    
        $paginas=(int)ceil($total/$filas);
        $paginaActual=(int)(($actual+$filas)/$filas);
        //$paginas=($paginaActual<$paginas)?$paginas:$paginaActual;        
        $anterior=(($actual-$filas)<0)?0:$actual-$filas;
        $siguiente=(($actual+$filas)>$total)? (int) $paginas*$filas:$actual+$filas;
        ?>
         <tr colspan="6">             
             <td colspan="6" class="paginator" style="text-align: center;">
             	<a onclick="buscar(0,<? echo $filas?>,'<? echo $boton?>')"><img src="<? echo base_url()?>css/images/leftarrows.png"></a>
             	<a onclick="buscar(<? echo $anterior?>,<? echo $filas?>,'<? echo $boton?>')"><img src="<? echo base_url()?>css/images/leftarrow.png"></a>
             	
                 <?php
                    
                    if ($paginas>10){
                    	$inicio=($paginaActual<=5)?1:(int)$paginaActual-5;
                    	$fin=($paginaActual>=$paginas-5)?$paginas:$paginaActual+5;
                    	$inicio=($fin==$paginas)?$paginas-10:$inicio;
                    	$fin=($inicio==1)?10:$fin;
                    	for ($i=(int)$inicio;$i<=$fin;$i++){
                    		$opena=$closea='';
                    		if ((int)$paginaActual!=$i) {
                    			$opena="<a onclick='buscar(".(($i-1)*$filas).",$filas,\"$boton\")'>";
                    			$closea="</a>";
                    		}
                    		
                    		$class=((int)$paginaActual==$i)?'selected':'';
                    		echo "$opena<span class='$class'>$i</span>$closea";
                    	}
                    }else {
                    	for ($i=1; $i<=$paginas; $i++){                    		
                    		$opena=$closea='';
                    		if ($paginaActual!=$i) {
                    			$opena="<a onclick='buscar(".(($i-1)*$filas).",$filas,\"$boton\")'>";
                    			$closea="</a>";
                    		}
                    		$class=($paginaActual==$i)?'selected':'';
                    		echo "$opena<span class='$class'>$i</span>$closea";
                    	}
                    }
                 ?>
                 
                <a onclick="buscar(<? echo $siguiente?>,<? echo $filas?>,'<? echo $boton?>')"><img src="<? echo base_url()?>css/images/rightarrow.png"></a>
             	<a onclick="buscar(<? echo (($paginas-1)*$filas)?>,<? echo $filas?>,'<? echo $boton?>')"><img src="<? echo base_url()?>css/images/rightarrows.png"></a>
             </td>             
         </tr>
    </table>
    <?php
    }  else {
    ?>
        <h3>No se Encontraron Registros</h3>
    <?php
    }
    ?>
</div>
