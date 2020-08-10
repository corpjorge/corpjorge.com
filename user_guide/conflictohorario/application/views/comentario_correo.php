<?php 
//$this->load->view("header");
/*function nombre_tipo($tipo, $sug=''){
switch($tipo){
	case 'MAGISTRAL':
		$nombre_tipo = $sug=='' ? ' Magistral' : ' Complementaria';
		break;
	case 'COMPLEMENTARIA':
		$nombre_tipo = $sug=='' ? ' Complementaria' : ' Magistral';
		break;
	default:
	   $nombre_tipo = '';
	}
	return $nombre_tipo;
}*/
?>
<h1>Solicitud</h1>
<p>
	<label>Solicitud de <?php echo $sol_nombre;?> <?php echo $sol_apellido;?><br>C&oacute;digo <?php echo @$sol_uidnumber;?></label>						
</p>
<p>
	<label>Ticket: </label>
	<?php echo $sol_ticket;?>				
</p>
<p>
	<label>Fecha: </label>
	<?php echo $sol_fec_creacion;?>				
</p>	
	<p>
	<label>Tipo de Solicitud: </label>
	<?php echo $tipo;?>				
</p>
	<p>
	<label>Motivo: </label>
	<?php echo $motivo;?>					
</p>
<!--<? if(@$sol_mag_crn_ret_des!='') { ?>
<p id='crn_mag_1' style='display:block'>
	<label>CRN (origen) : </label>
	<?php echo  @$sol_mag_crn_ret_des;?>						
</p>
<? } ?>
<? if(@$sol_mag_crn_ins_des!='') { ?>
<p id='crn_mag_2' style='display:block'>
	<label>CRN (destino): </label>
	<?php echo @$sol_mag_crn_ins_des;?>						
</p>
<? } ?>
<? if(@$sol_com_crn_ret_des!='') { ?>
<p id='crn_com_1' style='display:block'>
	<label>CRN (complementario origen): </label>
	<?php echo @$sol_com_crn_ret_des?>
</p>
<? } ?>
<? if(@$sol_com_crn_ins_des!='') { ?>
<p id='crn_com_2' style='display:block'>
	<label>CRN (complementario destino): </label>
	<?php echo @$sol_com_crn_ins_des; ?>						
</p>
<? } ?>-->
<? if(@$sol_ins_des!='') { ?>
<p id='crn_mag_1' >
	<label>CRN Inscripci&oacute;n<?php echo @$tipo_crn_ins; /*nombre_tipo(@$sol_ins_tipo)*/; ?>: </label>
	<?php echo @$sol_ins_crn.' - '. @$sol_ins_des;?>
</p>
<? } ?>
<? if(@$sol_ins_mat!='') { ?>
<p>
	<label>&nbsp;&nbsp;&nbsp;&nbsp;C&oacute;digo: </label>
	<?php echo  @$sol_ins_mat;?>
</p>
<? } ?>
<? if(@$sol_ins_seccion!='') { ?>
<p>
	<label>&nbsp;&nbsp;&nbsp;&nbsp;Secci&oacute;n: </label>
	<?php echo  @$sol_ins_seccion;?>
</p>
<? } ?>
<? if(@$sol_ins_instructor!='') { ?>
<p>
	<label>&nbsp;&nbsp;&nbsp;&nbsp;Instructor: </label>
	<?php echo  @$sol_ins_instructor;?>
</p>
<? } ?>
<? if(@$sol_ins_tipo!='') { ?>
<p>
	<label>&nbsp;&nbsp;&nbsp;&nbsp;Tipo: </label>
	<?php echo  @$sol_ins_tipo;?>
</p>
<? } ?>
<? if(@$sol_ret_des!='') { ?>
<p id='crn_mag_2' >
	<label>CRN Retiro<?php echo @$tipo_crn_ins; /*nombre_tipo(@$sol_ins_tipo)*/; ?>: </label>
	<?php echo @$sol_ret_crn.' - '.@$sol_ret_des;?>
</p>
<? } ?>
<? if(@$sol_ret_mat!='') { ?>
<p>
	<label>&nbsp;&nbsp;&nbsp;&nbsp;C&oacute;digo: </label>
	<?php echo  @$sol_ret_mat;?>
</p>
<? } ?>
<? if(@$sol_ret_seccion!='') { ?>
<p>
	<label>&nbsp;&nbsp;&nbsp;&nbsp;Secci&oacute;n: </label>
	<?php echo  @$sol_ret_seccion;?>
</p>
<? } ?>
<? if(@$sol_ret_instructor!='') { ?>
<p>
	<label>&nbsp;&nbsp;&nbsp;&nbsp;Instructor: </label>
	<?php echo  @$sol_ret_instructor;?>
</p>
<? } ?>
<? if(@$sol_ret_tipo!='') { ?>
<p>
	<label>&nbsp;&nbsp;&nbsp;&nbsp;Tipo: </label>
	<?php echo  @$sol_ret_tipo;?>
</p>
<? } ?>
<? if(@$sol_sug_ins_des!='') { ?>
<p id='crn_com_1' >
	<label>CRN Sugerencia Inscripci&oacute;n<?php echo @$tipo_crn_ret /*nombre_tipo(@$sol_ins_tipo, 'sug')*/; ?>: </label>
	<?php echo @$sol_sug_ins_crn.' - '.@$sol_sug_ins_des;?>
</p>
<? } ?>
<? if(@$sol_sug_ins_mat!='') { ?>
<p>
	<label>&nbsp;&nbsp;&nbsp;&nbsp;C&oacute;digo: </label>
	<?php echo  @$sol_sug_ins_mat;?>
</p>
<? } ?>
<? if(@$sol_sug_ins_seccion!='') { ?>
<p>
	<label>&nbsp;&nbsp;&nbsp;&nbsp;Secci&oacute;n: </label>
	<?php echo  @$sol_sug_ins_seccion;?>
</p>
<? } ?>
<? if(@$sol_sug_ins_instructor!='') { ?>
<p>
	<label>&nbsp;&nbsp;&nbsp;&nbsp;Instructor: </label>
	<?php echo  @$sol_sug_ins_instructor;?>
</p>
<? } ?>
<? if(@$sol_sug_ins_tipo!='') { ?>
<p>
	<label>&nbsp;&nbsp;&nbsp;&nbsp;Tipo: </label>
	<?php echo  @$sol_sug_ins_tipo;?>
</p>
<? } ?>
<? if(@$sol_sug_ret_des!='') { ?>
<p id='crn_com_2' >
	<label>CRN Sugerencia Retiro<?php echo @$tipo_crn_ret /*nombre_tipo(@$sol_ins_tipo, 'sug')*/; ?>: </label>
	<?php echo @$sol_sug_ret_crn.' - '.@$sol_sug_ret_des; ?>
</p>
<? } ?>
<? if(@$sol_sug_ret_mat!='') { ?>
<p>
	<label>&nbsp;&nbsp;&nbsp;&nbsp;C&oacute;digo: </label>
	<?php echo  @$sol_sug_ret_mat;?>
</p>
<? } ?>
<? if(@$sol_sug_ret_seccion!='') { ?>
<p>
	<label>&nbsp;&nbsp;&nbsp;&nbsp;Secci&oacute;n: </label>
	<?php echo  @$sol_sug_ret_seccion;?>
</p>
<? } ?>
<? if(@$sol_sug_ret_instructor!='') { ?>
<p>
	<label>&nbsp;&nbsp;&nbsp;&nbsp;Instructor: </label>
	<?php echo  @$sol_sug_ret_instructor;?>
</p>
<? } ?>
<? if(@$sol_sug_ret_tipo!='') { ?>
<p>
	<label>&nbsp;&nbsp;&nbsp;&nbsp;Tipo: </label>
	<?php echo  @$sol_sug_ret_tipo;?>
</p>
<? } ?>
<p>
	<label for="sol_descripcion">Descripci&oacute;n: </label>
	<?php echo $sol_descripcion?>                
</p>	
<p>		
	<label>Estado: <?php echo $estado; ?></label>
</p>
<? if(@$com_texto!=''){ ?>
<p>		
	<label>Comentario: </label>
	<table width="80%" border="0">
		<tr>
			<td class="cellh">Login </td>
			<td class="cellh">Rol </td>
			<td class="cellh">Remite </td>
			<td class="cellh">Mensaje</td>
			<td class="cellh">Fecha/Hora</td>
		</tr>
		<tr>
			<td class="cell"><?php echo "<strong>".@$com_login."</strong>"?></td>
			<td class="cell"><?php echo "<strong>".@$rol_descripcion."</strong>"?></td>
			<td class="cell"><?php echo @$com_nombre." dice:"?></td>
			<td class="cell"><?php echo @$com_texto?></td>
			<td class="cell"><?php echo @$com_fecha?></td>
		</tr>
	</table>
</p>
<? } ?>
<?php
//$this->load->view("footer");
?>