<?php
if(@$no_header=='no'){
//if(@$rol==3 && @$no_header!='') //estudiante
	if(!isset($_GET["raw"])){
		$this->load->view("header");
	}
}
?>
<?php if(@$no_header=='no'){ //if(@$rol==3 && @$no_header!=''){ //estudiante ?>
<a class="volver" href="<?php echo base_url()?>index.php/solicitud/" target="_top">Volver</a><br>
<? } ?>
<h4><?php echo $aviso; ?></h4>        
<?php
if(@$no_header=='no'){
//if(@$rol==3 && @$no_header!='') //estudiante
	if(!isset($_GET["raw"])){
		$this->load->view("footer");
	}
}
?>