<?php 
$masivo = $this->input->get('masivo');

if (!empty($masivo))
{
	$this->load->view("header");
}
 ?>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<style type="text/css">
<?php 
$masivo = $this->input->get('masivo');

if (empty($masivo))
{
	echo "*{font-family: Arial;font-size: 12px;}.formtable{background: #E6E6E6;padding: 7px;max-width: 600px;}";
}
 ?>
a{
	text-decoration: none; 
	Color: #1A406E;
	font-weight: bold;
}
</style>
<?php
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
	$sol_id_anterior = "";
	$sol_id_siguiente = "";
	//echo "<Pre>"; print_r($filas); exit;
	foreach($filas as $indice=>$fila){
		if(str_replace('-', '', $sol_id)==$fila){		
			$sol_id_anterior = $indice == 0 ? $filas[count($filas) - 1] : $filas[$indice - 1];
			$sol_id_siguiente = $indice == count($filas) - 1 ? $filas[0] : $filas[$indice + 1];		
		}	
	}
	//echo "sol_id $sol_id<br>$ordenfilas - $sol_id $sol_id_anterior - $sol_id_siguiente";
	//echo "<br>ordenfilas $ordenfilas,<br> ordenfilas_paginado $ordenfilas_paginado";	
}
?>
<script type="text/javascript">
function enviar_cancelados(){
   if($('#est_id').val()!=''){
	$('#estadoform').submit();
   }else{
	alert('Debe elegir un estado');	
   }    
}

function poner_comentario(texto){
	$("#com_texto").val($('[name="'+ texto +'"]').attr('value'));
}
</script>
<?php /*?>
<a class="volver" href="<?php echo base_url()?>index.php/solicitud/">Volver</a><br>
<?php if(substr_count($sol_id, '-') < 2 && $rol_botones!=3){ ?>
<div style="text-align:center">
    <?php 
	if(isset($_REQUEST["sol_id"]) && isset($_REQUEST["sol_id_siguiente"]) && (str_replace(",","",$_REQUEST["sol_id"])==$_REQUEST["sol_id_siguiente"])){		
		?>
		<?php ///<div style="font-size: 14pt;">No existen mas solicitudes con el filtro especificado, ser&aacute; redireccionado al listado nuevamente....</div> ?>
		<script>
			url = "<?php echo base_url()?>index.php/solicitud/";
			jQuery(location).attr('href',url);
		</script>
		<?php
	}
	?>
        <a href="<?php echo base_url()?>index.php/solicitud/comentario/<?php echo $sol_id; ?>">Comentarios</a> | 
	<a href="<?php echo base_url()?>index.php/solicitud/ver/<?php echo $sol_id; ?>">Ver Solicitud</a>	
        <br>
		<?php if($sol_id_anterior) :?><a href="<?php echo base_url()?>index.php/solicitud/formaestado/<?php echo $sol_id_anterior; ?>">Anterior</a><?php endif; ?>
		<?php if($sol_id_anterior && $sol_id_siguiente) :?>| <?php endif; ?>
        <?php if($sol_id_siguiente) :?><a href="<?php echo base_url()?>index.php/solicitud/formaestado/<?php echo $sol_id_siguiente; ?>">Siguiente</a><?php endif; ?><br>
</div>
<?php } ?>
<?php */ ?>
<?php if(validation_errors('<p class="error">','</p>')!=''){
echo form_open();
echo str_replace('&lt;', '<', str_replace('&gt;', '>', htmlentities(validation_errors('<p class="error">','</p>'), ENT_NOQUOTES)));
echo form_close();
} ?>

<?php if($tipo_entrada=='uno'){?>
	<form>
	<!--h1><?php echo $titulo; ?> solicitud</h1-->
	<table class='formtable' align="center">
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
	<tr>
		<td class="tdlabel">Primer Semestre: </td>
		<td><?php echo  @$sol_primer_semes_msg;?></td>
	</tr>

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
        <?$labelEstado=($estadoPadre)?"Sub Estado":"Estado Principal";?>
        <?if($estadoPadre){?>
        <tr>		
		<td class="tdlabel">Estado Principal: </td>
		<td><?php echo $estadoPadre; ?></td>
	</tr>
        <?}?>
	<tr>		
		<td class="tdlabel"><? echo $labelEstado?>: </td>
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
	 <form name='estadoform' id='estadoform' action='<?php echo base_url()?>index.php/solicitud/estado' method='POST' target="_top">
	<table id='comentario_nuevo' class='formtable' align="center">
		<tr>
		 <td class="tdlabel">Estado : </td>
		 <td>
		<?php		
		//$js = ' onchange="show_me(\'oculta_comentarios\')"';
		$js = 'id="est_id"';
		echo form_dropdown('est_id',$options_estado,@$est_id, $js);
		echo form_hidden('sol_id', $sol_id);
		?>
		 </td>		 
		</tr>
		<tr>
		 <td class="tdlabel">Comentario asociado : </td>
		 <td><textarea style="width: 253px; height: 90px;" id="com_texto" name="com_texto" rows="4" cols="20"><?php if(validation_errors()!='') echo set_value('com_texto', @$com_texto); ?></textarea></td>		 
		</tr>
		<tr>
			<td colspan="2">
				<table class='formtable tablemain'>
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
				<?php if(isset($sol_id_siguiente)) echo form_hidden('sol_id_siguiente', set_value('sol_id_siguiente', $sol_id_siguiente)); ?>
			</td>
		</tr>
		<tr>
		</tr>
			<td colspan="2">
				Comentarios personalizados:
				<div style="height: 100px; overflow: scroll;">
				<table class='formtable tablecomenpersonal'>
					<tbody>
					<?php foreach($listadoComenPeronsal as $comentario) {?>
						<tr class="filacomenpersonal_<?php echo $comentario->id;?>">
							<td colspan="2"><input type="radio" name="tipo_comentario" value="comenpersonal_<?php echo $comentario->id;?>" onclick="poner_comentario(this.value)">
								<?php echo $comentario->comentariotitulo;?>
								<input type="hidden" name="comenpersonal_<?php echo $comentario->id;?>" value="<?php echo $comentario->comentariocont;?>">
							</td>
						</tr>
					<?php }?>
					</tbody>
				</table>
				</div>
			</td>	
		</tr>
		<tr>
			<td><input type='button' value='Enviar' onclick='enviar_cancelados()'><?php echo form_hidden('sol_id', $ids_habilitados);?></td>
			<td></td>
				
		</tr>
	 </table>
	</form>
	<?php }else{ ?>
	<form>
	<table id='comentario_nuevo' class='formtable'>
	<tr>		
	 <td class="tdlabel">Ninguna de las solicitudes elegidas puede ser modificada</td>
	</tr>
	</table>
	 </form>
	<?php }?>
<?php
// $this->load->view("footer");
?>