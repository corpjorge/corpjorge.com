<?php
	$this->load->view("header");
?>
<a class="volver"  href="<?php echo base_url()?>index.php/motivo/listado">Volver</a><br>
<?php echo form_open('comentarios/'); ?>
<h1>Gesti&oacute;n de comentarios</h1>
<div>Listado de comentarios personalizados &nbsp;&nbsp;</div>
<br>
<div class="form_crear_com">
	<div>T&iacute;tulo:</div>
	<div><input type="text" name="comentariotitulo" id="comentariotitulo"></div>
	<div>Comentario:</div>
	<div><textarea style=""name="comentariocont" id="comentariocont"></textarea></div>
	<div>
		<input type="hidden" name="idcomentario" id="idcomentario" value="">
		<button type="button" class="mostrar_form" onclick="guardarCPersonal()">Guardar</button>
		<button type="button" class="" onclick="clearform()">Limpiar</button>
	</div>
</div>
<div style="overflow-x: scroll;height: 225px;width: 563px;">
<table class='formtable tablecomenpersonal'>
	<tbody>
	<?php foreach($listadoComenPeronsal as $comentario) {?>
		<tr class="filacomenpersonal_<?php echo $comentario->id;?>">
			<td class="seleccionar"><input type="radio" name="tipo_comentario" value="comenpersonal_<?php echo $comentario->id;?>" onclick="poner_comentario('filacomenpersonal_<?php echo $comentario->id;?>')"></td>
			<td class="comentariotitulo">
				<span><?php echo $comentario->comentariotitulo;?></span>
				<input type="hidden" name="rowidcomentario" id="rowidcomentario" value="<?php echo $comentario->id;?>">
			</td>
			<td class="comentariocont">
				<span><?php echo $comentario->comentariocont;?></span>
			</td>
			<td><button type="button" onclick="borrarCPersonal(<?php echo $comentario->id;?>)">Borrar</button></td>
		</tr>
	<?php }?>
	</tbody>
</table>
</div>
<?php echo form_close(); ?>
<?php
$this->load->view("footer");
?>
<script>
	function guardarCPersonal(btn)
	{
		if ( jQuery("#comentariotitulo").val().trim()=="" || jQuery("#comentariocont").val().trim()=="" )
		{
			alert("Debe ingresar el título y contenido del comentario.");
			return;
		}
		jQuery.ajax({
			url: '<?php echo base_url()?>index.php/solicitud/guardarcomenperonsal',
			data: { comentariotitulo:jQuery("#comentariotitulo").val(),
					comentariocont:jQuery("#comentariocont").val(),
					idcomenpersonal:jQuery("#idcomentario").val()
				  },
			type: "POST",
			success: function(idcomenpersonal){
				actualizarTablaComP(idcomenpersonal,jQuery("#idcomentario").val(),jQuery("#comentariotitulo").val(),jQuery("#comentariocont").val());
			}
		});
	}
	
	function borrarCPersonal(id)
	{
		jQuery.ajax({
			url: '<?php echo base_url()?>index.php/solicitud/borrarcomenperonsal',
			data: {idcomenpersonal:id},
			type: "POST",
			success: function(estado){
				if ( estado == "1" )
				{
					jQuery("tr.filacomenpersonal_"+id).remove();
					clearform();
				}
			}
		});
	}

	function poner_comentario (id)
	{
		comentariotitulo = jQuery("tr."+id+" td.comentariotitulo span").html();
		comentariocont   = jQuery("tr."+id+" td.comentariocont span").html();
		idcomentario     = jQuery("tr."+id+" input#rowidcomentario").val();
		jQuery("#comentariotitulo").val(comentariotitulo);
		jQuery("#comentariocont").val(comentariocont);
		jQuery("#idcomentario").val(idcomentario);
	}

	function clearform()
	{
		jQuery("#comentariotitulo").val("");
		jQuery("#comentariocont").val("");
		jQuery("#idcomentario").val("");
		jQuery("input[name='tipo_comentario']").prop('checked', false);
	}
	
	function actualizarTablaComP (idretornado,idenviado,comentariotitulo,comentariocont) 
	{
		if (idenviado!="")
		{
			jQuery("tr.filacomenpersonal_"+idenviado+" td.comentariotitulo span").html(comentariotitulo);
			jQuery("tr.filacomenpersonal_"+idenviado+" td.comentariocont span").html(comentariocont);
		}
		else
		{
			tr  = '<tr class="filacomenpersonal_'+idretornado+'">';
			tr += 	'<td class="seleccionar"><input type="radio" name="tipo_comentario" value="comenpersonal_'+idretornado+'" onclick="poner_comentario(\'filacomenpersonal_'+idretornado+'\')"></td>';
			tr += 	'<td class="comentariotitulo">';
			tr += 		'<span>'+comentariotitulo+'</span>';
			tr += 		'<input type="hidden" name="rowidcomentario" id="rowidcomentario" value="'+idretornado+'">';
			tr += 	'</td>';
			tr += 	'<td class="comentariocont">';
			tr += 		'<span>'+comentariocont+'</span>'
			tr += 	'</td>';
			tr += 	'<td><button type="button" onclick="borrarCPersonal('+idretornado+')">Borrar</button></td>';
			tr += '</tr>';
			jQuery(".tablecomenpersonal tbody").append(tr);
		}
		clearform();
	}
</script>