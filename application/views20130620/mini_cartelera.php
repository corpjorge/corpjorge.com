<?php
$this->load->view("header");

$pr_id=87;
$buscar="Buscar";
?>
<script  type="text/javascript">
    
function enviar(id, seccion, tipo, id2, seccion2, materia, instructor, la_seccion, materia2, la_seccion2, instructor2){ //los datos de la magistral id2 y seccion2 son opcionales
	//alert('enviar ' + id + ' ' + seccion + ' ' + tipo + ' ' + '<?php echo $id_input?>' + ' ' + id2 + ' ' + seccion2);         
    $.ajax({
        type: 'POST',
        data: 'codigo=<? echo $idEstudiante ?>&crn='+id,
        url: '<?php echo base_url()?>index.php/solicitud/validarCrnEstudiante',                              
        dataType: 'json',
        success: function(dato){
           if(dato['pass']==0) alert(dato['msj'])            
     
           if(dato['pass']==1){                
                window.opener.put_crn(id,seccion,tipo,'<?php echo $id_input?>', id2, seccion2, materia, instructor, la_seccion, materia2, la_seccion2, instructor2);
                window.opener.show_crn(<?php echo $tip_id?>);
                window.close();
            }
        }
    });   
    
    
}

$(document).ready(function(){    
    
	if($('[name="pidm"]').attr('value')=='' || $('[name="pidm"]').attr('value')=='0'){
    $('.wrapper-header').css('display','none');
    //$('input[placeholder]').placeholder();
    $.ajax({
               type: 'POST',
			   data: 'id_input=<? echo @$id_input ?>&tip_id=<? echo @$tip_id ?>&valor=<? echo @$valor ?>',
               url: '<?php echo base_url()?>index.php/solicitud/busquedaMinicartelera',                              
               success: function(datos){
                   //$("#tablaResultados").append(datos);
		   $("#tablaResultados").html(datos);
               }
           });
	}
}); 
function buscar(actual,filas,busqueda){    
    if($('[name="pidm"]').attr('value')=='' || $('[name="pidm"]').attr('value')=='0'){
		$('[name=ultimo_buscar]').val(busqueda);
    $.ajax({
           type: 'POST',
           data: 'actual='+actual+
                 '&filas='+filas+
                 '&busqueda='+busqueda+
                 '&crn='+$('input:text[name=crn]').val()+
                 
                 '&programa_id='+$('select[name=programa_id]').val()+
                 '&materia1='+$('input:text[name=materia1]').val()+
                 '&seccion1='+$('input:text[name=seccion1]').val()+
                 
                 '&materia2='+$('input:text[name=materia2]').val()+
                 '&seccion2='+$('input:text[name=seccion2]').val()+
				 
				 '&profesor='+$('input:text[name=profesor]').val()+
				 
				 '&orden='+$('input:hidden[name=orden]').val()+
				 '&campo_orden='+$('input:hidden[name=campo_orden]').val()+
				 '&id_input=<? echo @$id_input ?>&tip_id=<? echo @$tip_id ?>&valor=<? echo @$valor ?>',
           url: '<?php echo base_url()?>index.php/solicitud/busquedaMinicartelera',
           success: function(datos){
               //$("#tablaResultados").append(datos);
               $("#tablaResultados").html(datos);
           }
       });
    }
}
</script>

<div id="minicartelera">
    <?php echo form_open('solicitud/busquedaMinicartelera'); ?>
	<?php echo form_hidden('pidm', set_value('pidm', @$pidm)); ?>
	<?php echo form_hidden('id_input', set_value('id_input', @$id_input)); ?>
	
	<?php if($valor!='' && $tip_id=='2' && $id_input=='sol_disp_crn_ins'){ ?>
		<table class='formtable' cellspacing=0 cellpadding="0" border="0" width="100%">
			<th class="headerCartelera" colspan="4"><p>Herramienta de Conflictos de Horario</p><h1>OFICINA DE ADMISIONES Y REGISTRO</h1></th>
		</table>
	<?php } ?>
	
	<div id="filtros" style="display:<? if(($valor!='' && $tip_id=='2' && $id_input=='sol_disp_crn_ins') || ($pidm!='' && $pidm!='0'))	 echo 'none'; else echo 'block'; ?>">
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
			
    <?php if($pidm!='' && $pidm!='0'){ ?>
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
	
		<?php foreach($secciones as $key=>$seccion){ ?>           
		<tr><td class="th"><input type="radio" name="sec" onclick="enviar(<?php echo $key ?>,'<?php echo $seccion ?>','<?php echo $tiposSecciones[$key] ?>','<?php echo @$key2[$key] //magistral ?>','<?php echo @$seccion2[$key] //magistral ?>', '<?php echo $materias[$key] ?>', '<?php echo $profesores[$key] ?>', '<?php echo $las_secciones[$key] ?>', '<?php echo @$materias2[$key] //magistral ?>', '<?php echo @$las_secciones2[$key] //magistral ?>', '<?php echo @$profesores2[$key] //magistral ?>')" value='<?php echo $key?>'></td><td class="td" id="secnom_<?php echo $key ?>"><?=$key?></td>
                
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
		<?php }?>
	
    </table>
    <?php } ?>
    <?php echo form_close(); ?>
</div>
<?php
$this->load->view("footer");
?>
