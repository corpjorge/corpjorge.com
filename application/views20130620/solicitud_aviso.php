<?php
if(@$no_header=='no')
//if(@$rol==3 && @$no_header!='') //estudiante
	$this->load->view("header");
?>
<?php if(@$no_header=='no'){ //if(@$rol==3 && @$no_header!=''){ //estudiante ?>
<a class="volver" href="<?php echo base_url()?>index.php/solicitud/">Volver</a><br>
<? } ?>
<h3><?php echo $aviso; ?></h3>        
<?php
if(@$no_header=='no')
//if(@$rol==3 && @$no_header!='') //estudiante
	$this->load->view("footer");
?>