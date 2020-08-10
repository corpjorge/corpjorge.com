<?php
$this->load->view("header");
?>
<script>  
  mensaje = '<?php if(!empty($mensaje))echo urldecode($mensaje);else echo '';?>';
  if(mensaje!='')
    alert(mensaje);
    
  function doCommand(com, grid) {
    var lista='';
    if (com == 'Actualizar l&iacute;mites') {
      $('.trSelected', grid).each(function() {
	var id = $(this).attr('id');
	id = id.substring(id.lastIndexOf('row')+3);
	lista=id+'*';
      });
      var todos = lista.split('*');
      if(!todos[0]=='')
	window.location.href='<?php echo base_url()?>index.php/departamento/actualizar/'+todos[0];
    } else if (com == 'Borrar') {
      if(confirm('Está Seguro?')){
	$('.trSelected', grid).each(function() {
	  var id = $(this).attr('id');
	  id = id.substring(id.lastIndexOf('row')+3);
	  $.ajax({
	    url: '<?php echo base_url()?>index.php/departamento/borrar/',
	    data: 'dep_id='+id,
	    type: "POST",
	    success: function(html){
	      if(html=="OK")
		  $('#row'+id).remove();
	      else
	      $("#limites").html(html);
	    }
	  });
	});
      }	
    }else if(com=='Crear'){
      window.location.href='<?php echo base_url()?>index.php/departamento/crear';
    }	
  }
  $(document).ready(function() {
    $(function() {
    $("#flex1").flexigrid({
      url: '<?php echo base_url()?>index.php/departamento/page/',
      dataType: 'json',
      colModel : [
	{display: 'ID', name : 'dep_id', width : 40, sortable : true, align: 'left'},
	{display: 'Nombre', name : 'dep_nombre', width : 1130, sortable : true, align: 'left'}
	/*{display: 'Externo', name : 'dep_externo', width : 150, sortable : true, align: 'left'}*/
      ],
      buttons : [
	/*{name: 'Borrar', bclass: 'delete', onpress : doCommand},*/
	{name: 'Actualizar l&iacute;mites', bclass: 'update', onpress : doCommand},
	/*{name: 'Crear', bclass: 'create', onpress : doCommand},*/
	{separator: true}
      ],
      /*searchitems : [
	{display: 'ID', name : 'dep_id'},
	{display: 'Nombre', name : 'dep_nombre', isdefault: true}*/
	/*{display: 'Externo', name : 'dep_externo'}*/
      //],
      sortname: "dep_id",
      sortorder: "asc",
      usepager: true,
      title: "<?php echo $titulo;?>",
      useRp: false,
      rp: 20,
      showTableToggleBtn: false,
      resizable: false,
      width: 1200,
      height: 505,
      singleSelect: false
    }
    );
    });
  });  
</script>
<table id="flex1" width="80%" style="border:1px #F2F2F2 solid" border="0"></table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php
$this->load->view("footer");
?>