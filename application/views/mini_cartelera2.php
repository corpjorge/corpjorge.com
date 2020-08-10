<?php
$this->load->view("header");

$pr_id=87;
$buscar="Buscar";
//echo "<pre>";
//print_r($secciones);
// print_r($materias);
// echo "</pre>";
?>
<script  type="text/javascript">

$( document ).ajaxStart(function() {
	$body = $("body");
	$body.addClass("loading");
});
$( document ).ajaxStop(function() {
	$body = $("body");
	$body.removeClass("loading");
});

    
function enviar(id, seccion, tipo, id2, seccion2, materia, instructor, la_seccion, materia2, la_seccion2, instructor2,crns_cc){ //los datos de la magistral id2 y seccion2 son opcionales
	// alert('enviar ' + id + ' ' + seccion + ' ' + tipo + ' ' + '<?php echo $id_input?>' + ' ' + id2 + ' ' + seccion2+ ' ' +window.opener.jQuery("[name='sol_disp_crn_ret']").val());         
		$.ajax({
			type: 'POST',
			data: 'codigo=<? echo $idEstudiante ?>&crn='+id+'&periodo=<?php echo $periodo; ?>&tiposol=<? echo $tipo_sol?>',
			url: '<?php echo base_url()?>index.php/solicitud/validarCrnEstudiante',                              
			dataType: 'json',
			success: function(dato){
					window.opener.put_crn_opciones(id,seccion,tipo, materia, instructor,la_seccion,dato['cruceh'],<?php echo $fieldId ?>);
					window.close();
			}
		}); 
}

</script>

<div id="minicartelera">
    <?php echo form_open('solicitud/busquedaMinicartelera'); ?>
	<?php echo form_hidden('pidm', set_value('pidm', @$pidm)); ?>
	<?php echo form_hidden('id_input', set_value('id_input', @$id_input)); ?>
	
	<?php if($valor!='' && ($tip_id=='2' || $tip_id=='4') && $id_input=='sol_disp_crn_ins'){ ?>
		<table class='formtable' cellspacing=0 cellpadding="0" border="0" width="100%">
			<th class="headerCartelera" colspan="4"><p>Herramienta de Conflictos de Horario</p><h1>OFICINA DE ADMISIONES Y REGISTRO</h1></th>
		</table>
	<?php } ?>
	
	<div id="filtros" style="display:none">
		<table class='formtable' cellspacing=0 cellpadding="0" border="0" width="100%">
			<th class="headerCartelera" colspan="4"><p>Herramienta de Conflictos de Horario</p><h1>OFICINA DE ADMISIONES Y REGISTRO</h1></th>
			<tr><td colspan='2'><div class="opt">B&uacute;squeda por CRN</div></td></tr>
			<tr>				
				<td><br><label>Digite CRN</label></td>
				<td><br><?php echo form_input('crn','',' placeholder="Digite CRN" '); ?></td>				
			</tr>
			<tr><td colspan='2'><?php echo form_button('buscar1', $buscar,'onclick="buscar(0,'.PAGINAS.',\'buscar1\')"'); ?></td></tr>
			<tr><td colspan='2'><hr style='color: #808080;'></td></tr>
			<tr><td colspan='2'><div class="opt">B&uacute;squeda por Programa</div></td></tr>
			<tr>				
                                <td><br><label>Programa</label></td>
                                <td><?php echo form_dropdown('programa_id',$option_prog); ?></td>				
			</tr>			
			<tr>
                                <td><br><label>C&oacute;digo Materia</label></td>
                                <td><?php echo form_input('materia1','',' placeholder="Materia" '); ?></td>				
			</tr>
			<tr>	
                                <td><br><label>Secci&oacute;n</label></td>
                                <td><?php echo form_input('seccion1','',' placeholder="Secci&oacute;n" '); ?></td>				
			</tr>
			<tr><td colspan='2'><?php echo form_button('buscar2', $buscar,'onclick="buscar(0,'.PAGINAS.',\'buscar2\')"'); ?></td></tr>
			<tr><td colspan='2'><hr></td></tr>
			<tr><td colspan='2'><div class="opt">B&uacute;squeda por Materia</div></td></tr>
			<tr>				
				<td><br><label>Nombre Materia</label></td>
				<td><br><?php echo form_input('materia2','',' placeholder="Nombre Materia" '); ?></td>				
			</tr>			
			<tr>
				<td><br><label>Secci&oacute;n</label></td>
				<td><?php echo form_input('seccion2','',' placeholder="Secci&oacute;n" '); ?></td>				
			</tr>
			<tr><td colspan='2'><?php echo form_button('buscar3', $buscar,'onclick="buscar(0,'.PAGINAS.',\'buscar3\')"'); ?></td></tr>
			<tr><td colspan='2'><hr style='color: #808080;'></td></tr>
			<tr><td colspan='2'><div class="opt">B&uacute;squeda por Profesor</div></td></tr>
			<tr>				
				<td><br><label>Digite Profesor</label></td>
				<td><br><?php echo form_input('profesor','',' placeholder="Digite Profesor" '); ?></td>				
			</tr>
			<tr><td colspan='2'><?php echo form_button('buscar4', $buscar,'onclick="buscar(0,'.PAGINAS.',\'buscar4\')"'); ?></td></tr>
		</table>
	</div>
    <div id="tablaResultados"></div>
	<?php echo form_hidden('orden', set_value('orden', 'asc')); ?>
	<?php echo form_hidden('campo_orden', set_value('campo_orden', 'CRN')); ?>
	<?php echo form_hidden('ultimo_buscar', set_value('ultimo_buscar', '')); ?>
			
    <?php if(true){ ?>
    <h3>Mat&eacute;rias Disponibles</h3>
    <table class='formtable'>
        <th>
            <td class="th">CRN</td>
            <td class="th">MATERIA</td>
			<td class="th">SECCI&Oacute;N</td>
            <td class="th">T&Iacute;TULO</td>
            <td class="th">PROFESOR(ES)</td>
			
			<!--<td class="th" style="color:#FF0000">TIPO</td>
			<td class="th" style="color:#FF0000">CRN MAGISTRAL</td>
			<td class="th" style="color:#FF0000">T&Iacute;TULO MAGISTRAL</td>
			<td class="th" style="color:#FF0000">MATERIA MAGISTRAL</td>
			<td class="th" style="color:#FF0000">SECCI&Oacute;N MAGISTRAL</td>
			<td class="th" style="color:#FF0000">INSTRUCTOR MAGISTRAL</td>-->
			
        </th>
		<?php 
		$op=array("","0","1");
		// if($tipo_sol=="2"){
			// $op=array("","0");
		// } 
		if($tipo_sol=="4"){
			$op=array("1");
		}
		
			foreach($secciones as $key=>$seccion){ 
				if(in_array($lab_comp[$key], $op)){
		?> 
		<?php if ($id_input=='sol_sug_crns_cc') {?>          
			<tr><td class="th"><input type="radio" name="sec" onclick="alert('Error al consultar los correquisitos asociados a la magistral')" value='<?php echo $key?>'></td><td class="td" id="secnom_<?php echo $key ?>"><?=$key?></td>
		<?php }else{?>
			<tr><td class="th"><input type="radio" name="sec" onclick="enviar(<?php echo $key ?>,'<?php echo $seccion ?>','<?php echo $tiposSecciones[$key] ?>','<?php echo @$key2[$key] //magistral ?>','<?php echo @$seccion2[$key] //magistral ?>', '<?php echo $materias[$key] ?>', '<?php echo $profesores[$key] ?>', '<?php echo $las_secciones[$key] ?>', '<?php echo @$materias2[$key] //magistral ?>', '<?php echo @$las_secciones2[$key] //magistral ?>', '<?php echo @$profesores2[$key] //magistral ?>','<?php echo @$profesores2[$key] //magistral ?>')" value='<?php echo $key?>'></td><td class="td" id="secnom_<?php echo $key ?>"><?=$key?></td>
		<?php }?>
                
            <!--<td class="td"><?php echo $seccion/*.'<span style=\'color:#FF0000\'> - '.$tiposSecciones[$key].' - '.@$key2[$key].' - '.@$seccion2[$key].'</span>'*/ ?></td>-->
			<td class="td"><?php echo $materias[$key] ?></td>
			<td class="td"><?php echo $las_secciones[$key] ?></td>
			<td class="td"><?php echo $titulos[$key] ?></td>
			<td class="td"><?php echo $profesores[$key] ?></td>
			
			<!--<td class="td"><?php echo $tiposSecciones[$key] ?></td>
			<td class="td"><?php echo @$key2[$key] ?></td>
			<td class="td"><?php echo @$seccion2[$key] ?></td>
			<td class="td"><?php echo @$materias2[$key] ?></td>
			<td class="td"><?php echo @$las_secciones2[$key] ?></td>
			<td class="td"><?php echo @$profesores2[$key] ?></td>-->
		</tr>
		<?php 
			}
		}
		?>
	
    </table>
    <?php } ?>
    <?php echo form_close(); ?>
</div>
<div class="modalAjax"><!-- Place at bottom of page --></div>
<?php
$this->load->view("footer");
?>
