<?php
$this->load->view("header");
?>
<script>
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
	window.location.href='<?php echo base_url()?>index.php/motivo/actualizar/'+todos[0];
    } else if (com == 'Borrar') {
	if(confirm('\u00bfEst\u00e1 Seguro?')){
	  $('.trSelected', grid).each(function() {
	    var id = $(this).attr('id');
	    id = id.substring(id.lastIndexOf('row')+3);
	    $.ajax({
	      url: '<?php echo base_url()?>index.php/motivo/borrar/',
	      data: 'coo_id='+id,
	      type: "POST",
	      success: function(html){		
		    $('#row'+id).remove();		
	      }
	    });
	  });	    
	}
    }else if(com='Crear'){
      window.location.href='<?php echo base_url()?>index.php/motivo/crear';
    }	
  }


 $(document).ready(function() {
    $(function() {
    $("#flex1").flexigrid({
      url: '<?php echo base_url()?>index.php/motivo/page/',
      dataType: 'json',
      colModel : [
	{display: 'ID', name : 'mov_id', width : 40, sortable : false, align: 'left'},
	{display: 'Descripci&oacute;n', name : 'mov_descripcion', width : 250, sortable : false, align: 'left'}	
      ],
      buttons : [
	{name: 'Borrar', bclass: 'delete', onpress : doCommand},
	{name: 'Actualizar', bclass: 'update', onpress : doCommand},
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
      sortname: "mov_id",
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