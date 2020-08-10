<?php
	$this->load->view("header");
?>
<a class="volver"  href="<?php echo base_url()?>index.php/motivo/listado">Volver</a><br>
<?php echo form_open('comentarios/'); ?>
<h1>Gesti&oacute;n de mensajes</h1>
<div>Listado de mensajes personalizados &nbsp;&nbsp;</div>
<br>
<div class="form_crear_com">
	<div>Ingrese los CRNs asociados al mensaje separados por comas (,):</div>
	<div><input type="text" name="crns" id="crns" onkeypress="return validate_numbers(event)" ></div>
	<div>Mensaje:</div>
	<div><textarea class="txt-mensaje" name="mensaje" id="mensaje"></textarea></div>
	<div>
		<input type="hidden" name="rol" id="rol" value="<?php echo $rol; ?>">
		<input type="hidden" name="idmensaje" id="idmensaje" value="">
		<button type="button" class="mostrar_form" onclick="guardarMensaje()">Guardar</button>
		<button type="button" class="" onclick="clearform()">Limpiar</button>
		<button type="button" class="" onclick="eliminarseleccionados()" style="width: 200px;">Eliminar seleccionados</button>
	</div>
</div>	

<div style="overflow-x: hidden; overflow-y:scroll;height:400px;width:570px;">     
		<table class='formtable tablecomenpersonal'>
			<thead>
				<th>Seleccionar</th>
				<th>CRN´s</th>
				<th>Mensaje</th>
				<th></th>
			</thead>
			<tbody>
			<?php foreach($listadoMensjPeronsal as $mensaje) {?>
				<tr class="filamensaje_<?php echo $mensaje->id;?>">
					<td class="seleccionar">
						<input 	type="checkbox" 
								name="s_mensaje[]" 
								value="<?php echo $mensaje->id;?>" 
								id="s_mensaje_<?php echo $mensaje->id;?>"
								onclick="poner_comentario('filamensaje_<?php echo $mensaje->id;?>')">
					</td>

					<td class="crns">
						<span><?php echo $mensaje->crn;?></span>
						<input type="hidden" name="rowidmensaje" id="rowidmensaje" value="<?php echo $mensaje->id;?>">
					</td>

					<td class="mensaje">
						<span><?php echo $mensaje->message;?></span>
					</td>
					<td class="btn-eliminar"><button class="button-delete" type="button" onclick="borrarMensaje(<?php echo $mensaje->id;?>)"> </button></td>

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
	function guardarMensaje(btn)
	{
		//Aqui va la validacion
		var dato= jQuery("#crns").val();

		if ( jQuery("#crns").val().trim()=="" )
		{
			alert("Debe ingresar uno o mas números de CRN.");
			return;
		}
		if(jQuery("#mensaje").val().trim()=="" )
		{
			alert("Debe ingresar un mensaje");
			return;
		}
		
		if ( jQuery("#rol").val()=="2" )
		{

			jQuery.ajax({
			url: '<?php echo base_url()?>index.php/mensajes/consultacrns',
			data: {vcrns:dato},
			type: "POST",
			dataType : 'json'
			})
			.done(function (data){

					if(data != "ok")
					{
						alert("El crn: " + data + "no pertenece a ninguno de sus programas asignados");
						return;
					}
					else
					{
						jQuery.ajax({
							url: '<?php echo base_url()?>index.php/mensajes/guardarmensaje',
							data: { crns:jQuery("#crns").val(),
									mensaje:jQuery("#mensaje").val(),
									idmensaje:jQuery("#idmensaje").val()
								  },
							type: "POST",
							success: function(idmensaje){
								actualizarTablaComP(idmensaje,jQuery("#idmensaje").val(),jQuery("#crns").val(),jQuery("#mensaje").val());
								//Deseleccionar todos
								$("input:checkbox").prop('checked', false);
								$("input[type=checkbox]").prop('checked', false);
							}
						});
					}
				});
		}
		else
		{
			jQuery.ajax({
				url: '<?php echo base_url()?>index.php/mensajes/guardarmensaje',
				data: { crns:jQuery("#crns").val(),
						mensaje:jQuery("#mensaje").val(),
						idmensaje:jQuery("#idmensaje").val()
				},
				type: "POST",
				success: function(idmensaje){

								actualizarTablaComP(idmensaje,jQuery("#idmensaje").val(),jQuery("#crns").val(),jQuery("#mensaje").val());
								//Deseleccionar todos
								$("input:checkbox").prop('checked', false);
								$("input[type=checkbox]").prop('checked', false);
							}
			});
		}

	}

	function borrarMensaje(id)
	{
		var r = confirm("Desea eliminar el registro seleccionado?");

		if (r) 
		{
			jQuery.ajax({
				url: '<?php echo base_url()?>index.php/mensajes/eliminarmensaje',
				data: {idmensaje:id},
				type: "POST",
				success: function(estado){
					if ( estado == "1" )
					{
						jQuery("tr.filamensaje_"+id).remove();
						clearform();
					}
				}
			});
		}
	}

	function poner_comentario(id)
	{
			
			var t=   jQuery("tr."+id+" input#rowidmensaje").val();

			 if(jQuery("#s_mensaje_"+t+"").is(':checked')) 
			 {
			 	crns = jQuery("tr."+id+" td.crns span").html();
				mensaje   = jQuery("tr."+id+" td.mensaje span").html();
				idmensaje    = jQuery("tr."+id+" input#rowidmensaje").val();
				jQuery("#crns").val(crns);
				jQuery("#mensaje").val(mensaje);
				jQuery("#idmensaje").val(idmensaje);
			 } 
			 else
			 {
			 	jQuery("#crns").val("");
				jQuery("#mensaje").val("");
				jQuery("#idmensaje").val("");
			 }

	}

	function clearform()
	{
		jQuery("#crns").val("");
		jQuery("#mensaje").val("");
		jQuery("#idmensaje").val("");
		//jQuery("input[name='tipo_comentario']").prop('checked', false);
		jQuery("input:checkbox").prop('checked', false);
		jQuery("input[type=checkbox]").prop('checked', false);
	}
	
	function actualizarTablaComP (idretornado,idenviado,crns,mensaje) 
	{
		if (idenviado!="")
		{
			jQuery("tr.filamensaje_"+idenviado+" td.crns span").html(crns);
			jQuery("tr.filamensaje_"+idenviado+" td.mensaje span").html(mensaje);
		}
		else
		{
			tr  = '<tr class="filamensaje_'+idretornado+'">';
			tr += 	'<td class="seleccionar"><input 	type="checkbox" name="s_mensaje[]" id="s_mensaje_'+idretornado+'" value="'+idretornado+'" onclick="poner_comentario(\'filamensaje_'+idretornado+'\')"></td>';
			tr += 	'<td class="crns">';
			tr += 		'<span>'+crns+'</span>';
			tr += 		'<input type="hidden" name="rowidmensaje" id="rowidmensaje" value="'+idretornado+'">';
			tr += 	'</td>';
			tr += 	'<td class="mensaje">';
			tr += 		'<span>'+mensaje+'</span>'
			tr += 	'</td>';
			tr += 	'<td class="btn-eliminar"><button class="button-delete" type="button" onclick="borrarMensaje('+idretornado+')"> </button></td>';
			tr += '</tr>';
			jQuery(".tablecomenpersonal tbody").append(tr);
		}
		clearform();
	}

	function eliminarseleccionados()
	{
		var r = confirm("Se eliminarán permanentemente los registros seleccionados. \nDesea continuar?");

		if (r == true) 
		{
		    var ids= jQuery("input[name='s_mensaje[]']").serializeArray();
			jQuery.ajax({
						url: '<?php echo base_url()?>index.php/mensajes/ultimomensaje',
						data: {idmensaje:ids},
						type: "POST",
						success: function(ultimomensaje){
				//alert(ultimomensaje);
				document.location.reload();
				}
			});
		}
	}

	function validate_numbers(e) 
	{ 
	  tecla=(document.all)?e.keyCode:e.which; 
	  patron=/[0-9,]/; 
	  te=String.fromCharCode(tecla); 
	  if(!patron.test(te))
	  {
	    alert("Introduzca únicamente números o comas");
	  }

	  

	  	var cad=jQuery("#crns").val();
		var letra=cad.substring(cad.length-1,cad.length); 

		patron2=/[,]/; 

	  if(letra ==',' && patron2.test(te))
	  {
	    alert("Introduzca únicamente una coma despues de cada CRN");
	    return false;
	  }

	  letra=cad.substring(0,1);

	  if(letra==",")
	  {
	  	alert("Primer carater no válido. Inicie con el número del CRN");
	  	jQuery("#crns").val("");
	  	return false;
	  } 

	  return patron.test(te); 
	}

</script>