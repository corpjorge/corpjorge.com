<?php
$this->load->view("header");
function nombre_tipo($tipo, $sug=''){
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
}

if(substr_count($sol_id, '-') < 2){
	$filas = explode(';',$ordenfilas);
	foreach($filas as $indice=>$fila){
		if(str_replace('-', '', $sol_id)==$fila){		
			$sol_id_anterior = $indice == 0 ? $filas[count($filas) - 1] : $filas[$indice - 1];
			$sol_id_siguiente = $indice == count($filas) - 1 ? $filas[0] : $filas[$indice + 1];		
		}	
	}
	//echo "sol_id $sol_id<br>$ordenfilas - $sol_id $sol_id_anterior - $sol_id_siguiente";	
}
?>
<script type="text/javascript">
function enviar_comentados(){
	$('#comentaform').submit();
  
}

function poner_comentario(texto){
	$("#com_texto").val($('[name="'+ texto +'"]').attr('value'));
}
</script>
<a class="volver" href="<?php echo base_url()?>index.php/solicitud/">Volver</a><br>
<?php if(substr_count($sol_id, '-') < 2){ ?>
<div style="text-align:center">
	<a href="<?php echo base_url()?>index.php/solicitud/formacomentario/<?php echo $sol_id_anterior; ?>">Anterior</a> | <a href="<?php echo base_url()?>index.php/solicitud/formacomentario/<?php echo $sol_id_siguiente; ?>">Siguiente</a><br>
</div>
<?php } ?>

<?php if(validation_errors('<p class="error">','</p>')!=''){
echo form_open();
echo str_replace('&lt;', '<', str_replace('&gt;', '>', htmlentities(validation_errors('<p class="error">','</p>'), ENT_NOQUOTES)));
echo form_close();
} ?>

<?php if($tipo=='uno'){?>
	<form>
	<h1><?php echo $titulo; ?> solicitud</h1>
	<table class='formtable'>
	<tr>
		<td class="tdlabel">Solicitud de  <?php echo $sol_nombre;?> <?php echo @$sol_apellido;?></td>
		<td class="tdlabel">C&oacute;digo <?php echo @$sol_uidnumber;?></td>
	</tr>
	<tr>
		<td class="tdlabel">Fecha: </td>
		<td><?php echo $sol_fec_creacion;?></td>
	</tr>	
        <tr>
		<td class="tdlabel">Tipo de Solicitud: </td>
		<td><?php echo $tipo;?></td>	
	</tr>
        <tr>
		<td class="tdlabel">Motivo: </td>
		<td><?php echo $motivo;?></td>	
	</tr>
	<!--<? if(@$sol_mag_crn_ret_des!='') { ?>
	<tr id='crn_mag_1' >
		<td class="tdlabel">CRN (origen) : </td>
		<td><?php echo  @$sol_mag_crn_ret_des;?></td>
	</tr>
	<? } ?>
	<? if(@$sol_mag_crn_ins_des!='') { ?>
	<tr id='crn_mag_2' >
		<td class="tdlabel">CRN (destino): </td>
		<td><?php echo @$sol_mag_crn_ins_des;?></td>
	</tr>
	<? } ?>
	<? if(@$sol_com_crn_ret_des!='') { ?>
	<tr id='crn_com_1' >
		<td class="tdlabel">CRN (complementario origen): </td>
		<td><?php echo @$sol_com_crn_ret_des?></td>
	</tr>
	<? } ?>
	<? if(@$sol_com_crn_ins_des!='') { ?>
	<tr id='crn_com_2' >
		<td class="tdlabel">CRN (complementario destino): </td>
		<td><?php	echo @$sol_com_crn_ins_des; ?></td>
	</tr>
	<? } ?>-->
	<? if(@$sol_ins_des!='') { ?>
	<tr id='crn_mag_1' >
		<td class="tdlabel">CRN Inscripci&oacute;n<?php echo nombre_tipo(@$sol_ins_tipo); ?>: </td>
		<td><?php echo @$sol_ins_crn.' - '. @$sol_ins_des;?></td>
	</tr>
	<? } ?>
	<? if(@$sol_ins_mat!='') { ?>
	<tr>
		<td class="tdlabel">&nbsp;&nbsp;&nbsp;&nbsp;C&oacute;digo: </td>
		<td><?php echo  @$sol_ins_mat;?></td>
	</tr>
	<? } ?>
	<? if(@$sol_ins_seccion!='') { ?>
	<tr>
		<td class="tdlabel">&nbsp;&nbsp;&nbsp;&nbsp;Secci&oacute;n: </td>
		<td><?php echo  @$sol_ins_seccion;?></td>
	</tr>
	<? } ?>
	<? if(@$sol_ins_instructor!='') { ?>
	<tr>
		<td class="tdlabel">&nbsp;&nbsp;&nbsp;&nbsp;Instructor: </td>
		<td><?php echo  @$sol_ins_instructor;?></td>
	</tr>
	<? } ?>
	<? if(@$sol_ins_tipo!='') { ?>
	<tr>
		<td class="tdlabel">&nbsp;&nbsp;&nbsp;&nbsp;Tipo: </td>
		<td><?php echo  @$sol_ins_tipo;?></td>
	</tr>
	<? } ?>
	<? if(@$sol_ret_des!='') { ?>
	<tr id='crn_mag_2' >
		<td class="tdlabel">CRN Retiro<?php echo nombre_tipo(@$sol_ins_tipo); ?>: </td>
		<td><?php echo @$sol_ret_crn.' - '.@$sol_ret_des;?></td>
	</tr>
	<? } ?>
	<? if(@$sol_ret_mat!='') { ?>
	<tr>
		<td class="tdlabel">&nbsp;&nbsp;&nbsp;&nbsp;C&oacute;digo: </td>
		<td><?php echo  @$sol_ret_mat;?></td>
	</tr>
	<? } ?>
	<? if(@$sol_ret_seccion!='') { ?>
	<tr>
		<td class="tdlabel">&nbsp;&nbsp;&nbsp;&nbsp;Secci&oacute;n: </td>
		<td><?php echo  @$sol_ret_seccion;?></td>
	</tr>
	<? } ?>
	<? if(@$sol_ret_instructor!='') { ?>
	<tr>
		<td class="tdlabel">&nbsp;&nbsp;&nbsp;&nbsp;Instructor: </td>
		<td><?php echo  @$sol_ret_instructor;?></td>
	</tr>
	<? } ?>
	<? if(@$sol_ret_tipo!='') { ?>
	<tr>
		<td class="tdlabel">&nbsp;&nbsp;&nbsp;&nbsp;Tipo: </td>
		<td><?php echo  @$sol_ret_tipo;?></td>
	</tr>
	<? } ?>
	<? if(@$sol_sug_ins_des!='') { ?>
	<tr id='crn_com_1' >
		<td class="tdlabel">CRN Sugerencia Inscripci&oacute;n<?php echo nombre_tipo(@$sol_ins_tipo, 'sug'); ?>: </td>
		<td><?php echo @$sol_sug_ins_crn.' - '.@$sol_sug_ins_des;?></td>
	</tr>
	<? } ?>
	<? if(@$sol_sug_ins_mat!='') { ?>
	<tr>
		<td class="tdlabel">&nbsp;&nbsp;&nbsp;&nbsp;C&oacute;digo: </td>
		<td><?php echo  @$sol_sug_ins_mat;?></td>
	</tr>
	<? } ?>
	<? if(@$sol_sug_ins_seccion!='') { ?>
	<tr>
		<td class="tdlabel">&nbsp;&nbsp;&nbsp;&nbsp;Secci&oacute;n: </td>
		<td><?php echo  @$sol_sug_ins_seccion;?></td>
	</tr>
	<? } ?>
	<? if(@$sol_sug_ins_instructor!='') { ?>
	<tr>
		<td class="tdlabel">&nbsp;&nbsp;&nbsp;&nbsp;Instructor: </td>
		<td><?php echo  @$sol_sug_ins_instructor;?></td>
	</tr>
	<? } ?>
	<? if(@$sol_sug_ins_tipo!='') { ?>
	<tr>
		<td class="tdlabel">&nbsp;&nbsp;&nbsp;&nbsp;Tipo: </td>
		<td><?php echo  @$sol_sug_ins_tipo;?></td>
	</tr>
	<? } ?>
	<? if(@$sol_sug_ret_des!='') { ?>
	<tr id='crn_com_2' >
		<td class="tdlabel">CRN Sugerencia Retiro<?php echo nombre_tipo(@$sol_ins_tipo, 'sug'); ?>: </td>
		<td><?php echo @$sol_sug_ret_crn.' - '.@$sol_sug_ret_des; ?></td>
	</tr>
	<? } ?>
	<? if(@$sol_sug_ret_mat!='') { ?>
	<tr>
		<td class="tdlabel">&nbsp;&nbsp;&nbsp;&nbsp;C&oacute;digo: </td>
		<td><?php echo  @$sol_sug_ret_mat;?></td>
	</tr>
	<? } ?>
	<? if(@$sol_sug_ret_seccion!='') { ?>
	<tr>
		<td class="tdlabel">&nbsp;&nbsp;&nbsp;&nbsp;Secci&oacute;n: </td>
		<td><?php echo  @$sol_sug_ret_seccion;?></td>
	</tr>
	<? } ?>
	<? if(@$sol_sug_ret_instructor!='') { ?>
	<tr>
		<td class="tdlabel">&nbsp;&nbsp;&nbsp;&nbsp;Instructor: </td>
		<td><?php echo  @$sol_sug_ret_instructor;?></td>
	</tr>
	<? } ?>
	<? if(@$sol_sug_ret_tipo!='') { ?>
	<tr>
		<td class="tdlabel">&nbsp;&nbsp;&nbsp;&nbsp;Tipo: </td>
		<td><?php echo  @$sol_sug_ret_tipo;?></td>
	</tr>
	<? } ?>
	<tr>
		<td class='tdlabel'>Descripci&oacute;n: </td>
		<td><?php echo $sol_descripcion?></td>
	</tr>	
	<tr>		
		<td class="tdlabel">Estado: </td>
		<td><?php echo $estado; ?></td>
	</tr>
	</table>	
	</form>
	<?php }else{//end if de uno?>
		<form>
		<table class='formtable'>
		<?php if($mensaje_cancelados!=''){ ?>
			<tr>		
			<td class="tdlabel"><?php echo $mensaje_cancelados ?></td>
			</tr>
		<?php } ?>
		<tr>		
		<td class="tdlabel"><?php echo $mensaje_gestion ?></td>
		</tr>
		<?php if(!empty($ids_habilitados)){?>
		<tr>		
		<td class="tdlabel"><?php echo $mensaje_varios ?></td>
		</tr>		
		<?php }?>
		</table>
		</form>
	<?php } ?>	
	<?php if(!empty($ids_habilitados)){?>
	 <form name='comentaform' id='comentaform' action='<?php echo base_url()?>index.php/solicitud/comentar_masivo' method='POST'>
	<table id='comentario_nuevo' class='formtable'>		
		<tr>
		 <td class="tdlabel">Comentario asociado : </td>
		 <td><textarea style="width: 253px; height: 90px;" id="com_texto" name="com_texto" rows="4" cols="20"><?php if(validation_errors()!='') echo set_value('com_texto', @$com_texto); ?></textarea></td>		 
		</tr>
		<tr>
			<td colspan="2">
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
			</td>
		</tr>
		<tr>
			<td><input type='button' value='Enviar' onclick='enviar_comentados()'><?php echo form_hidden('sol_id', $ids_habilitados);?></td>
			<td></td>
				
		</tr>
	 </table>
	</form>
	<?php }else{ ?>
	<form>
	<table id='comentario_nuevo' class='formtable'>
	<tr>		
	 <td class="tdlabel">A ninguna de las solicitudes elegidas se puede enviar comentario</td>
	</tr>
	</table>
	 </form>
	<?php }?>
		

<?php
$this->load->view("footer");
?>