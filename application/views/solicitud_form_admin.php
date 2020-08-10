<?php
$this->load->view("header"); 
?>
<script type="text/javascript">

$( document ).ajaxStart(function() {
	$body = $("body");
	$body.addClass("loading");
});
$( document ).ajaxStop(function() {
	$body = $("body");
	$body.removeClass("loading");
});


function get_carne(){
	var id = $('#UACarnetEstudiante').val();    
	$.ajax({
		url: '<?php echo base_url()?>index.php/solicitud/carne/'+id,
		data: 'carne='+id.replace(/^\s+/g,'').replace(/\s+$/g,''),
		type: "POST",
		success: function(html){
			//alert(html);
			if(html!="NO"){
				if(html=='nivel_no_permitido'){
					alert('Nivel no permitido');
					window.location.href='<?php echo base_url()?>index.php/solicitud/';
				}
				else { //recibe json con datos del estudiante
					$('#boton_buscar').css("display", "none");
					crear_solicitud(html);
				}
			}
			else
				alert('C\u00f3digo no encontrado');
		}
	});
}

function crear_solicitud(json){
	var data1 = $('#form_solicitud').serialize();
	var no_validar = json!='0' ? 'no' : '';
	data1 = data1 + "&UACarnetEstudiante=" + $("#UACarnetEstudiante").attr('value');
	$("#boton2").attr("disabled","disabled");
	//alert(data1);
	$.ajax({
		url: '<?php echo base_url()?>index.php/solicitud/crear/' + no_validar, //la primera vez no valida
		data: data1,		
		type: "POST",
		success: function(html){
			//alert('-' + html + '-');
			if(html=="	OK" || html=="OK"){
				alert('Su solicitud de conflicto de Horario se ha enviado con \u00e9xito');
				window.location.href='<?php echo base_url()?>index.php/solicitud/';
			}
			else{
				var pat = /El Periodo de creaci&oacute;n de solicitudes ha finalizado/; 
				if(pat.test(html))
					$('#boton_buscar').css("display", "inline");
				$("#solicitud_nueva").html(html);
			}
			if(json!='0')
				asignar_datos(json);
		}
	});
}

function asignar_datos(json){
	//alert(json);
	var datos = eval('(' + json + ')');
	$('[name="sol_nombre"]').val(datos.sol_nombre);
    $('[name="sol_apellido"]').val(datos.sol_apellido);
    $('[name="sol_email"]').val(datos.sol_email);
    $('[name="sol_login"]').val(datos.sol_login);
	$('[name="dep_id"]').val(datos.dep_id);
	$('[name="dep_id_sec"]').val(datos.dep_id_sec);
	$('[name="sol_nivel"]').val(datos.sol_nivel);
	
	$('[name="sol_uidnumber"]').val(datos.sol_uidnumber);
	$('[name="sol_pidm"]').val(datos.sol_pidm);
	$('[name="pidm"]').val(datos.sol_pidm);
	
	$('#lb_sol_nombre').html(datos.sol_nombre);
	$('#lb_sol_apellido').html(datos.sol_apellido);
	
	$('[name="sol_ssc"]').val(datos.sol_ssc);
	$('[name="sol_primer_sem"]').val(datos.sol_primer_sem);
	$('[name="sol_primer_semes_msg"]').val(datos.sol_primer_semes_msg);
	$('[name="sol_opcion_estud"]').val(datos.sol_opcion_estud);
	
	$('input[name="sol_email"]').attr('readOnly','readOnly');
    $('input[name="sol_login"]').attr('readOnly','readOnly');
    $('input[name="sol_email"], input[name="sol_login"]').css({'border':'none','background':'none','width':'200px','color':'#808080'})
}
</script>
<a class="volver"  href="<?php echo base_url()?>index.php/solicitud/">Volver</a><br>
<?php if(validation_errors('<p class="error">','</p>')!=''){
echo form_open();
echo str_replace('&lt;', '<', str_replace('&gt;', '>', htmlentities(validation_errors('<p class="error">','</p>'), ENT_NOQUOTES)));
echo form_close();
} ?>
<?php echo form_open(); ?>

	<p>
		<table class='formtable'>
			<tr>
				<td class="tdlabel"><label for="UACarnetEstudiante">C&oacute;digo estudiante: </label></td>		
				<td class="tdlabel"><input type='text' name='UACarnetEstudiante' id='UACarnetEstudiante' value=''></td>
				<td class="tdlabel"><input type='button' name='boton_buscar' id='boton_buscar' value='Buscar' onclick='get_carne()' /></td>
			</tr>
		</table>
	</p>
	<div id='solicitud_nueva' ></div>
	<div class="modalAjax"></div>
<?php echo form_close(); ?>
<?php
$this->load->view("footer");
?>