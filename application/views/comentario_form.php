<script type="text/javascript">
function save_comentario(id, accion){
    var data1 = $('#form_comentario').serialize();
    //alert(data1);
    $.ajax({
      url: '<?php echo base_url()?>index.php/solicitud/relate/'+id,
      data: data1,
      type: "POST",
      success: function(html){
	  //html = html.replace('@', '	');
	  //alert("-" + html + "-");
	if(html=="	OK") { //se esta adicionando un tabulado al ok
		if(accion=='comentario') {
			window.location.href='<?php echo base_url()?>index.php/solicitud/' + accion + '/';
		}
		/*if(accion=='estado') {
			window.location.href='<?php echo base_url()?>index.php/solicitud/' + accion + '/' + id;
		}*/		
	}
	else
	$("#comentario_nuevo").html(html);
      }
    });
}

function poner_comentario(texto){	
	$("#com_texto").val($('[name="'+ texto +'"]').attr('value'));
}
</script>
<?php if(validation_errors('<p class="error">','</p>')!=''){
echo form_open();
echo str_replace('&lt;', '<', str_replace('&gt;', '>', htmlentities(validation_errors('<p class="error">','</p>'), ENT_NOQUOTES)));
echo form_close();
} ?>
<?php
    $attributes = array('id' => 'form_comentario');
    echo form_open('solicitud/relate/'.$sol_id,$attributes);
?>
<?php echo form_hidden('accion', set_value('accion', $accion)); ?>

	<p>
		<?php echo $rol_descripcion;?>
	</p>
	<p>
		<?php echo $com_nombre." dice: ";?>
	</p>	
	<p>
		<label for="com_texto">Texto: </label>
		<textarea id="com_texto" name="com_texto" rows="4" cols="20"><?php if(validation_errors()!='') echo set_value('com_texto', @$com_texto); ?></textarea>
	</p>
	<?php if(@$rol_id!='3'){ ?>
	<p>
		<table class='formtable'>
			<tr>				
				<td>
				<?php $checked = @$_POST['tipo_comentario']=='comentario_normal' ? TRUE : FALSE; ?>
				<?php $js = 'onClick="poner_comentario(this.value)"'; echo form_radio('tipo_comentario', 'comentario_normal', $checked, $js) ?></td><td>Comentario General</td>
			</tr>
			<tr>
				<td>
				<?php $checked = @$_POST['tipo_comentario']=='comentario_cancelar' ? TRUE : FALSE; ?>
				<?php echo form_radio('tipo_comentario', 'comentario_cancelar', $checked, $js) ?></td><td>Comentario (cancelar)</td>
			</tr>
			<tr>			
				<td>
				<?php $checked = @$_POST['tipo_comentario']=='comentario_cambiar_estado' ? TRUE : FALSE; ?>
				<?php echo form_radio('tipo_comentario', 'comentario_cambiar_estado', $checked, $js) ?></td><td>Comentario (cambiar estado)</td>
			</tr>
		</table>
		<?php echo form_hidden('comentario_normal', set_value('comentario_normal', $comentario_normal)); ?>
		<?php echo form_hidden('comentario_cancelar', set_value('comentario_cancelar', $comentario_cancelar)); ?>
		<?php echo form_hidden('comentario_cambiar_estado', set_value('comentario_cambiar_estado', $comentario_cambiar_estado)); ?>
	</p>
	<?php } ?>
	<?php if($accion=='comentario') { ?>
	<p>
		<input type="button" value="Guardar" onclick="save_comentario(<?php echo "$sol_id, '$accion'"?>)">
	</p>
	<?php } ?>
<?php echo form_close(); ?>
