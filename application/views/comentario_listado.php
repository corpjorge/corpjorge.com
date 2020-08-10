<?php
//$this->load->view("header");
?>
<script>
  mensaje = '<?php if(!empty($mensaje))echo urldecode($mensaje);else echo '';?>';
  if(mensaje!='')
    alert(mensaje);
</script>
<h3><?php //echo $titulo;?></h3>
<!--<a href="<?php echo base_url()?>index.php/comentario/crear">Crear Comentario</a>-->
  <!--<table width="80%" class="filter"  border="0">
    <tr>
	  <td width="80%">&nbsp;</td>
      <td><?php //echo $paginacion?></td>
    </tr>
  </table>-->  
  <table width="80%" style="border:1px #F2F2F2 solid" border="0">
    <!--<tr>
      <td class="cellh">Login </td>
	  <td class="cellh">Rol </td>
	  <td class="cellh">Remite </td>
	  <td class="cellh">Mensaje</td>
      <td class="cellh">Fecha/Hora</td>
    </tr>-->
    <?php foreach ($filas as $row): ?>
    <tr>
	<td class="cellh" width="30%"><?php echo "<strong>".$row['com_login']."</strong>"?><br>
	<?php echo "<strong>".$row['rol_descripcion']."</strong>"?><br>
		<?php echo $row['com_nombre']?><br>
		<?php echo $row['com_fecha']?><br>
	</td>
	<td class="cell" width="70%"><?php echo $row['com_texto']?></td>
	</tr>
    <?php endforeach; ?>
  </table>
  <p>&nbsp;</p>

<p>&nbsp;</p>
<?php
//$this->load->view("footer");
?>