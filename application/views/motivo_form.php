<?php
$this->load->view("header");
?>
<a  class="volver" href="<?php echo base_url()?>index.php/motivo/">Volver</a><br>
<?php if(validation_errors('<p class="error">','</p>')!=''){
echo form_open();
echo str_replace('&lt;', '<', str_replace('&gt;', '>', htmlentities(validation_errors('<p class="error">','</p>'), ENT_NOQUOTES)));
echo form_close();
} ?>
<?php echo form_open('motivo/'.$accion.'/'.$mov_id); ?>

	<h1><?php echo $titulo; ?> motivo</h1>
	<p>
		<label for="email">Descripci&oacute;n: </label>
		<?php echo form_input('descripcion', set_value('descripcion', $mov_descripcion)); ?>
		<?php //echo form_error('descripcion'); ?>
	</p>
	<p>
		<?php echo form_submit('submit', $titulo); ?>
	</p>
<?php echo form_close(); ?>
<?php
$this->load->view("footer");
?>