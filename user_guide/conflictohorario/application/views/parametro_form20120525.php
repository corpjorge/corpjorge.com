<?php
$this->load->view("header");
?>
<script>
function vaciar_fecha_final() {
	$("#fecha_final").val('');
}

$(function() {
    $('.datetime').datepicker({
    	duration: '',
        showTime: true,
        constrainInput: false,
        stepMinutes: 1,  
        stepHours: 1,  
        altTimeField: '',  
        time24h: true,
		dateFormat: 'yy-mm-dd',
		onSelect: function () {
			DP_jQuery.datepicker._hideDatepicker();
		}
     });
});
 
mensaje = '<?php if(!empty($mensaje))echo urldecode($mensaje);else echo '';?>';
if(mensaje!='')
	alert(mensaje);
</script>
<a class="volver"  href="<?php echo base_url()?>index.php/motivo/listado">Volver</a><br>
<?php if(validation_errors('<p class="error">','</p>')!=''){
echo form_open();
echo str_replace('&lt;', '<', str_replace('&gt;', '>', htmlentities(validation_errors('<p class="error">','</p>'), ENT_NOQUOTES)));
echo form_close();
} ?>
<?php echo form_open('parametro/actualizar/'); ?>
<h1><?php //echo $titulo; ?> Par&aacute;metros</h1>
<?php echo form_hidden('titulo', set_value('titulo', $titulo)); ?>
	<table class='formtable'>
	<tr>
		<td class="tdlabel">Periodo: </td>
		<td><?php echo form_input('periodo', set_value('periodo',$periodo)); ?>
		<?php //echo form_error('descripcion'); ?></td>
	</tr>
	<tr>
		<td class='tdlabel'>Correo: </td>
		<td><?php echo form_input('correo_from', set_value('correo_from',$correo_from)); ?>
		<?php //echo form_error('correo_from'); ?></td>
	</tr>
	<tr>
		<td class='tdlabel'>Nombre: </td>
		<td><?php echo form_input('nombre_from', set_value('nombre_from',$nombre_from)); ?>
		<?php //echo form_error('nombre_from'); ?></td>
	</tr>
	<tr>
		<td class='tdlabel'>T&eacute;rminos y condiciones: </td>
		<td>&nbsp;</td>
		
	</tr>
	<tr>
	  
	<td colspan="2"><textarea id="condiciones" name="condiciones" style="width: 530px; height: 76px;" rows="4" cols="20"><?php echo set_value('condiciones', $condiciones)?></textarea></td>	
	</tr>
	<tr>
		<td class='tdlabel'>Comentario est&aacute;ndar: </td>
		<td>&nbsp;</td>		
	</tr>
	<tr>	  
		<td colspan="2">
			<textarea id="comentario_normal" name="comentario_normal" style="width: 530px; height: 76px;" rows="4" cols="20"><?php echo set_value('comentario_normal', $comentario_normal)?></textarea>
		</td>	
	</tr>
	<tr>
		<td class='tdlabel'>Comentario est&aacute;ndar (cancelar): </td>
		<td>&nbsp;</td>		
	</tr>
	<tr>	  
		<td colspan="2">
			<textarea id="comentario_cancelar" name="comentario_cancelar" style="width: 530px; height: 76px;" rows="4" cols="20"><?php echo set_value('comentario_cancelar', $comentario_cancelar)?></textarea>
		</td>	
	</tr>
	<tr>
		<td class='tdlabel'>Comentario est&aacute;ndar (cambiar estado): </td>
		<td>&nbsp;</td>		
	</tr>
	<tr>	  
		<td colspan="2">
			<textarea id="comentario_cambiar_estado" name="comentario_cambiar_estado" style="width: 530px; height: 76px;" rows="4" cols="20"><?php echo set_value('comentario_cambiar_estado', $comentario_cambiar_estado)?></textarea>
		</td>	
	</tr>
	<tr>
	<tr>
		<td class="tdlabel">Validar Suspensiones Acad&eacute;micas:
		<?php
		$_POST['suspensionesa'] = isset($_POST['suspensionesa']) ? $_POST['suspensionesa'] : '0';
		$check = validation_errors()!='' ? $_POST['suspensionesa'] : $suspensionesa;		
		 $checked = ($check==='0')?FALSE:TRUE;		 
		 $valores = array(
			'name'        => 'suspensionesa',
			'id'          => 'suspensionesa',
			'value'       => 1,
			'checked'     => $checked			
		 );
		 echo form_checkbox($valores);
		?>
		<?php //echo form_error('descripcion'); ?></td>
	</tr>
	<tr>
		<td class="tdlabel">Validar Suspensiones Disciplinarias: 
		<?php
		$_POST['suspensionesd'] = isset($_POST['suspensionesd']) ? $_POST['suspensionesd'] : '0';
		$check = validation_errors()!='' ? $_POST['suspensionesd'] : $suspensionesd;
		 $checked = ($check==='0')?FALSE:TRUE;
		 $valores = array(
			'name'        => 'suspensionesd',
			'id'          => 'suspensionesd',
			'value'       => 1,
			'checked'     => $checked,			
		 );
		 echo form_checkbox($valores);
		?>
		<?php //echo form_error('descripcion'); ?>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td class="tdlabel">Validar Retenciones:
		<?php
		$_POST['restricciones'] = isset($_POST['restricciones']) ? $_POST['restricciones'] : '0';
		$check = validation_errors()!='' ? $_POST['restricciones'] : $restricciones;
		 $checked = ($check==='0')?FALSE:TRUE;
		 $valores = array(
			'name'        => 'restricciones',
			'id'          => 'restricciones',
			'value'       => 1,
			'checked'     => $checked,			
		 );
		 echo form_checkbox($valores);
		?>
		<?php //echo form_error('descripcion'); ?>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td class="tdlabel">Validar Niveles:
		<?php
		$_POST['niveles'] = isset($_POST['niveles']) ? $_POST['niveles'] : '0';
		$check = validation_errors()!='' ? $_POST['niveles'] : $niveles;
		 $checked = ($check==='0')?FALSE:TRUE;
		 $valores = array(
			'name'        => 'niveles',
			'id'          => 'niveles',
			'value'       => 1,
			'checked'     => $checked,			
		 );
		 echo form_checkbox($valores);
		?>
		<?php //echo form_error('descripcion'); ?>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td class="tdlabel">Validar Turno Galp&oacute;n:
		<?php
		$_POST['galpon'] = isset($_POST['galpon']) ? $_POST['galpon'] : '0';
		$check = validation_errors()!='' ? $_POST['galpon'] : $galpon;
		 $checked = ($check==='0')?FALSE:TRUE;
		 $valores = array(
			'name'        => 'galpon',
			'id'          => 'galpon',
			'value'       => 1,
			'checked'     => $checked,			
		 );
		 echo form_checkbox($valores);
		?>
		<?php //echo form_error('descripcion'); ?>		
		</td>
		<td>&nbsp;</td>		
	</tr>
	<tr>
		<td class="tdlabel">Fecha Final: <input type="text" name="fecha_final" id="fecha_final" value="<?php echo set_value('fecha_final', @$fecha_final); ?>" class="datetime" readonly>
		&nbsp;
		<?php
		$js = 'onClick="vaciar_fecha_final()"';
		echo form_button('bt_fecha_final', 'Vaciar', $js);
		?>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><?php echo form_submit('submit', 'Actualizar'); ?></td>
		<td>&nbsp;</td>
	</tr>
	</table>
<?php echo form_close(); ?>
<?php
$this->load->view("footer");
?>