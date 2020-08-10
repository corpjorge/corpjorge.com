<?php
$this->load->view("header");
?>
<script type="text/javascript">
mensaje = '<?php if(!empty($mensaje))echo urldecode($mensaje);else echo '';?>';
if(mensaje!='')
	alert(mensaje);
$(document).ready(function() {
	$("#various1").fancybox({
		'titlePosition'		: 'inside',
		'transitionIn'		: 'none',
		'transitionOut'		: 'none'
	});
});
</script>
<h3><?php echo $titulo;?></h3>
<a href="<?php echo base_url()?>index.php/solicitud/crear">Crear Solicitud</a><br>
<a id="various1" href="#comentario_nuevo"><?php $puede_cancelar = true; if($puede_cancelar) echo 'Cancelar Solicitud'; ?></a>
  <table width="80%" class="filter"  border="0">
    <tr>
	  <td width="80%">&nbsp;</td>
      <td><?php echo $paginacion?></td>
    </tr>
  </table>
  <table width="80%" style="border:1px #F2F2F2 solid" border="0">
    <tr>
      <td class="cellh">&nbsp;</td>
      <td class="cellh"><a href="#">Id <img src="order2.gif" border="0" /></a></td>
      <td class="cellh"><a href="#">Descripcion <img src="order2.gif" border="0" /></a></td>
      <td class="cellh"><a href="#">Tipo <img src="order2.gif" border="0" /> </a></td>
      <td class="cellh"><a href="#">Motivo <img src="order2.gif" border="0" /> </a></td>
	  <td class="cellh"><a href="#">Estado <img src="order2.gif" border="0" /> </a></td>
      <td class="cellh"><a href="#">Acciones <img src="order2.gif" border="0" /> </a></td>
    </tr>
    <?php foreach ($filas as $row): ?>
    <tr>
        <td class="cell"><label>
	<input name="checkbox" type="checkbox" value="checkbox" id="ck1" />
	</label></td>
	<td class="cell"><?php echo $row['sol_id']?></td>
	<td class="cell"><?php echo $row['sol_descripcion']?></td>
	<td class="cell"><?php echo $row['tip_descripcion']?></td>
    <td class="cell"><?php echo $row['mov_descripcion']?></td>
	<td class="cell"><?php echo $row['est_descripcion']?></td>	
	<td class="cell"><a href="<?php echo base_url()?>index.php/solicitud/actualizar/<?php echo $row['dep_id']?>">actualizar</a>&nbsp;&nbsp;<a href="<?php echo base_url()?>index.php/solicitud/borrar/<?php echo $row['dep_id']?>">borrar</a></td>
    </tr>
    <?php endforeach; ?>    
  </table>
  <p>&nbsp;</p>

<p>&nbsp;</p>
<div id='oculta_comentarios' style='display:none'>
	<div id='comentario_nuevo'>
	  <?php echo $comentario_form; ?>
	</div>
</div>
<?php
$this->load->view("footer");
?>