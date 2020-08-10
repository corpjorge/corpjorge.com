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
<h1>Solicitud de ajuste de horario</h1>
<p>
	Estimado estudiante, hemos recibido su solicitud de ajuste de horario.  Esta ser&aacute; tramitada por la coordinaci&oacute;n acad&eacute;mica del departamento que ofrece la materia y se le dar&aacute; respuesta por este mismo medio 
</p>
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
<?$labelEstado=($estadoPadre)?"Sub Estado":"Estado Principal";?>
        <?if($estadoPadre){?>
<p>		
	<label>Estado Principal: <?php echo $estadoPadre; ?></label>
</p>
<?}?>
<p>		
	<label><?php echo $labelEstado; ?>: <?php echo $estado; ?></label>
</p>
<?php
//$this->load->view("footer");
?>