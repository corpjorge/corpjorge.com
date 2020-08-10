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
	window.location.href='<?php echo base_url()?>index.php/tipo/actualizar/'+todos[0];
    } else if (com == 'Borrar') {
	if(confirm('\u00bfEst\u00e1 Seguro?')){
	  $('.trSelected', grid).each(function() {
	    var id = $(this).attr('id');
	    id = id.substring(id.lastIndexOf('row')+3);
	    $.ajax({
	      url: '<?php echo base_url()?>index.php/tipo/borrar/',
	      data: 'coo_id='+id,
	      type: "POST",
	      success: function(html){		
		    $('#row'+id).remove();		
	      }
	    });
	  });	    
	}
    }else if(com='Crear'){
      window.location.href='<?php echo base_url()?>index.php/tipo/crear';
    }	
  }


 $(document).ready(function() {
    $(function() {
    $("#flex1").flexigrid({
      url: '<?php echo base_url()?>index.php/tipo/page/',
      dataType: 'json',
      colModel : [
	{display: 'ID', name : 'tip_id', width : 40, sortable : false, align: 'left'},
	{display: 'Descripci&oacute;n', name : 'tip_descripcion', width : 150, sortable : false, align: 'left'}	
      ],
      buttons : [
	{name: 'Borrar', bclass: 'delete', onpress : doCommand},
	{name: 'Actualizar', bclass: 'update', onpress : doCommand},
	{name: 'Crear', bclass: 'create', onpress : doCommand},
	{separator: true}
      ],
      /*searchitems : [
	{display: 'ID', name : 'tip_id'},
	{display: 'Descripci&oacute;n', name : 'tip_descripcion', isdefault: true}*/
	/*{display: 'Tipo', name : 'tip_descripcion'},
	{display: 'Nombre', name : 'sol_nombre'},
	{display: 'Motivo', name : 'mov_descripcion'},
	{display: 'Estado', name : 'est_descripcion'}*/
      //],
      sortname: "tip_id",
      sortorder: "asc",
      usepager: true,
      title: "<?php echo $titulo;?>",
      useRp: false,
      rp: 20,
      showTableToggleBtn: false,
      resizable: false,
      width: 1200,
      height: 100,
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