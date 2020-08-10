<html>
<head>
<title>Nivel</title>
</head>
<body>
<?php echo validation_errors(); ?>
<?php echo form_open('NivelController/'.$accion.'/'.$niv_id); ?>
<?php echo validation_errors('<p class="error">','</p>'); ?>
	<h1><?php echo $accion; ?> Nivel</h1>
	<p>
		<label for="email">Descripción: </label>
		<?php echo form_error('descripcion'); ?>
		<?php echo form_input('descripcion', set_value('descripcion', $niv_descripcion)); ?>		
	</p>
	<p>
		<?php echo form_submit('submit', $accion); ?>
	</p>
<?php echo form_close(); ?>
</form>
</body>
</html>
