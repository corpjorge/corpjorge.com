<?php
$this->load->view("header");
?>
<script>
function selall(id){
     var nombre = $(".selectall").html();     
     if(nombre=='Seleccionar todos'){
	$('#'+id+' >tbody >tr').each(
	    function (){	    
		    $(this).attr('class','trSelected');		    		
	    }
	);
	$(".selectall").html('Quitar selecci&oacute;n');
     }else{
	$('#'+id+' >tbody >tr').each(
	    function (){	    
		    $(this).attr('class','');		    		
	    }
	);
	$(".selectall").html('Seleccionar todos');
     }
}
$(document).ready(function() {
    $(function() {
    $("#flex1").flexigrid({
      url: '<?php echo base_url()?>index.php/solicitud/page/',
      dataType: 'json',
      colModel : [	
	  
		<?php
		$ordencols = explode(';', $ordencol);
		$ordencol_label = explode(';', $ordencol_label);
		$ordencol_width = explode(';', $ordencol_width);		
		if(is_array($ordencols) && count($ordencols)>0 && $ordencol!=''){
			foreach($ordencols as $indice=>$ordencol){
				if(/*!in_array($ordencol, $ocultas) && */$ordencol!=''){ ?>
					{display: '<?php echo $ordencol_label[$indice]; ?>', name : '<?php echo $ordencol; ?>', width : <?php echo str_replace('px', '', $ordencol_width[$indice]); ?>, sortable : true, align: 'left', hide: <?php $hide = in_array($ordencol,$ocultas) ? 'true' : 'false'; echo $hide; ?>},
				<?php }
			}
		}
		else {	?>		
			<?php //if(!in_array('sol_id',$ocultas)){?>
			{display: 'ID', name : 'sol_id', width : /*40*/20, sortable : true, align: 'left', hide: <?php $hide = in_array('sol_id',$ocultas) ? 'true' : 'false'; echo $hide; ?>},
			<?php //}?>
			<?php //if(!in_array('est_id',$ocultas)){?>
			{display: 'Estado', name : 'est_id', width : 44, sortable : true, align: 'left', hide: <?php $hide = in_array('est_id',$ocultas) ? 'true' : 'false'; echo $hide; ?>},
			<?php //}?>	
			<?php //if(!in_array('sol_fec_creacion',$ocultas)){?>
			{display: 'Fecha', name : 'sol_fec_creacion', width : 100, sortable : true, align: 'left', hide: <?php $hide = in_array('sol_fec_creacion',$ocultas) ? 'true' : 'false'; echo $hide; ?>},
			<?php //}?>
			<?php //if(!in_array('sol_uidnumber',$ocultas)){?>
			{display: 'C&oacute;digo', name : 'sol_uidnumber', width : 60, sortable : true, align: 'left', hide: <?php $hide = in_array('sol_uidnumber',$ocultas) ? 'true' : 'false'; echo $hide; ?>},
			<?php //}?> 
			<?php //if(!in_array('sol_login',$ocultas)){?>
			{display: 'Login', name : 'sol_login', width : 90, sortable : true, align: 'left', hide: <?php $hide = in_array('sol_login',$ocultas) ? 'true' : 'false'; echo $hide; ?>},
			<?php //}?>
			<?php //if(!in_array('sol_nombre',$ocultas)){?>
			{display: 'Estudiante', name : 'sol_nombre', width : 100, sortable : true, align: 'left', hide: <?php $hide = in_array('sol_nombre',$ocultas) ? 'true' : 'false'; echo $hide; ?>},
			<?php //}?>
			<?php //if(!in_array('sol_apellido',$ocultas)){?>
			{display: 'Apellido', name : 'sol_apellido', width : 150, sortable : true, align: 'left', hide: <?php $hide = in_array('sol_apellido',$ocultas) ? 'true' : 'false'; echo $hide; ?>},
			<?php //}?>
			<?php //if(!in_array('sol_ins_mat',$ocultas)){?>
			{display: 'Cod materia', name : 'sol_ins_mat', width : /*50*/60, sortable : true, align: 'left', hide: <?php $hide = in_array('sol_ins_mat',$ocultas) ? 'true' : 'false'; echo $hide; ?>},
			<?php //}?>
			<?php //if(!in_array('sol_ins_crn',$ocultas)){?>
			{display: 'CRN', name : 'sol_ins_crn', width : 40, sortable : true, align: 'left', hide: <?php $hide = in_array('sol_ins_crn',$ocultas) ? 'true' : 'false'; echo $hide; ?>},
			<?php //}?>
			<?php //if(!in_array('sol_ins_des',$ocultas)){?>
			{display: 'Materia', name : 'sol_ins_des', width : /*200*/300, sortable : true, align: 'left', hide: <?php $hide = in_array('sol_ins_des',$ocultas) ? 'true' : 'false'; echo $hide; ?>},
			<?php //}?>
			<?php //if(!in_array('sol_ins_seccion',$ocultas)){?>
			{display: 'Secci&oacute;n', name : 'sol_ins_seccion', width : 40, sortable : true, align: 'left', hide: <?php $hide = in_array('sol_ins_seccion',$ocultas) ? 'true' : 'false'; echo $hide; ?>},
			<?php //}?>
			<?php //if(!in_array('tip_id',$ocultas)){?>
			{display: 'Tipo', name : 'tip_id', width : /*100*/200, sortable : true, align: 'left', hide: <?php $hide = in_array('tip_id',$ocultas) ? 'true' : 'false'; echo $hide; ?>},
			<?php //}?>
			<?php //if(!in_array('mov_id',$ocultas)){?>
			{display: 'Motivo', name : 'mov_id', width : /*100*/200, sortable : true, align: 'left', hide: <?php $hide = in_array('mov_id',$ocultas) ? 'true' : 'false'; echo $hide; ?>},
			<?php //}?>
			<?php //if(!in_array('sol_descripcion',$ocultas)){?>
			{display: 'Descripci&oacute;n', name : 'sol_descripcion', width : /*200*/300, sortable : true, align: 'left', hide: <?php $hide = in_array('sol_descripcion',$ocultas) ? 'true' : 'false'; echo $hide; ?>},
			<?php //}?>
			<?php //if(!in_array('sol_ins_instructor',$ocultas)){?>
			{display: 'Profesor', name : 'sol_ins_instructor', width : /*200*/300, sortable : true, align: 'left', hide: <?php $hide = in_array('sol_ins_instructor',$ocultas) ? 'true' : 'false'; echo $hide; ?>}
			<?php //}?>
	<?php } ?>	  
		
      ],
      buttons : [
	{name: 'Cancelar', bclass: 'delete', onpress : doCommand},
	{name: 'Cambiar estado', bclass: 'update', onpress : doCommand},
	{name: 'Comentarios', bclass: 'comment', onpress : doCommand},
	{name: 'Crear solicitud', bclass: 'create', onpress : doCommand},
	{name: 'Ver solicitud', bclass: 'view', onpress : doCommand},
	{separator: true},
	{name: 'Seleccionar todos', bclass: 'selectall', onpress : doCommand},
	{name: 'Ver todas las columnas', bclass: 'view', onpress : doCommand},
	{separator: true}
      ],
      searchitems : [
			{display: 'ID', name : 'sol_id', isdefault: <?php $isdefault = $qtype=='sol_id' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'Estado', name : 'est_descripcion', isdefault: <?php $isdefault = $qtype=='est_descripcion' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'Fecha', name : 'sol_fec_creacion', isdefault: <?php $isdefault = $qtype=='sol_fec_creacion' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'C&oacute;digo', name : 'sol_uidnumber', isdefault: <?php $isdefault = $qtype=='sol_uidnumber' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'Login', name : 'sol_login', isdefault: <?php $isdefault = $qtype=='sol_login' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'Estudiante', name : 'sol_nombre', isdefault: <?php $isdefault = $qtype=='sol_nombre' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'Apellido', name : 'sol_apellido', isdefault: <?php $isdefault = $qtype=='sol_apellido' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'Cod Materia', name : 'sol_ins_mat', isdefault: <?php $isdefault = $qtype=='sol_ins_mat' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'CRN', name : 'sol_ins_crn', isdefault: <?php $isdefault = $qtype=='sol_ins_crn' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'Materia', name : 'sol_ins_des', isdefault: <?php $isdefault = $qtype=='sol_ins_des' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'Secci&oacute;n', name : 'sol_ins_seccion', isdefault: <?php $isdefault = $qtype=='sol_ins_seccion' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'Tipo', name : 'tip_descripcion', isdefault: <?php $isdefault = $qtype=='tip_descripcion' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'Motivo', name : 'mov_descripcion', isdefault: <?php $isdefault = $qtype=='mov_descripcion' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'Descripci&oacute;n', name : 'sol_descripcion', isdefault: <?php $isdefault = $qtype=='sol_descripcion' || $qtype=='' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'Profesor', name : 'sol_ins_instructor', isdefault: <?php $isdefault = $qtype=='sol_ins_instructor' ? 'true' : 'false'; echo $isdefault; ?>}
      ],
      searchitems2 : [
            {display: 'ID', name : 'sol_id', isdefault: <?php $isdefault = $qtype2=='sol_id' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'Estado', name : 'est_descripcion', isdefault: <?php $isdefault = $qtype2=='est_descripcion' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'Fecha', name : 'sol_fec_creacion', isdefault: <?php $isdefault = $qtype2=='sol_fec_creacion' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'C&oacute;digo', name : 'sol_uidnumber', isdefault: <?php $isdefault = $qtype2=='sol_uidnumber' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'Login', name : 'sol_login', isdefault: <?php $isdefault = $qtype2=='sol_login' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'Estudiante', name : 'sol_nombre', isdefault: <?php $isdefault = $qtype2=='sol_nombre' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'Apellido', name : 'sol_apellido', isdefault: <?php $isdefault = $qtype2=='sol_apellido' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'Cod Materia', name : 'sol_ins_mat', isdefault: <?php $isdefault = $qtype2=='sol_ins_mat' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'CRN', name : 'sol_ins_crn', isdefault: <?php $isdefault = $qtype2=='sol_ins_crn' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'Materia', name : 'sol_ins_des', isdefault: <?php $isdefault = $qtype2=='sol_ins_des' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'Secci&oacute;n', name : 'sol_ins_seccion', isdefault: <?php $isdefault = $qtype2=='sol_ins_seccion' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'Tipo', name : 'tip_descripcion', isdefault: <?php $isdefault = $qtype2=='tip_descripcion' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'Motivo', name : 'mov_descripcion', isdefault: <?php $isdefault = $qtype2=='mov_descripcion' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'Descripci&oacute;n', name : 'sol_descripcion', isdefault: <?php $isdefault = $qtype2=='sol_descripcion' || $qtype2=='' ? 'true' : 'false'; echo $isdefault; ?>},
			{display: 'Profesor', name : 'sol_ins_instructor', isdefault: <?php $isdefault = $qtype2=='sol_ins_instructor' ? 'true' : 'false'; echo $isdefault; ?>}			
      ],
      sortname: "<?php if($sortname!='') echo $sortname; else echo 'sol_id'; ?>",
      sortorder: "<?php if($sortorder!='') echo $sortorder; else echo 'asc'; ?>",
      usepager: true,
      title: "<?php echo $titulo;?>",
      useRp: true,
      rp: <?php echo $rp;?>,
      showTableToggleBtn: false,
      resizable: true,
      width: 1200,
      height: 600,
      singleSelect: false,
      otro:'<?php echo $otro;?>',
	  query: '<?php echo $query; ?>',
	  query2: '<?php echo $query2; ?>'
    }
    );
    });
	//$('.selectall').parent().parent().css('background-color', '#ffffff');
  });  
  mensaje = '<?php if(!empty($mensaje))echo urldecode($mensaje);else echo '';?>';
  if(mensaje!='')
    alert(mensaje);
    
  function doCommand(com, grid) {
    var ocultos = ordencol = ordencol_label = ordencol_width = '';
    $(".hDivBox >table >thead >tr >th").each(function (index) {
	if($(this).css('display')=='none')
	    ocultos = ocultos+$(this).attr("abbr")+';';	
		ordencol = ordencol+$(this).attr("abbr")+';';
		ordencol_label = ordencol_label+$(this).children('div').text()+';';
		ordencol_width = ordencol_width+$(this).children('div').css("width")+';';
    })
    var qtype = $("select[name=qtype]").val();
	var query = $("input[name=q]").val();
	var qtype2 = $("select[name=qtype2]").val();
	var query2 = $("input[name=q2]").val();
	
    $.ajax({
	url: '<?php echo base_url()?>index.php/reporte/columnas',
	type: "POST",
	data: 'ocultas='+ocultos+'&ordencol='+ordencol+'&ordencol_label='+ordencol_label+'&ordencol_width='+ordencol_width+'&qtype='+qtype+'&query='+query+'&qtype2='+qtype2+'&query2='+query2,	
	success: function(html){
	    if(html=='OK'){
		var lista='';
		if (com == 'Actualizar') {
		  $('.trSelected', grid).each(function() {
		    var id = $(this).attr('id');
		    id = id.substring(id.lastIndexOf('row')+3);
		    lista=id+'*';
		  });
		  var todos = lista.split('*');
		  if(!todos[0]=='')
		    window.location.href='<?php echo base_url()?>index.php/solicitud/actualizar/'+todos[0];
		} else if (com == 'Cancelar') {
		    $('.trSelected', grid).each(function() {	  
		      var id = $(this).attr('id');
		      id = id.substring(id.lastIndexOf('row')+3);
		      lista=lista+id+'-';
		    });
		    if(lista!='')
		     window.location.href='<?php echo base_url()?>index.php/solicitud/formacancelar/'+lista;
		    else
		     alert('Seleccione una o mas filas');
		}else if(com=='Crear solicitud'){
		  window.location.href='<?php echo base_url()?>index.php/solicitud/crearadm';
		}else if(com=="Cambiar estado"){
		    $('.trSelected', grid).each(function() {	  
		      var id = $(this).attr('id');
		      id = id.substring(id.lastIndexOf('row')+3);
		      lista=lista+id+'-';
		    });
		    if(lista!='')
		     window.location.href='<?php echo base_url()?>index.php/solicitud/formaestado/'+lista;
		    else
		     alert('Seleccione una o mas filas');
		}
		
		/*else if(com=='Comentarios'){
		    $('.trSelected', grid).each(function() {
		    var id = $(this).attr('id');
		    id = id.substring(id.lastIndexOf('row')+3);
		    lista=id+'*';
		  });
		  var todos = lista.split('*');
		  if(!todos[0]=='')
		  window.location.href='<?php echo base_url()?>index.php/solicitud/comentario/'+todos[0];
		}*/
		else if(com=="Comentarios"){
		    var seleccionados = 0;
		    $('.trSelected', grid).each(function() {	  
		      var id = $(this).attr('id');
		      id = id.substring(id.lastIndexOf('row')+3);
		      lista=lista+id+'-';
		      seleccionados++;
		    });
		    if(lista!='') {			 
			 if(seleccionados < 2){
			      var todos = lista.split('-');
			     if(!todos[0]=='')
				   window.location.href='<?php echo base_url()?>index.php/solicitud/comentario/'+todos[0]; //solo un comentario
			 }
			 else {			      
			      window.location.href='<?php echo base_url()?>index.php/solicitud/formacomentario/'+lista; //comentarios masivos
			 }
		    }
		    else
			 alert('Seleccione una o mas filas');
		}
				
		else if(com=='Ver solicitud'){
		    $('.trSelected', grid).each(function() {
		    var id = $(this).attr('id');
		    id = id.substring(id.lastIndexOf('row')+3);
		    lista=id+'*';
		  });
		  var todos = lista.split('*');
		  if(!todos[0]=='')
		  window.location.href='<?php echo base_url()?>index.php/solicitud/ver/'+todos[0];
		}else if(com=='Seleccionar todos'){
		    selall('flex1');
		}else if(com=='Ver todas las columnas'){
		  window.location.href='<?php echo base_url()?>index.php/solicitud/columnasno';
		}		
	    }
	    	    
	}
    });           
  }  
</script>
<br>
<table width="100%" border="0" style="border:1px #F2F2F2 solid; color:#FFFFFF">
    <tbody><tr>
      <td style="background-color:#CC0000; font-size:10px">En revisi&oacute;n </td>
      <td style="background-color:#7030A0; font-size:10px">Finalizado sin soluci&oacute;n </td>
      <td style="background-color:#00B050; font-size:10px">Finalizado con soluci&oacute;n </td>
      <td style="background-color:#FFC000; font-size:10px">En espera de respuesta del estudiante </td>
      <td style="background-color:#FF3300; font-size:10px">En espera de respuesta del coordinador </td>
      <td style="background-color:#000000; font-size:10px">Cancelado</td>
      <td style="background-color:#0070C0; font-size:10px">No corresponde </td>
    </tr>
  </tbody></table>
<br>
<table id="flex1" width="80%" style="border:1px #F2F2F2 solid" border="0"></table>
<?php
$this->load->view("footer");
?>