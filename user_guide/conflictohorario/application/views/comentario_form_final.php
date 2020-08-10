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
</script>
<?php echo validation_errors(); ?>
<?php
    $attributes = array('id' => 'form_comentario');
    echo form_open('solicitud/relate/'.$sol_id,$attributes);
?>
<?php echo form_hidden('accion', set_value('accion', $accion)); ?>
<?php echo validation_errors('<p class="error">','</p>'); ?>
	<p>
		<?php echo $rol_descripcion;?>
	</p>
	<p>
		<?php echo $com_nombre."dice: ";?>
	</p>	
	<p>
		<label for="com_texto">Texto: </label>
		<textarea id="com_texto" name="com_texto" rows="4" cols="20"><?php //echo $com_texto?></textarea>
		<?php //echo form_error('com_texto'); ?>
	</p>	
	<?php if($accion=='comentario') { ?>
	<p>
		<input type="button" value="Guardar" onclick="save_comentario(<?php echo "$sol_id, '$accion'"?>)">
	</p>
	<?php } ?>
<?php echo form_close(); ?>
