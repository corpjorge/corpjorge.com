<?php
$this->load->view("header");
?>
<script>
  mensaje = '<?php if(!empty($mensaje))echo urldecode($mensaje);else echo '';?>';
  if(mensaje!='')
    alert(mensaje);


function doCommand(com, grid) {
    var lista='';
    if (com == 'Borrar') {
	if(confirm('\u00bfEst\u00e1 Seguro?')){
	  $('.trSelected', grid).each(function() {
	    var id = $(this).attr('id');
	    id = id.substring(id.lastIndexOf('row')+3);
	    $.ajax({
	      url: '<?php echo base_url()?>index.php/bloqueo/borrar/',
	      data: 'coo_id='+id,
	      type: "POST",
	      success: function(html){		
		    $('#row'+id).remove();		
	      }
	    });
	  });	    
	}
    }else if(com='Crear'){
      window.location.href='<?php echo base_url()?>index.php/bloqueo/crear';
    }	
  }


 $(document).ready(function() {
    $(function() {
    $("#flex1").flexigrid({
      url: '<?php echo base_url()?>index.php/bloqueo/page/',
      dataType: 'json',
      colModel : [
	{display: 'ID', name : 'blq_id', width : 40, sortable : false, align: 'left'},
	{display: 'CRN', name : 'crn', width : 50, sortable : false, align: 'left'},	
	{display: 'Materia', name : 'titulo', width : 250, sortable : false, align: 'left'}	,
	{display: 'C&oacute;digo', name : 'materia', width : 80, sortable : false, align: 'left'},	
	{display: 'Secci&oacute;n', name : 'seccion', width : 50, sortable : false, align: 'left'},	
	{display: 'Bloqueado por', name : 'bloqueado_por', width : 100, sortable : false, align: 'left'},	
	{display: 'Fecha Bloqueo', name : 'fecha_bloqueo', width : 100, sortable : false, align: 'left'},
	{display: 'Período', name : 'periodo', width : 100, sortable : false, align: 'left'}	
      ],
      buttons : [
	{name: 'Borrar', bclass: 'delete', onpress : doCommand},	
	{name: 'Crear', bclass: 'create', onpress : doCommand},
	{separator: true}
      ],
      /*searchitems : [
	{display: 'ID', name : 'mov_id'},
	{display: 'Descripci&oacute;n', name : 'mov_descripcion', isdefault: true}*/
	/*{display: 'Tipo', name : 'tip_descripcion'},
	{display: 'Nombre', name : 'sol_nombre'},
	{display: 'Motivo', name : 'mov_descripcion'},
	{display: 'Estado', name : 'est_descripcion'}*/
      //],
      sortname: "blq_id",
      sortorder: "asc",
      usepager: true,
      title: "<?php echo $titulo;?>",
      useRp: false,
      rp: 20,
      showTableToggleBtn: false,
      resizable: false,
      width: 1200,
      height: 200,
      singleSelect: false
    }
    );
    });
  });
</script>
<table id="flex1" width="80%" style="border:1px #F2F2F2 solid" border="0"></table>  

<?php
$this->load->view("footer");
?>