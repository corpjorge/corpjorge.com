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
	
	{display: 'ID', name : 'sol_id', width : /*40*/40, sortable : true, align: 'left'},
	{display: 'Estado', name : 'est_id', width : /*40*/44, sortable : true, align: 'left'},
	{display: 'Fecha', name : 'sol_fec_creacion', width : 100, sortable : true, align: 'left'},
	{display: 'C&oacute;digo', name : 'sol_uidnumber', width : 60, sortable : true, align: 'left'},
	{display: 'Loginas', name : 'sol_login', width : 90, sortable : true, align: 'left'},
	{display: 'Estudiante', name : 'sol_nombre', width : 100, sortable : true, align: 'left'},
	{display: 'Apellido', name : 'sol_apellido', width : 150, sortable : true, align: 'left'},	
        {display: 'Programa', name : 'sol_prog', width : /*50*/160, sortable : true, align: 'left'},			
        {display: 'Doble Programa', name : 'sol_doble_prog', width : /*50*/160, sortable : true, align: 'left'},	
        {display: 'Cr&eacute;ditos Acumulados', name : 'sol_creditos', width : /*50*/100, sortable : true, align: 'left'},
        {display: 'Periodo', name : 'sol_periodo', width : /*50*/60, sortable : true, align: 'left'},
	{display: 'Cod Materia', name : 'sol_ins_mat', width : /*50*/60, sortable : true, align: 'left'},
	{display: 'CRN', name : 'sol_ins_crn', width : 40, sortable : true, align: 'left'},
	{display: 'Materia', name : 'sol_ins_des', width : /*200*/300, sortable : true, align: 'left'},
	{display: 'Secci&oacute;n', name : 'sol_ins_seccion', width : 40, sortable : true, align: 'left'},
	{display: 'Tipo', name : 'tip_id', width : /*100*/200, sortable : true, align: 'left'},
	{display: 'Motivo', name : 'mov_id', width : /*100*/200, sortable : true, align: 'left'},
	{display: 'Descripci&oacute;n', name : 'sol_descripcion', width : /*200*/300, sortable : true, align: 'left'},
	{display: 'Profesor', name : 'sol_ins_instructor', width : /*200*/300, sortable : true, align: 'left'}	  
	  
	//{display: 'ID', name : 'sol_id', width : /*40*/20, sortable : true, align: 'left'},
	//{display: 'Estado', name : 'est_id', width : /*40*/90, sortable : true, align: 'left'},	
	//{display: 'Login', name : 'sol_login', width : 90, sortable : true, align: 'left'},		
	//{display: 'Cod Materia', name : 'sol_ins_mat', width : /*50*/60, sortable : true, align: 'left'},
	//{display: 'CRN', name : 'sol_ins_crn', width : 40, sortable : true, align: 'left'},
	//{display: 'Materia', name : 'sol_ins_des', width : /*200*/300, sortable : true, align: 'left'},
	//{display: 'Secci&oacute;n', name : 'sol_ins_seccion', width : 40, sortable : true, align: 'left'},
	//{display: 'Profesor', name : 'sol_ins_instructor', width : /*200*/300, sortable : true, align: 'left'},
	//{display: 'Descripci&oacute;n', name : 'sol_descripcion', width : /*200*/300, sortable : true, align: 'left'},
	//{display: 'Tipo', name : 'tip_id', width : /*100*/200, sortable : true, align: 'left'},
	//{display: 'Motivo', name : 'mov_id', width : /*100*/200, sortable : true, align: 'left'},
	//{display: 'Fecha', name : 'sol_fec_creacion', width : 100, sortable : true, align: 'left'},
	//{display: 'Estudiante', name : 'sol_nombre', width : 100, sortable : true, align: 'left'},
	//{display: 'Apellido', name : 'sol_apellido', width : 150, sortable : true, align: 'left'},
	//{display: 'C&oacute;digo', name : 'sol_uidnumber', width : 60, sortable : true, align: 'left'}
      ],
      buttons : [
	{name: 'Cancelar', bclass: 'delete', onpress : doCommand},
	{name: 'Comentarios', bclass: 'comment', onpress : doCommand},
	{name: 'Crear solicitud', bclass: 'create', onpress : doCommand},
	{name: 'Ver solicitud', bclass: 'view', onpress : doCommand},
	{name: 'Seleccionar todos', bclass: 'selectall', onpress : doCommand},
	{separator: true}
      ],
      searchitems : [
            {display: 'ID', name : 'sol_id'},
            {display: 'Estado', name : 'est_descripcion'},
            {display: 'Fecha', name : 'sol_fec_creacion'},
            {display: 'C&oacute;digo', name : 'sol_uidnumber'},
            {display: 'Login', name : 'sol_login'},
            {display: 'Estudiante', name : 'sol_nombre'},
            {display: 'Apellido', name : 'sol_apellido'},
            {display: 'Programa', name : 'sol_prog'},
            {display: 'Doble Programa', name : 'sol_doble_prog'},
            {display: 'Cr&eacute;ditos Acumulados', name : 'sol_creditos'},
            {display: 'Periodo', name : 'sol_periodo'},
            {display: 'Cod Materia', name : 'sol_ins_mat'},
            {display: 'CRN', name : 'sol_ins_crn'},
            {display: 'Materia', name : 'sol_ins_des'},
            {display: 'Secci&oacute;n', name : 'sol_ins_seccion'},
            {display: 'Tipo', name : 'tip_descripcion'},
            {display: 'Motivo', name : 'mov_descripcion'},
            {display: 'Descripci&oacute;n', name : 'sol_descripcion', isdefault: true},
            {display: 'Profesor', name : 'sol_ins_instructor'}  
      ],
      searchitems2 : [
            {display: 'ID', name : 'sol_id'},
            {display: 'Estado', name : 'est_descripcion'},
            {display: 'Fecha', name : 'sol_fec_creacion'},
            {display: 'C&oacute;digo', name : 'sol_uidnumber'},
            {display: 'Login', name : 'sol_login'},
            {display: 'Estudiante', name : 'sol_nombre'},
            {display: 'Apellido', name : 'sol_apellido'},
            {display: 'Programa', name : 'sol_prog'},
            {display: 'Doble Programa', name : 'sol_doble_prog'},
            {display: 'Cr&eacute;ditos Acumulados', name : 'sol_creditos'},
            {display: 'Periodo', name : 'sol_periodo'},
            {display: 'Cod Materia', name : 'sol_ins_mat'},
            {display: 'CRN', name : 'sol_ins_crn'},
            {display: 'Materia', name : 'sol_ins_des'},
            {display: 'Secci&oacute;n', name : 'sol_ins_seccion'},
            {display: 'Tipo', name : 'tip_descripcion'},
            {display: 'Motivo', name : 'mov_descripcion'},
            {display: 'Descripci&oacute;n', name : 'sol_descripcion', isdefault: true},
            {display: 'Profesor', name : 'sol_ins_instructor'}  
      ],
      sortname: "sol_id",
      sortorder: "asc",
      usepager: true,
      title: "<?php echo $titulo;?>",
      useRp: true,
      rp: 20,
      showTableToggleBtn: false,
      resizable: true,
      width: 1200,
      height: 600,
      singleSelect: false
    }
    );
	$("input[name=q2]").css("display", "none");
	$("select[name=qtype2]").css("display", "none");	
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
    }else if(com=='Crear solicitud'){
      window.location.href='<?php echo base_url()?>index.php/solicitud/crear';
    }else if(com=='Comentarios'){
	$('.trSelected', grid).each(function() {
	var id = $(this).attr('id');
	id = id.substring(id.lastIndexOf('row')+3);
	lista=id+'*';
      });
      var todos = lista.split('*');
      if(!todos[0]=='')
      window.location.href='<?php echo base_url()?>index.php/solicitud/comentario/'+todos[0];
    }else if(com=='Ver solicitud'){
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
    }		
  }
  
</script>
<br>
<table width="100%" border="0" style="border:1px #F2F2F2 solid; color:#FFFFFF">
    <tbody><tr>
      <td style="background-color:#CC0000; font-size:10px">En revisi&oacute;n </td>
      <td style="background-color:#7030A0; font-size:10px">Solicitudes No Exitosas</td>
      <td style="background-color:#00B050; font-size:10px">Solicitudes Exitosas</td>
      <td style="background-color:#FFC000; font-size:10px">En espera de respuesta del estudiante </td>
      <td style="background-color:#FF8000; font-size:10px">En espera de respuesta del coordinador </td>
      <td style="background-color:#000000; font-size:10px">Solicitudes Ignoradas</td>
      <td style="background-color:#0070C0; font-size:10px">Lista de Espera </td>
    </tr>
  </tbody></table>
<br>
<table id="flex1" width="80%" style="border:1px #F2F2F2 solid" border="0"></table>
<?php
$this->load->view("footer");
?>