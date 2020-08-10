<?php
$this->load->view("header");
?>
<script>
function show_me(id){
	estado  = $("#"+id).css("display");
	if(estado=="none"){
		$("#"+id).show();		
	}else{
		$("#"+id).hide();
	}	 
}
</script>
<a  class="volver" href="<?php echo base_url()?>index.php/departamento/">Volver</a><br>
<?php if(validation_errors('<p class="error">','</p>')!=''){
echo form_open();
echo str_replace('&lt;', '<', str_replace('&gt;', '>', htmlentities(validation_errors('<p class="error">','</p>'), ENT_NOQUOTES)));
echo form_close();
} ?>
<?php echo form_open('departamento/'.$accion.'/'.$dep_id); ?>

	<h1><?php echo $titulo; ?> programa</h1>
	<p>
		<label for="email">C&oacute;digo: </label>
		<?php echo $dep_id; ?>
	</p>
	<p>
		<label for="email">Nombre: </label>
		<?php //echo form_error('dep_nombre'); ?>
		<?php //echo form_input('dep_nombre', set_value('dep_nombre', $dep_nombre)); ?>
		<?php echo $dep_nombre; ?>
	</p>
    <!--<p>
		<label for="email">Nombre externo: </label>
		<?php //echo form_error('dep_externo'); ?>
		<?php //echo form_input('dep_externo', set_value('dep_externo', $dep_externo)); ?>		
	</p>-->
	<!--<p>
		<?php //echo form_submit('submit', $accion); ?>
	</p>-->
<?php echo form_close(); ?>
<br>
<?php if ($accion == 'actualizar'): ?>
<!--<a href='javascript:;' onclick='show_me("limites")'>Actualizar Limites</a>-->
<div id='limites' style='display:block'>
  <?php echo $limite_form?>
</div>
<?php endif; ?>
<?php
$this->load->view("footer");
?>