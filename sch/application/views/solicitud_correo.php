<p>
	<label>Login estudiante: </label>
	<?php echo $sol_login;?>				
</p>
<p>
	<label>Código estudiante: </label>
	<?php echo $codigo;?>				
</p>
<p>
	<label>Nombres y apellidos: </label>
	<?php echo $sol_nombre.' '.$sol_apellido;?>				
</p>
<p>
	<label>Tipo de Solicitud: </label>
	<?php echo $tipo;?>				
</p>
<p>
	<label>Motivo: </label>
	<?php echo $motivo;?>					
</p>
<? if(@$sol_disp_crn_ins!='') { ?>
<p>
	<label>Curso inscripci&oacute;n: </label>
	<?php echo @$sol_disp_crn_ins;?>					
</p>
<? } ?>
<? if(@$sol_disp_crn_ret!='') { ?>
<p>
	<label>Curso retiro: </label>
	<?php echo @$sol_disp_crn_ret;?>					
</p>
<? } ?>
<p>
	<label>Descripci&oacute;n: </label>
	<?php echo $descripcion;?>					
</p>