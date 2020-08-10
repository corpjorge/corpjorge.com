<?php
$this->load->view("header");
?>
<style type="text/css">
.selTodo{
	padding: 0px !important;
}
</style>
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
    }else if(com=='Permitir bloqueo CRN'){
		var lista = new Array();
		$('.trSelected', grid).each(function(i) {
			var id = $(this).attr('id');
			id = id.substring(id.lastIndexOf('row')+3);
			lista[i]=id;
		});
		window.location.href='<?php echo base_url()?>index.php/departamento/actSol/'+lista.join("-");
    }else if(com=='No permitir bloqueo CRN'){
		var lista = new Array();
		$('.trSelected', grid).each(function(i) {
			var id = $(this).attr('id');
			id = id.substring(id.lastIndexOf('row')+3);
			lista[i]=id;
		});
		window.location.href='<?php echo base_url()?>index.php/departamento/desSol/'+lista.join("-");
    }
  }
  
	function selTodos(){
		$('#flex1 tr').addClass("trSelected");
	}

	function NoSelTodos(){
		$('#flex1 tr').removeClass("trSelected");
	}

	function recargarProgramas(){
		jQuery.ajax({
			url: "<?php echo base_url(); ?>index.php/departamento/actualizarProgramas/",
			type: "post",
			success: function(d){
				alert(d);
				window.location.reload();
			},
			error: function(d){
				alert("No se actualizaron los programas.");
			}
			
		});
	}
  
  $(document).ready(function() {
    $(function() {
    $("#flex1").flexigrid({
      url: '<?php echo base_url()?>index.php/departamento/page/',
      dataType: 'json',
      colModel : [
	{display: 'ID', name : 'dep_id', width : 40, sortable : true, align: 'left'},
	{display: 'Nombre', name : 'dep_nombre', width : 630, sortable : true, align: 'left'},
	{display: 'Bloqueo CRN', name : 'sol_creacion', width : 500, sortable : true, align: 'left'}
	/*{display: 'Externo', name : 'dep_externo', width : 150, sortable : true, align: 'left'}*/
      ],
      buttons : [
	/*{name: 'Borrar', bclass: 'delete', onpress : doCommand},*/
	{name: 'Actualizar l&iacute;mites', bclass: 'update', onpress : doCommand},
	{separator: true},
	{name: 'Permitir bloqueo CRN', bclass: 'actSol', onpress : doCommand},
	{name: 'No permitir bloqueo CRN', bclass: 'desSol', onpress : doCommand},
	{separator: true},
	{name: '<img src="<?php echo base_url()."css/seleccionar.png"; ?>" title="Seleccionar todos" height="22" align="left" />', bclass: 'selTodo', onpress : selTodos},
	{name: '<img src="<?php echo base_url()."css/quitarseleccion.png"; ?>" title="Quitar selecci&oacute;n" height="22" align="left" />', bclass: 'selTodo', onpress : NoSelTodos},
	{name: '<img src="<?php echo base_url()."css/recargar.png"; ?>" title="Actualizar programas" height="22" align="left" />', bclass: 'selTodo', onpress : recargarProgramas},
	/*{name: 'Crear', bclass: 'create', onpress : doCommand},*/
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