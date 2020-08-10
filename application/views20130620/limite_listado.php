<?php
$this->load->view("header");
?>
<script>
  mensaje = '<?php if(!empty($mensaje))echo urldecode($mensaje);else echo '';?>';
  if(mensaje!='')
    alert(mensaje);
</script>
<h3><?php echo $titulo;?></h3>
<a href="<?php echo base_url()?>index.php/limite/crear">Crear Limite</a>
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
      <td class="cellh"><a href="#">Fecha apertura de solicitud <img src="order2.gif" border="0" /></a></td>
	  <td class="cellh"><a href="#">Fecha cierre de solicitud <img src="order2.gif" border="0" /></a></td>
	  <td class="cellh"><a href="#">Fecha apertura de gestión <img src="order2.gif" border="0" /></a></td>
	  <td class="cellh"><a href="#">Fecha cierre de gestión <img src="order2.gif" border="0" /></a></td>
      <td class="cellh"><a href="#">Acciones <img src="order2.gif" border="0" /> </a></td>
    </tr>
    <?php foreach ($filas as $row): ?>
    <tr>
        <td class="cell"><label>
	<input name="checkbox" type="checkbox" value="checkbox" id="ck1" />
	</label></td>
	<td class="cell"><?php echo $row['lim_id']?></td>
	<td class="cell"><?php echo $row['lim_fec_a_sol']?></td>
	<td class="cell"><?php echo $row['lim_fec_c_sol']?></td>
	<td class="cell"><?php echo $row['lim_fec_a_ges']?></td>
	<td class="cell"><?php echo $row['lim_fec_c_ges']?></td>
	<td class="cell"><a href="<?php echo base_url()?>index.php/limite/actualizar/<?php echo $row['lim_id']?>">actualizar</a>&nbsp;&nbsp;<a href="<?php echo base_url()?>index.php/limite/borrar/<?php echo $row['lim_id']?>">borrar</a></td>
    </tr>
    <?php endforeach; ?>
  </table>
  <p>&nbsp;</p>

<p>&nbsp;</p>
<?php
$this->load->view("footer");
?>