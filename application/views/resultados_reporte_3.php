<form id="fmFilter">
<?php echo form_hidden('programa_id', set_value('programa_id', $programa_id)); ?>
<?php echo form_hidden('estado_id', set_value('estado_id', $estado_id)); ?>
<?php echo form_hidden('periodo_id', set_value('periodo_id', $periodo_id)); ?>
<?php echo form_hidden('fecha_ini', set_value('fecha_ini', $fecha_ini)); ?>
<?php echo form_hidden('fecha_fin', set_value('fecha_fin', $fecha_fin)); ?>
<?php echo form_hidden('reporte', set_value('reporte', $reporte)); ?>
</form>
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
    var myFlex = $("#flex1").flexigrid({
      url: '<?php echo base_url()?>index.php/reporte/page/',
      dataType: 'json',
      colModel : [
	{display: 'CRN', name : 'sol_ins_crn', width : 100, sortable : false, align: 'left'},
	{display: 'Programa', name : 'dep_id', width : 100, sortable : false, align: 'left'},
	{display: 'TOTAL', name : 'total', width : 100, sortable : false, align: 'left'}	
      ],
      buttons : [
	{name: 'Generar excel', bclass: 'excel', onpress : doCommand},
	/*{name: 'Cancelar', bclass: 'delete', onpress : doCommand},
	{name: 'Comentario', bclass: 'comment', onpress : doCommand},
	{name: 'Crear', bclass: 'create', onpress : doCommand},
	{name: 'Ver', bclass: 'view', onpress : doCommand},
	{name: 'Seleccionar todos', bclass: 'selectall', onpress : doCommand},*/
	{separator: true}
      ],
      /*searchitems : [
	{display: 'CRN', name : 'sol_ins_crn'},
	{display: 'Programa', name : 'dep_id', isdefault: true},
	{display: 'Total', name : 'total'}	
      ],*/
      otro: '<?php echo $programa_id;?>***<?php echo $estado_id;?>***<?php echo $fecha_ini;?>***<?php echo $fecha_fin;?>***<?php echo $reporte;?>***<?php echo $periodo_id;?>',
      sortname: "sol_ins_crn",      
      sortorder: "asc",
      usepager: true,
      title: "<?php echo $titulo;?>",
      useRp: true,
      rp: 20,
      showTableToggleBtn: false,
      resizable: false,
      width: 1200,
      height: 600,
      singleSelect: false
    }
    );    
      
    });
  });  
  mensaje = '<?php if(!empty($mensaje))echo urldecode($mensaje);else echo '';?>';
  if(mensaje!='')
    alert(mensaje);
    
  function doCommand(com, grid) {
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
    }else if(com=='Crear'){
      window.location.href='<?php echo base_url()?>index.php/solicitud/crear';
    }else if(com=='Comentario'){
	$('.trSelected', grid).each(function() {
	var id = $(this).attr('id');
	id = id.substring(id.lastIndexOf('row')+3);
	lista=id+'*';
      });
      var todos = lista.split('*');
      if(!todos[0]=='')
      window.location.href='<?php echo base_url()?>index.php/solicitud/comentario/'+todos[0];
    }else if(com=='Ver'){
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
    }else if(com=='Generar excel'){
	  $('#reporte_2').val($('#tiporeporte').attr('value'));
	  $('#estado_id_2').val($('select[name=estado_id]').attr('value'));
    $('#periodo_id_2').val($('select[name=periodo_id]').attr('value'));
	  $('#fecha_ini_2').val($('input:text[name=fecha_ini]').attr('value'));
	  $('#fecha_fin_2').val($('input:text[name=fecha_fin]').attr('value'));
	  $('#programa_id_2	').val($('select[name=programa_id]').attr('value'));
	  $('#excelform').submit();
    }	
  }
</script>
<br>
<table width="100%" border="0" style="border:1px #F2F2F2 solid; color:#FFFFFF">
    <tbody><tr>
      <td style="background-color:#5B86EA; font-size:10px">En revisi&oacute;n </td>
      <td style="background-color:#339933; font-size:10px">Finalizado sin soluci&oacute;n </td>
      <td style="background-color:#66CC66; font-size:10px">Finalizado con soluci&oacute;n </td>
      <td style="background-color:#CC9900; font-size:10px">En espera de respuesta del estudiante </td>
      <td style="background-color:#CC6600; font-size:10px">En espera de respuesta del coordinador </td>
      <td style="background-color:#333333; font-size:10px">Cancelado</td>
      <td style="background-color:#CC3300; font-size:10px">No corresponde </td>
    </tr>
  </tbody></table>
<br>
     <form name="excelform" id="excelform" action="<?php echo base_url();?>index.php/reporte/excel" method="POST">
     <input type="hidden" id="programa_id_2" name="programa_id_2" value="">
     <input type="hidden" id="estado_id_2" name="estado_id_2" value="">
     <input type="hidden" id="periodo_id_2" name="periodo_id_2" value="">
     <input type="hidden" id="fecha_ini_2" name="fecha_ini_2" value="">
     <input type="hidden" id="fecha_fin_2" name="fecha_fin_2" value="">
     <input type="hidden" id="reporte_2" name="reporte_2" value="">
</form>
<table id="flex1" width="80%" style="border:1px #F2F2F2 solid" border="0"></table>