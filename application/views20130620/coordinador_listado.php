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
	window.location.href='<?php echo base_url()?>index.php/coordinador/actualizar/'+todos[0];
    } else if (com == 'Borrar') {
	if(confirm('\u00bfEst\u00e1 Seguro?')){
	  $('.trSelected', grid).each(function() {
	    var id = $(this).attr('id');
	    id = id.substring(id.lastIndexOf('row')+3);
	    $.ajax({
	      url: '<?php echo base_url()?>index.php/coordinador/borrar/',
	      data: 'coo_id='+id,
	      type: "POST",
	      success: function(html){		
		    $('#row'+id).remove();		
	      }
	    });
	  });	    
	}
    }else if(com=='Crear'){
      window.location.href='<?php echo base_url()?>index.php/coordinador/crear';
    }else if(com=='Generar excel'){	  
	  $('#excelform').submit();
    }	
  }
  $(document).ready(function() {
    $(function() {
        $("#flex1").flexigrid({
          url: '<?php echo base_url()?>index.php/coordinador/page/',
          dataType: 'json',
          colModel : [
            {display: 'ID', name : 'coo_id', width : 40, sortable : true, align: 'left'},
            {display: 'Nombre', name : 'coo_nombre', width : 150, sortable : true, align: 'left'},
            {display: 'Login', name : 'coo_login', width : 150, sortable : true, align: 'left'},
            {display: 'Email', name : 'coo_email', width : 150, sortable : true, align: 'left'},
            {display: 'Asistente', name : 'coo_asistente', width : 150, sortable : true, align: 'left'},
            {display: 'Nivel', name : 'niv_descripcion', width : 150, sortable : true, align: 'left'},
            {display: 'Cod Dep', name : /*'dep_nombre'*/'dep_id', width : 150, sortable : true, align: 'left'},
            {display: 'Departamento', name : /*'dep_nombre'*/'dep_nom', width : 150, sortable : true, align: 'left'},
            {display: 'Rol', name : 'rol_descripcion', width : 150, sortable : true, align: 'left'}
          ],
          buttons : [
            {name: 'Borrar', bclass: 'delete', onpress : doCommand},
            {name: 'Actualizar', bclass: 'update', onpress : doCommand},
            {name: 'Crear', bclass: 'create', onpress : doCommand},
            {name: 'Generar excel', bclass: 'excel', onpress : doCommand},
            {separator: true}
          ],
          searchitems : [
            {display: 'ID', name : 'coo_id'},
            {display: 'Nombre', name : 'coo_nombre', isdefault: true},
            {display: 'Login', name : 'coo_login'},
            {display: 'Email', name : 'coo_email'},            
            {display: 'C&oacute;digo Depto', name : 'dep_id'}            
            ],
          searchitems2 : [            
            {display: 'Nombre', name : 'coo_nombre', isdefault: true}
            ],

          /*searchitems : [
            {display: 'ID', name : 'coo_id'},
            {display: 'Nombre', name : 'coo_nombre', isdefault: true},
            {display: 'Login', name : 'coo_login'},
            {display: 'Email', name : 'coo_email'},
            {display: 'Asistente', name : 'coo_asistente'},
            {display: 'Nivel', name : 'niv_descripcion'},
            {display: 'Departamento', name : 'dep_id'},
            {display: 'Rol', name : 'rol_descripcion'}	
          ],*/
          sortname: "coo_id",
          sortorder: "asc",
          usepager: true,
          title: "<?php echo $titulo;?>",
          useRp: true,
          rp: 20,
          showTableToggleBtn: false,
          resizable: false,
          width: 1200,
          height: 505,
          singleSelect: false
        }
        );
        $("input[name=q2]").css("display", "none");
	$("select[name=qtype2]").css("display", "none");
    });
  });  
</script>

<table id="flex1" width="80%" style="border:1px #F2F2F2 solid" border="0"></table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<form name="excelform" id="excelform" action="<?php echo base_url();?>index.php/coordinador/excel" method="POST" style="border: none;">
     
</form>
<?php
$this->load->view("footer");
?>