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
        
        var id=$('.trSelected', grid).attr('id')
        id = id.substring(id.lastIndexOf('row')+3);        
	window.location.href='<?php echo base_url()?>index.php/noticias/actualizar/'+id;
    }      
  }


 $(document).ready(function() {
    $(function() {
    $("#flex1").flexigrid({
      url: '<?php echo base_url()?>index.php/noticias/page/',
      dataType: 'json',
      colModel : [
	{display: 'ID', name : 'not_id', width : 40, sortable : false, align: 'left'},
	{display: 'Titulo', name : 'not_titulo', width : 100, sortable : false, align: 'left'},	
	{display: 'Noticia', name : 'noticia', width : 750, sortable : false, align: 'left'},	
	{display: 'Link', name : 'link', width : 150, sortable : false, align: 'left'}	
      ],
      buttons : [
	{name: 'Actualizar', bclass: 'update', onpress : doCommand},		
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
      sortname: "not_id",
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