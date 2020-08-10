<?php
$this->load->view("header");
?>
<h3><?php echo $titulo;?></h3>
<div id="listado">
    <a href="<?php echo base_url();?>index.php/motivo">Motivos</a><br>
    <a href="<?php echo base_url();?>index.php/tipo">Tipos</a><br>
    <a href="<?php echo base_url();?>index.php/rol">Roles</a><br>
    <a href="<?php echo base_url();?>index.php/nivel">Niveles</a><br>
    <a href="<?php echo base_url();?>index.php/estado">Estados</a><br>
    <a href="<?php echo base_url();?>index.php/parametro">Otros</a><br>
</div>
<?php
$this->load->view("footer");
?>