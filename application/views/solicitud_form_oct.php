<?php
if($rol==3) //estudiante
	$this->load->view("header");
?>
<style>
#lb_mensaje_ret{
	color: #ff0000;
}
#lb_mensaje_ins{
	color: #ff0000;
}
</style>
<script type="text/javascript">
function show_me(id){
	estado  = $("#"+id).css("display");
	if(estado=="none"){
		$("#"+id).show();		
	}else{
		$("#"+id).hide();
	}	 
}
function limpiar_crn(){
	$("#lb_sol_disp_crn_ret").html('');
	$("#lb_sol_disp_crn_ins").html('');
	$("#lb_sol_sug_crn_ret").html('');
	$("#lb_sol_sug_crn_ins").html('');	
	$("#lb_sol_disp_crn_ret").css('display','none');
	$("#lb_sol_disp_crn_ins").css('display','none');
	$("#lb_sol_sug_crn_ret").css('display','none');
	$("#lb_sol_sug_crn_ins").css('display','none');
	
	$('[name="sol_disp_crn_ret"]').val('');
	$('[name="sol_disp_crn_ret_des"]').val('');
	$('[name="sol_disp_crn_ret_tipo"]').val('');
	$('[name="sol_disp_crn_ret_materia"]').val('');
	$('[name="sol_disp_crn_ret_instructor"]').val('');
	$('[name="sol_disp_crn_ret_seccion"]').val('');
	
	$('[name="sol_disp_crn_ins"]').val('');
	$('[name="sol_disp_crn_ins_des"]').val('');
	$('[name="sol_disp_crn_ins_tipo"]').val('');
	$('[name="sol_disp_crn_ins_materia"]').val('');
	$('[name="sol_disp_crn_ins_instructor"]').val('');
	$('[name="sol_disp_crn_ins_seccion"]').val('');
	
	$('[name="sol_sug_crn_ret"]').val('');
	$('[name="sol_sug_crn_ret_des"]').val('');
	$('[name="sol_sug_crn_ret_tipo"]').val('');
	$('[name="sol_sug_crn_ret_materia"]').val('');
	$('[name="sol_sug_crn_ret_instructor"]').val('');
	$('[name="sol_sug_crn_ret_seccion"]').val('');
	
	$('[name="sol_sug_crn_ins"]').val('');
	$('[name="sol_sug_crn_ins_des"]').val('');
	$('[name="sol_sug_crn_ins_tipo"]').val('');
	$('[name="sol_sug_crn_ins_materia"]').val('');
	$('[name="sol_sug_crn_ins_instructor"]').val('');
	$('[name="sol_sug_crn_ins_seccion"]').val('');

	//php no comentado en un comentario Javascript si se ejecuta
	if($('[name="sol_disp_crn_ret"]').attr('value')==''){
		<?php //@$sol_disp_crn_ret = ''; ?>
	}	
	if($('[name="sol_disp_crn_ins"]').attr('value')==''){
		<?php //@$sol_disp_crn_ins = ''; ?>
	}
	if($('[name="sol_sug_crn_ret"]').attr('value')==''){
		<?php //@$sol_sug_crn_ret = ''; ?>
	}
	if($('[name="sol_sug_crn_ins"]').attr('value')==''){
		<?php //@$sol_sug_crn_ins = ''; ?>
	}
}
function show_crn(valor){
	//alert('show_crn ' + $('[name="sol_disp_crn_ret_tipo"]').attr('value') + ' ' + $('[name="sol_disp_crn_ins_tipo"]').attr('value'));	
	switch(valor){
		case '1':
			$('#crn_disp_2').css('display','none');
			$('#crn_disp_1').css('display','inline');
			$('#lb_crn_disp_1').html('Curso Inscripci&oacute;n: ');
			$('#lb_crn_sug_1').html('Curso Sugerencia Inscripci&oacute;n: ');
		break;
		case '2':
			$('#crn_disp_1').css('display','inline');
			$('#crn_disp_2').css('display','inline');
			$('#lb_crn_disp_1').html('Curso Retiro: ');
			$('#lb_crn_sug_1').html('Curso Sugerencia Retiro: ');
		break;
		case '3':
			$('#crn_disp_1').css('display','inline');
			$('#crn_disp_2').css('display','inline');
			$('#lb_crn_disp_1').html('Curso Retiro: ');
			$('#lb_crn_sug_1').html('Curso Sugerencia Retiro: ');
		break;
	}
	var muestra = ($('[name="sol_disp_crn_ret_tipo"]').attr('value')=='mag' || $('[name="sol_disp_crn_ret_tipo"]').attr('value')=='com') ? 'inline' : 'none';
	var tipo_crn = $('[name="tip_id"]').attr('value')=='1' ? 'Inscripci&oacute;n' : 'Retiro';
	$('#crn_sug_1').css('display', muestra);	
	var tipomat = '';
	if($('[name="sol_disp_crn_ret_tipo"]').attr('value')=='mag')
		tipomat = 'Magistral';
	if($('[name="sol_disp_crn_ret_tipo"]').attr('value')=='com')
		tipomat = 'Complementaria';	
	$("#lb_mensaje_ret").html('Ha seleccionado una materia ' + tipomat + ' en Curso ' + tipo_crn + ', debe seleccionar Curso Sugerencia ' + tipo_crn);	
	$('#mensaje_ret').css('display', muestra);
	
	/*muestra = $('[name="sol_disp_crn_ret_tipo"]').attr('value')=='com' ? 'inline' : 'none';
	$('#mensaje').css('display', muestra);*/	
	
	muestra = ($('[name="sol_disp_crn_ins_tipo"]').attr('value')=='mag' || $('[name="sol_disp_crn_ins_tipo"]').attr('value')=='com') ? 'inline' : 'none';
	$('#crn_sug_2').css('display', muestra);	
	tipomat = '';
	if($('[name="sol_disp_crn_ins_tipo"]').attr('value')=='mag')
		tipomat = 'Magistral';
	if($('[name="sol_disp_crn_ins_tipo"]').attr('value')=='com')
		tipomat = 'Complementaria';
	$("#lb_mensaje_ins").html('Ha seleccionado una materia ' + tipomat + ' en Curso Inscripci&oacute;n, debe seleccionar Curso Sugerencia Inscripci&oacute;n');
	$('#mensaje_ins').css('display', muestra);
	
	/*if($('[name="sol_disp_crn_ret_tipo"]').attr('value')=='com'){
		$('#crn_sug_1').css('display','none');
		$('#mensaje').css('display','inline');
	}
	else if($('[name="sol_disp_crn_ret_tipo"]').attr('value')=='mag'){ 
		$('#crn_sug_1').css('display','inline');
		$('#mensaje').css('display','none');
	}
	if($('[name="sol_disp_crn_ins_tipo"]').attr('value')=='com'){
		$('#crn_sug_2').css('display','none');
		$('#mensaje').css('display','none');
	}	
	else if($('[name="sol_disp_crn_ins_tipo"]').attr('value')=='mag'){
		$('#crn_sug_2').css('display','inline');
		$('#mensaje').css('display','none');
	}*/
	
	//oculta los botones para sugerencias magistrales
	if($('[name="sol_sug_crn_ins_tipo"]').attr('value')=='mag')
		$('#bt_sol_sug_crn_ins').css('display', 'none');		
	if($('[name="sol_sug_crn_ret_tipo"]').attr('value')=='mag')
		$('#bt_sol_sug_crn_ret').css('display', 'none');
		
	//Para cambio de sección debe seleccionar primero Curso Retiro
	if(valor=='2' && $('[name="sol_disp_crn_ret"]').attr('value')=='')
		$('#bt_sol_disp_crn_ins').css('display', 'none');
	else
		$('#bt_sol_disp_crn_ins').css('display', 'inline');
}

function get_crn(id){
	var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=508, height=365, top=85, left=140";
	window.open("<?php echo base_url();?>index.php/solicitud/ayuda/"+id,"",opciones);
}

function get_minicartelera(tip_id, id/*campo*/, valor, tipo, pidm){
	//alert(tip_id + ' ' + id + ' ' + valor + ' ' + tipo + ' ' + pidm);	        
	tip_id = tip_id!='' ? tip_id : '0';
	id = id!='' ? id : '0';
	valor = valor!='' ? valor : '0';
	tipo = tipo!='' ? tipo : '0';
	pidm = pidm!='' ? pidm : '0';	
	//var opciones="toolbar=yes, location=yes, directories=yes, status=yes, menubar=yes, scrollbars=yes, resizable=yes, width=1200, height=565, top=85, left=140";
	var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1200, height=565, top=85, left=140";
	window.open("<?php echo base_url();?>index.php/solicitud/ayudaMinicartelera/"+ tip_id + '/' + id + '/' + valor + '/' + tipo + '/' + pidm + '/' + $("#UACarnetEstudiante").val(),"",opciones);
}

function put_crn(id,seccion, tipo, id_input, id2, seccion2, materia, instructor, la_seccion, materia2, la_seccion2, instructor2){ //los datos de la magistral id2 y seccion2 son opcionales
	//alert('put_crn ' + id + ' ' + seccion + ' ' + tipo + ' ' + id_input + ' ' + id2 + ' ' + seccion2);
	
	//Para cambio de sección Curso Inscripción es limpiado cuando cambia Curso Retiro
	if($('#tip_id').attr('value')=='2' && id_input=='sol_disp_crn_ret'){
		var id_input_ins = id_input.replace("_ret", "_ins");
		$('[name="'+id_input_ins+'"]').val('');
		$('[name="'+id_input_ins+'_des"]').val('');
		$('[name="'+id_input_ins+'_tipo"]').val('');
		$('[name="'+id_input_ins+'_materia"]').val('');
		$('[name="'+id_input_ins+'_instructor"]').val('');
		$('[name="'+id_input_ins+'_seccion"]').val('');
	}
	
	$('[name="'+id_input+'"]').val(id);
	$('[name="'+id_input+'_des"]').val(seccion);
    $('[name="'+id_input+'_tipo"]').val(tipo);
	$('[name="'+id_input+'_materia"]').val(materia);
	$('[name="'+id_input+'_instructor"]').val(instructor);
	$('[name="'+id_input+'_seccion"]').val(la_seccion);
	var nombre_tipo;
	switch (tipo) {
		case 'mag':
		   nombre_tipo = 'MAGISTRAL';
		   tipo_sug = 'com';
		   nombre_tipo_sug = 'COMPLEMENTARIA';
		   break
		case 'com':
		   nombre_tipo = 'COMPLEMENTARIA';
		   tipo_sug = 'mag';
		   nombre_tipo_sug = 'MAGISTRAL';
		   break
		 default:
		   nombre_tipo = 'NORMAL';
		   tipo_sug = '';
	}
	if(materia!='')
		$("#lb_" + id_input).html(
		"<table class='formtable' width='100%' align='center'><tr class='tdlabel'><td>CRN</td><td>MATERIA</td><td>SECCI&Oacute;N</td><td>PROFESOR(ES)</td><td>TIPO</td></tr><tr><td>" + id + "</td><td>" + materia + "</td><td>" + la_seccion + "</td><td>" + instructor + "</td><td>" + nombre_tipo + "<td></tr></table>"
		);
	else
		$("#lb_" + id_input).html(
		"<table class='formtable' width='100%' align='center'><tr class='tdlabel'><td>CRN</td><td>TIPO</td></tr><tr><td>" + id + "</td><td>" + nombre_tipo + "<td></tr></table>"
		);
	$("#lb_" + id_input).css('display','inline');
	//if(id2!='') {//si es disparador complementaria carga los datos de la magistral en la sugerencia
	if(id_input.indexOf('_disp_')!='-1') { //si es disparador limpia o actualiza la sugerencia
		var id_input_mag = id_input.replace("_disp_", "_sug_");
		$('[name="'+id_input_mag+'"]').val(id2);
		$('[name="'+id_input_mag+'_des"]').val(seccion2);				
		$('[name="'+id_input_mag+'_tipo"]').val(tipo_sug);
		$('[name="'+id_input_mag+'_materia"]').val(materia2);
		$('[name="'+id_input_mag+'_instructor"]').val(instructor2);
		$('[name="'+id_input_mag+'_seccion"]').val(la_seccion2);
		
		if(id2!=''){
			$("#lb_" + id_input_mag).html(
			"<table class='formtable' width='100%' align='center'><tr class='tdlabel'><td>CRN</td><td>MATERIA</td><td>SECCI&Oacute;N</td><td>PROFESOR(ES)</td><td>TIPO</td></tr><tr><td>" + id2 + "</td><td>" + materia2 + "</td><td>" + la_seccion2 + "</td><td>" + instructor2 + "</td><td>" + nombre_tipo_sug + "<td></tr></table>"
			);
			$("#lb_" + id_input_mag).css('display','inline');
			$("#bt_" + id_input_mag).css("display", "none");
		}
		else {
			$("#lb_" + id_input_mag).html('');
			$("#bt_" + id_input_mag).css("display", "inline");
		}
		/*if(tipo_sug=='mag')
			$("#bt_" + id_input_mag).css("display", "none");
		else
			$("#bt_" + id_input_mag).css("display", "inline");*/
	}
}

$(document).ready(function() {
	var valor_tipo = '<?php echo $tip_id;?>';
	if(valor_tipo!="")
		show_crn(valor_tipo);
		
	$("#various2").fancybox({
		'titlePosition'		: 'inside',
		'transitionIn'		: 'none',
		'transitionOut'		: 'none'
	});
});

function validar_crn(crn){
    $.ajax({
      url: '<?php echo base_url()?>index.php/solicitud/validar_crn/'+ crn,
      type: "POST",
      success: function(html){
		alert(html);
		if(html=='mag' || html=='com') {
			$('#crn_sug_1').css('display','block');
			if(html=='mag')
				$('#sol_sug_crn_ret_des').attr('value','');
			if(html=='com') {
				$('#sol_sug_crn_ret_des').attr('value',crn);
				$('#sol_disp_crn_ret_des').attr('value','');
			}
		}
		else if(html=='0') //no es magistral ni complementaria
			$('#crn_sug_1').css('display','none');
	}
	});
}	
</script>
<?php if($rol==3){ //estudiante ?>
<a class="volver" href="<?php echo base_url()?>index.php/solicitud/">Volver</a><br>
<? } ?>
<?php if(validation_errors('<p class="error">','</p>')!=''){
if($rol!=3) //estudiante
	$attributes = array('style' => 'width:inherit; margin: 0pt;"');
echo form_open('', @$attributes);
echo str_replace('&lt;', '<', str_replace('&gt;', '>', htmlentities(validation_errors('<p class="error">','</p>'), ENT_NOQUOTES)));
echo form_close();
if($rol!=3)
	echo "<br>";
} ?>
<?php
$attributes = array('id' => 'form_solicitud');
if($rol!=3) //estudiante
	$attributes = array('id' => 'form_solicitud', 'style' => 'width:inherit; margin: 0pt;"');
echo form_open('solicitud/'.$accion.'/'.$sol_id,$attributes);
?>
	<h1><?php echo $titulo; ?> solicitud</h1>
	<table class='formtable' width="100%">
	<?php if($rol!=3){ //estudiante ?>
	<tr>
		<td class="tdlabel" width="50%">Login: </td>
		<td width="50%">
		<?php
			$id=' id="sol_login"';
			echo form_input('sol_login', set_value('sol_login', @$sol_login), $id);
		?>
		</td>
	</tr>
	<tr>
		<td class="tdlabel">Email: </td>
		<td>
		<?php
			$id=' id="sol_email"';
			echo form_input('sol_email', set_value('sol_email', @$sol_email), $id);
		?>
		</td>
	</tr>
	<tr>
		<td class="tdlabel">Nombre: </td>
		<td id="lb_sol_nombre">
			<?php echo @$sol_nombre ?>			
		</td>
		<?php echo form_hidden('sol_nombre', set_value('sol_nombre', @$sol_nombre)); ////esto no puede estar dentro del td lb_sol_nombre ?>		
	</tr>
	<tr>
		<td class="tdlabel">Apellido: </td>
		<td id="lb_sol_apellido">
			<?php echo @$sol_apellido ?>			
		</td>
			<?php echo form_hidden('sol_apellido', set_value('sol_apellido', @$sol_apellido)); //esto no puede estar dentro del td lb_sol_apellido ?>
			<?php echo form_hidden('dep_id', set_value('dep_id', @$dep_id)); ?>
			<?php echo form_hidden('dep_id_sec', set_value('dep_id_sec', @$dep_id_sec)); ?>
			<?php echo form_hidden('sol_nivel', set_value('sol_nivel', @$sol_nivel)); ?>
			<?php echo form_hidden('sol_uidnumber', set_value('sol_uidnumber', @$sol_uidnumber)); ?>
	</tr>
				
	<? } ?>	
	<tr>				
		<td class="tdlabel" width="50%">Tipo de Solicitud: </td>
		<td><?php
		  $js = ' id="tip_id" onchange="limpiar_crn(); show_crn(this.value)"';
		  echo form_dropdown('tip_id',$options_tipo,$tip_id,$js);		  
		?>
		<?php echo form_hidden('sol_pidm', set_value('sol_pidm', @$sol_pidm)); ?>
		<?php echo form_hidden('pidm', set_value('pidm', @$sol_pidm)); ?>
		</td>
	</tr>
        <tr>
		<td class="tdlabel">Motivo: </td>
		<td><?php echo form_dropdown('mov_id',$options_motivo,$mov_id); ?></td>
	</tr>
</table>
<table class='formtable' width="100%" id='crn_disp_2' style='display:none'>
	<tr>
		<td class="tdlabel" width="50%">Curso Inscripci&oacute;n: </td>
		<td>
			<?php
			$id=' id="sol_disp_crn_ins_des" readonly="readonly" size="50px"';
			echo form_input('sol_disp_crn_ins_des', set_value('sol_disp_crn_ins_des', @$sol_disp_crn_ins_des), $id);		 
			?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<input id="bt_sol_disp_crn_ins" type="button" style="width:auto" value="Consultar cursos" onclick="get_minicartelera($('[name=\'tip_id\']').attr('value'), 'sol_disp_crn_ins', $('[name=\'sol_disp_crn_ret\']').attr('value'), $('[name=\'sol_disp_crn_ins_tipo\']').attr('value'), '')">
			<?php
			$id=' id="sol_disp_crn_ins"';
			echo form_hidden('sol_disp_crn_ins', set_value('sol_disp_crn_ins', @$sol_disp_crn_ins));
			$id=' id="sol_disp_crn_ins_tipo"';
			echo form_hidden('sol_disp_crn_ins_tipo', set_value('sol_disp_crn_ins_tipo', @$sol_disp_crn_ins_tipo));
			$id=' id="sol_disp_crn_ins_materia"';
			echo form_hidden('sol_disp_crn_ins_materia', set_value('sol_disp_crn_ins_materia', @$sol_disp_crn_ins_materia));
			$id=' id="sol_disp_crn_ins_instructor"';
			echo form_hidden('sol_disp_crn_ins_instructor', set_value('sol_disp_crn_ins_instructor', @$sol_disp_crn_ins_instructor));
			$id=' id="sol_disp_crn_ins_seccion"';
			echo form_hidden('sol_disp_crn_ins_seccion', set_value('sol_disp_crn_ins_seccion', @$sol_disp_crn_ins_seccion));
			?>		
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<label id="lb_sol_disp_crn_ins"><?php //if(@$sol_disp_crn_ins!=''){ if(@$sol_disp_crn_ins_materia!='') echo "<table class='formtable' width='100%'><tr class='tdlabel'><td>CRN</td><td>MATERIA</td><td>SECCI&Oacute;N</td><td>PROFESOR(ES)</td><td>TIPO</td></tr><tr><td>".@$sol_disp_crn_ins."</td><td>".@$sol_disp_crn_ins_materia."</td><td>".@$sol_disp_crn_ins_seccion."</td><td>".@$sol_disp_crn_ins_instructor."</td><td>".nombre(@$sol_disp_crn_ins_tipo)."<td></tr></table>"; else echo "<table class='formtable' width='100%'><tr class='tdlabel'><td>CRN</td><td>TIPO</td></tr><tr><td>".@$sol_disp_crn_ins."</td><td>".nombre(@$sol_disp_crn_ins_tipo)."<td></tr></table>"; } ?></label>
			<script>if($('[name="sol_disp_crn_ins"]').attr('value')!=''){ $("#lb_sol_disp_crn_ins").html("<?php /*if(@$sol_disp_crn_ins!=''){*/ if(@$sol_disp_crn_ins_materia!='') echo "<table class='formtable' width='100%'><tr class='tdlabel'><td>CRN</td><td>MATERIA</td><td>SECCI&Oacute;N</td><td>PROFESOR(ES)</td><td>TIPO</td></tr><tr><td>".@$sol_disp_crn_ins."</td><td>".@$sol_disp_crn_ins_materia."</td><td>".@$sol_disp_crn_ins_seccion."</td><td>".@$sol_disp_crn_ins_instructor."</td><td>".nombre(@$sol_disp_crn_ins_tipo)."<td></tr></table>"; else echo "<table class='formtable' width='100%'><tr class='tdlabel'><td>CRN</td><td>TIPO</td></tr><tr><td>".@$sol_disp_crn_ins."</td><td>".nombre(@$sol_disp_crn_ins_tipo)."<td></tr></table>"; //} ?>"); }</script>
		</td>
	</tr>
</table>
<table class='formtable' width="100%" id='mensaje_ins' style='display:none'>
	<tr>
		<td colspan="2">
			<label id="lb_mensaje_ins"></label>
		</td>
	</tr>
</table>	
<table class='formtable' width="100%" id='crn_disp_1' style='display:none'>
	<tr>
		<td id='lb_crn_disp_1' class="tdlabel" width="50%">Curso Retiro: </td>
		<td>
			<?php
			$js = ' id="sol_disp_crn_ret_des" readonly="readonly" size="50px"'; //onchange="validar_crn(this.value)"';
			echo form_input('sol_disp_crn_ret_des', set_value('sol_disp_crn_ret_des', @$sol_disp_crn_ret_des), $js); ?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<input id="bt_sol_disp_crn_ret" type="button" style="width:auto" value="Consultar cursos" onclick="var pidm = $('#tip_id').attr('value')!='1' ? $('[name=\'pidm\']').attr('value') : ''; get_minicartelera($('[name=\'tip_id\']').attr('value'), 'sol_disp_crn_ret', $('[name=\'sol_sug_crn_ret\']').attr('value'), $('[name=\'sol_disp_crn_ret_tipo\']').attr('value'), pidm)">
			<?php
			$id=' id="sol_disp_crn_ret"';
			echo form_hidden('sol_disp_crn_ret', set_value('sol_disp_crn_ret', @$sol_disp_crn_ret));
			$id=' id="sol_disp_crn_ret_tipo"';
			echo form_hidden('sol_disp_crn_ret_tipo', set_value('sol_disp_crn_ret_tipo', @$sol_disp_crn_ret_tipo));
			$id=' id="sol_disp_crn_ret_materia"';
			echo form_hidden('sol_disp_crn_ret_materia', set_value('sol_disp_crn_ret_materia', @$sol_disp_crn_ret_materia));
			$id=' id="sol_disp_crn_ret_instructor"';
			echo form_hidden('sol_disp_crn_ret_instructor', set_value('sol_disp_crn_ret_instructor', @$sol_disp_crn_ret_instructor));
			$id=' id="sol_disp_crn_ret_seccion"';
			echo form_hidden('sol_disp_crn_ret_seccion', set_value('sol_disp_crn_ret_seccion', @$sol_disp_crn_ret_seccion));
			?>		
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<label id="lb_sol_disp_crn_ret"><?php //if(@$sol_disp_crn_ret!=''){ if(@$sol_disp_crn_ret_materia!='') echo "<table class='formtable' width='100%'><tr class='tdlabel'><td>CRN</td><td>MATERIA</td><td>SECCI&Oacute;N</td><td>PROFESOR(ES)</td><td>TIPO</td></tr><tr><td>".@$sol_disp_crn_ret."</td><td>".@$sol_disp_crn_ret_materia."</td><td>".@$sol_disp_crn_ret_seccion."</td><td>".@$sol_disp_crn_ret_instructor."</td><td>".nombre(@$sol_disp_crn_ret_tipo)."<td></tr></table>"; else echo "<table class='formtable' width='100%'><tr class='tdlabel'><td>CRN</td><td>TIPO</td></tr><tr><td>".@$sol_disp_crn_ret."</td><td>".nombre(@$sol_disp_crn_ret_tipo)."<td></tr></table>"; } ?></label>
			<script>if($('[name="sol_disp_crn_ret"]').attr('value')!=''){ $("#lb_sol_disp_crn_ret").html("<?php /*if(@$sol_disp_crn_ret!=''){*/ if(@$sol_disp_crn_ret_materia!='') echo "<table class='formtable' width='100%'><tr class='tdlabel'><td>CRN</td><td>MATERIA</td><td>SECCI&Oacute;N</td><td>PROFESOR(ES)</td><td>TIPO</td></tr><tr><td>".@$sol_disp_crn_ret."</td><td>".@$sol_disp_crn_ret_materia."</td><td>".@$sol_disp_crn_ret_seccion."</td><td>".@$sol_disp_crn_ret_instructor."</td><td>".nombre(@$sol_disp_crn_ret_tipo)."<td></tr></table>"; else echo "<table class='formtable' width='100%'><tr class='tdlabel'><td>CRN</td><td>TIPO</td></tr><tr><td>".@$sol_disp_crn_ret."</td><td>".nombre(@$sol_disp_crn_ret_tipo)."<td></tr></table>"; //} ?>"); }</script>
		</td>
	</tr>		
</table>
<table class='formtable' width="100%" id='mensaje_ret' style='display:none'>
	<tr>
		<td colspan="2">
			<label id="lb_mensaje_ret"></label>
		</td>
	</tr>
</table>
<table class='formtable' width="100%" id='crn_sug_2' style='display:none'>
	<tr>
		<td class="tdlabel" width="50%">Curso Sugerencia Inscripci&oacute;n: </td>
		<td>
			<?php
			$id=' id="sol_sug_crn_ret" readonly="readonly" size="50px"';
			echo form_input('sol_sug_crn_ins_des', set_value('sol_sug_crn_ins_des', @$sol_sug_crn_ins_des), $id); ?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<input id="bt_sol_sug_crn_ins" type="button" style="width:auto" value="Consultar cursos" onclick="var pidm = $('[name=\'sol_sug_crn_ins_tipo\']').attr('value')=='com' ? $('[name=\'pidm\']').attr('value') : ''; get_minicartelera($('[name=\'tip_id\']').attr('value'), 'sol_sug_crn_ins', $('[name=\'sol_disp_crn_ins\']').attr('value'), $('[name=\'sol_sug_crn_ins_tipo\']').attr('value'), pidm)">
			<?php
			$id=' id="sol_sug_crn_ins"';
			echo form_hidden('sol_sug_crn_ins', set_value('sol_sug_crn_ins', @$sol_sug_crn_ins));
			$id=' id="sol_sug_crn_ins_tipo"';
			echo form_hidden('sol_sug_crn_ins_tipo', set_value('sol_sug_crn_ins_tipo', @$sol_sug_crn_ins_tipo));
			$id=' id="sol_sug_crn_ins_materia"';
			echo form_hidden('sol_sug_crn_ins_materia', set_value('sol_sug_crn_ins_materia', @$sol_sug_crn_ins_materia));
			$id=' id="sol_sug_crn_ins_instructor"';
			echo form_hidden('sol_sug_crn_ins_instructor', set_value('sol_sug_crn_ins_instructor', @$sol_sug_crn_ins_instructor));
			$id=' id="sol_sug_crn_ins_seccion"';
			echo form_hidden('sol_sug_crn_ins_seccion', set_value('sol_sug_crn_ins_seccion', @$sol_sug_crn_ins_seccion));
			?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<label id="lb_sol_sug_crn_ins"><?php //if(@$sol_sug_crn_ins!=''){ if(@$sol_sug_crn_ins_materia!='') echo "<table class='formtable' width='100%'><tr class='tdlabel'><td>CRN</td><td>MATERIA</td><td>SECCI&Oacute;N</td><td>PROFESOR(ES)</td><td>TIPO</td></tr><tr><td>".@$sol_sug_crn_ins."</td><td>".@$sol_sug_crn_ins_materia."</td><td>".@$sol_sug_crn_ins_seccion."</td><td>".@$sol_sug_crn_ins_instructor."</td><td>".nombre(@$sol_sug_crn_ins_tipo)."<td></tr></table>"; else echo "<table class='formtable' width='100%'><tr class='tdlabel'><td>CRN</td><td>TIPO</td></tr><tr><td>".@$sol_sug_crn_ins."</td><td>".nombre(@$sol_sug_crn_ins_tipo)."<td></tr></table>"; } ?></label>
			<script>if($('[name="sol_sug_crn_ins"]').attr('value')!=''){ $("#lb_sol_sug_crn_ins").html("<?php /*if(@$sol_sug_crn_ins!=''){*/ if(@$sol_sug_crn_ins_materia!='') echo "<table class='formtable' width='100%'><tr class='tdlabel'><td>CRN</td><td>MATERIA</td><td>SECCI&Oacute;N</td><td>PROFESOR(ES)</td><td>TIPO</td></tr><tr><td>".@$sol_sug_crn_ins."</td><td>".@$sol_sug_crn_ins_materia."</td><td>".@$sol_sug_crn_ins_seccion."</td><td>".@$sol_sug_crn_ins_instructor."</td><td>".nombre(@$sol_sug_crn_ins_tipo)."<td></tr></table>"; else echo "<table class='formtable' width='100%'><tr class='tdlabel'><td>CRN</td><td>TIPO</td></tr><tr><td>".@$sol_sug_crn_ins."</td><td>".nombre(@$sol_sug_crn_ins_tipo)."<td></tr></table>"; //} ?>"); }</script>
		</td>
	</tr>
</table>
<table class='formtable' width="100%" id='crn_sug_1' style='display:none'>
	<tr>
		<td id='lb_crn_sug_1' class="tdlabel" width="50%">Curso Sugerencia Retiro: </td>
		<td>
			<?php
			$id=' id="sol_sug_crn_ret_des" readonly="readonly" size="50px"';
			echo form_input('sol_sug_crn_ret_des', set_value('sol_sug_crn_ret_des', @$sol_sug_crn_ret_des), $id); ?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<input id="bt_sol_sug_crn_ret" type="button" style="width:auto" value="Consultar cursos" onclick="var pidm = ($('#tip_id').attr('value')!='1' || $('[name=\'sol_sug_crn_ret_tipo\']').attr('value')=='com') ? $('[name=\'pidm\']').attr('value') : ''; get_minicartelera($('[name=\'tip_id\']').attr('value'), 'sol_sug_crn_ret', $('[name=\'sol_disp_crn_ret\']').attr('value'), $('[name=\'sol_sug_crn_ret_tipo\']').attr('value'), pidm)">
			<?php
			$id=' id="sol_sug_crn_ret"';
			echo form_hidden('sol_sug_crn_ret', set_value('sol_sug_crn_ret', @$sol_sug_crn_ret));
			$id=' id="sol_sug_crn_ret_tipo"';
			echo form_hidden('sol_sug_crn_ret_tipo', set_value('sol_sug_crn_ret_tipo', @$sol_sug_crn_ret_tipo));
			$id=' id="sol_sug_crn_ret_materia"';
			echo form_hidden('sol_sug_crn_ret_materia', set_value('sol_sug_crn_ret_materia', @$sol_sug_crn_ret_materia));
			$id=' id="sol_sug_crn_ret_instructor"';
			echo form_hidden('sol_sug_crn_ret_instructor', set_value('sol_sug_crn_ret_instructor', @$sol_sug_crn_ret_instructor));
			$id=' id="sol_sug_crn_ret_seccion"';
			echo form_hidden('sol_sug_crn_ret_seccion', set_value('sol_sug_crn_ret_seccion', @$sol_sug_crn_ret_seccion));
			?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<label id="lb_sol_sug_crn_ret"><?php //if(@$sol_sug_crn_ret!=''){ if(@$sol_sug_crn_ret_materia!='') echo "<table class='formtable' width='100%'><tr class='tdlabel'><td>CRN</td><td>MATERIA</td><td>SECCI&Oacute;N</td><td>PROFESOR(ES)</td><td>TIPO</td></tr><tr><td>".@$sol_sug_crn_ret."</td><td>".@$sol_sug_crn_ret_materia."</td><td>".@$sol_sug_crn_ret_seccion."</td><td>".@$sol_sug_crn_ret_instructor."</td><td>".nombre(@$sol_sug_crn_ret_tipo)."<td></tr></table>"; else echo "<table class='formtable' width='100%'><tr class='tdlabel'><td>CRN</td><td>TIPO</td></tr><tr><td>".@$sol_sug_crn_ret."</td><td>".nombre(@$sol_sug_crn_ret_tipo)."<td></tr></table>"; } ?></label>
			<script>if($('[name="sol_sug_crn_ret"]').attr('value')!=''){ $("#lb_sol_sug_crn_ret").html("<?php /*if(@$sol_sug_crn_ret!=''){*/ if(@$sol_sug_crn_ret_materia!='') echo "<table class='formtable' width='100%'><tr class='tdlabel'><td>CRN</td><td>MATERIA</td><td>SECCI&Oacute;N</td><td>PROFESOR(ES)</td><td>TIPO</td></tr><tr><td>".@$sol_sug_crn_ret."</td><td>".@$sol_sug_crn_ret_materia."</td><td>".@$sol_sug_crn_ret_seccion."</td><td>".@$sol_sug_crn_ret_instructor."</td><td>".nombre(@$sol_sug_crn_ret_tipo)."<td></tr></table>"; else echo "<table class='formtable' width='100%'><tr class='tdlabel'><td>CRN</td><td>TIPO</td></tr><tr><td>".@$sol_sug_crn_ret."</td><td>".nombre(@$sol_sug_crn_ret_tipo)."<td></tr></table>"; //} ?>"); }</script>
		</td>
	</tr>
</table>
<table class='formtable' width="100%">
	<tr>
		<td class="tdlabel" width="50%">Descripci&oacute;n: </td>
		<td><textarea id="sol_descripcion" name="sol_descripcion" rows="4" cols="20" style="width: 253px; height: 90px;"><?php echo $sol_descripcion?></textarea></td>		
	</tr>
	<?php if ($accion != 'actualizar'){?>
	<tr>
            <td colspan="2"><a id="various2" href="<?php echo base_url();?>index.php/solicitud/condiciones" target="_blank">Acepta t&eacute;rminos y condiciones&nbsp;&nbsp;</a><?php 
				$_POST['sol_tyc'] = isset($_POST['sol_tyc']) ? $_POST['sol_tyc'] : '0';
				$checked = ($_POST['sol_tyc']==='0')?FALSE:TRUE;
				echo form_checkbox('sol_tyc', '1', $checked );?></td>			
            <td>&nbsp;</td>
	</tr>
	<tr>
	<td>
	<?php }else{
		echo form_hidden('sol_tyc', set_value('sol_tyc',1)); 
	      }
	?>
	</td>
	<td>&nbsp;</td>
	</tr>
	<?php if ($accion == 'actualizar'): ?>	
	<tr>		
		<td class="tdlabel">Estado:</td><td> <?php echo $est_descripcion; ?></td>		
	</tr>
	<?php endif; ?>
	<tr>
		<td>
		<?php
		if($rol==3) //estudiante
			echo form_submit('submit', $titulo);
		else {
		?>
		<input type='button' name='boton2' id='boton2' value='<?php echo $titulo ?>' onclick='crear_solicitud("0")' />
		<?php } ?>
		</td>
		<td>&nbsp;</td>
	</tr>
	</table>
<?php echo form_close(); ?>
<br>
<?php if ($accion == 'actualizar'): ?>
<a href='javascript:;' onclick='show_me("comentarios")'>Ver Comentarios</a><br>
<a id="various1" href="#comentario_nuevo"><?php if($puede_comentar) echo 'Adicionar Comentario'; ?></a>
<div id='oculta_comentarios' style='display:none'>
	<div id='comentario_nuevo'>
	  <?php echo $comentario_form; ?>
	</div>
</div>
<div id='comentarios' style='display:none'>
  <?php echo $comentario_listado; ?>
</div>
<?php endif; ?>
<?php
if($rol==3) //estudiante
	$this->load->view("footer");
?>
<?php 
function nombre($tipo){
	switch ($tipo) {
		case 'mag':
		   $nombre_tipo = 'MAGISTRAL';
		   break;
		case 'com':
		   $nombre_tipo = 'COMPLEMENTARIA';
		   break;
		case '0':
		   $nombre_tipo = 'NORMAL';
		   break;  
		default:
		   $nombre_tipo = '';
	}
	return $nombre_tipo;
}
?>