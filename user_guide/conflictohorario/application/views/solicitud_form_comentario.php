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
	$filas2 = explode(';',$ordenfilas);
	foreach($filas2 as $indice=>$fila){
		if(str_replace('-', '', $sol_id)==$fila){		
			$sol_id_anterior = $indice == 0 ? $filas2[count($filas2) - 1] : $filas2[$indice - 1];
			$sol_id_siguiente = $indice == count($filas2) - 1 ? $filas2[0] : $filas2[$indice + 1];		
		}	
	}
	//echo "sol_id $sol_id<br>$ordenfilas - $sol_id $sol_id_anterior - $sol_id_siguiente";
	//echo "<br>ordenfilas $ordenfilas,<br> ordenfilas_paginado $ordenfilas_paginado";	
}
?>
<script type="text/javascript">
function show_me(id){
	estado  = $("#"+id).css("display");
	if(estado=="none"){
		$("#"+id).show();		
	}else{
		$("#"+id).hide();
	}	 
}
function show_crn(valor){
	switch(valor){
		case '1':
			$('#crn_mag_2').css('display','none');
			$('#crn_mag_1').css('display','block');
		break;
		case '2':
			$('#crn_mag_1').css('display','block');
			$('#crn_mag_2').css('display','block');
		break;
		case '3':
			$('#crn_mag_1').css('display','block');
			$('#crn_mag_2').css('display','block');
		break;
	}
}

function get_crn(id){
	var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=508, height=365, top=85, left=140";
	window.open("<?php echo base_url();?>/index.php/solicitud/ayuda/"+id,"",opciones);
}

function put_crn(id,seccion,id_input){
	$('[name="'+id_input+'"]').val(id);
	$('[name="'+id_input+'_des"]').val(seccion);
}

$(document).ready(function() {
	var valor_tipo = '<?php echo  $tip_id;?>';
	if(valor_tipo!="")
		show_crn(valor_tipo);
		
	$("#various1").fancybox({
		'titlePosition'		: 'inside',
		'transitionIn'		: 'none',
		'transitionOut'		: 'none'
	});
});	
</script>
<a class="volver"  href="<?php echo base_url()?>index.php/solicitud/">Volver</a><br>
<?php if(substr_count($sol_id, '-') < 2 && $rol_botones!=3){ ?>
<div style="text-align:center">
	<a href="<?php echo base_url()?>index.php/solicitud/comentario/<?php echo $sol_id_anterior; ?>">Anterior</a> | <a href="<?php echo base_url()?>index.php/solicitud/comentario/<?php echo $sol_id_siguiente; ?>">Siguiente</a><br>
</div>
<?php } ?>

<?php echo validation_errors(); ?>
<?php if(validation_errors('<p class="error">','</p>')!=''){
echo form_open();
echo str_replace('&lt;', '<', str_replace('&gt;', '>', htmlentities(validation_errors('<p class="error">','</p>'), ENT_NOQUOTES)));
echo form_close();
} ?>
<?php echo form_open('solicitud/'.$accion.'/'.$sol_id); ?>

	<h1><?php echo $titulo; ?> solicitud</h1>
	<table class='formtable'>
	<tr>
		<td class="tdlabel">Solicitud de  <?php echo $sol_nombre;?> <?php echo @$sol_apellido;?></td>
		<td class="tdlabel">C&oacute;digo <?php echo @$sol_uidnumber;?></td>		
	</tr>
	<tr>
		<td class="tdlabel">Programa : </td>
		<td><?php echo $prog;?></td>
	</tr>
	<tr>
		<td class="tdlabel">Doble programa : </td>
		<td><?php echo $doble_prog;?></td>
	</tr>
	<tr>
		<td class="tdlabel">Cr&eacute;ditos :  </td>
		<td><?php echo $creditos;?></td>
	</tr>
	<tr>
		<td class="tdlabel">Opci&oacute;n :  </td>
		<td><?php echo $opcion;?></td>
	</tr>
	<tr>
		<td class="tdlabel">SSC :</td>
		<td><?php echo $ssc;?></td>
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
	<!--<tr>
		<td class="tdlabel">CRN (origen) : </td>
		<td><?php echo  @$sol_mag_crn_ret_des;?></td>
	</tr>
	<tr>
		<td class="tdlabel">CRN (destino): </td>
		<td><?php echo @$sol_mag_crn_ins_des;?></td>						
	</tr>
	<? if(@$sol_com_crn_ret_des!='') { ?>
	<tr>
		<td class="tdlabel">CRN (complementario origen): </td>
		<td><?php echo @$sol_com_crn_ret_des?></td>
	</tr>
	<? } ?>
	<? if(@$sol_com_crn_ins_des!='') { ?>
	<tr>
		<td class="tdlabel">CRN (complementario destino): </td>
		<td><?php	echo @$sol_com_crn_ins_des; ?></td>
	</tr>
	<? } ?>-->
	<? if(@$sol_ins_des!='') { ?>
	<tr>
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
	<tr>
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
	<tr>
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
	<tr>
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
		<td class="tdlabel">Descripci&oacute;n: </td>
		<td><?php echo $sol_descripcion?></td>                
	</tr>	
	<tr>		
		<td class="tdlabel">Estado:</td> <td><?php echo $estado; ?></td>
	</tr>
	<tr>
		<td><a id="various1" href="#comentario_nuevo" style="font-size:16px"><?php if($puede_comentar) echo 'Adicionar Comentario'; ?></a></td>
	</tr>
	</table>
<?php echo form_close(); ?>
<a href='javascript:;' onclick='show_me("comentarios")' style="margin-left:270px">Ver Comentarios <?php echo "(".count($filas).")"; ?></a><br>
<div id='oculta_comentarios' style='display:none'>
	<div id='comentario_nuevo'>
	  <?php echo $comentario_form; ?>
	</div>
</div>
<div id='comentarios' style='display:none' align="center">
  <?php echo $comentario_listado; ?>
</div>
<?php
$this->load->view("footer");
?>