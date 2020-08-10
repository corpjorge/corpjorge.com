<?php $this->load->view("header"); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script>
	jQuery(function() {
		jQuery( "#tabs" ).tabs();
	});
	jQuery(window).load(function(){
		jQuery("iframe").each(function(i){
			if (jQuery(this).parent().css('display')=='none')
			{
				jQuery(this).parent().css('display','block');
				var h = jQuery(this).contents().find("html").height();
				jQuery(this).parent().css('display','none');
			}
			else
			{
				var h = jQuery(this).contents().find("html").height();
			}
			if (h !=0)
				jQuery(this).height(h);
		});
	});
</script>
<style type="text/css">
iframe{
	width: 100%;
}
</style>
<?php
if(substr_count($sol_id, '-') < 2){
	$filas = explode(';',$ordenfilas);
	foreach($filas as $indice=>$fila){
		if(str_replace('-', '', $sol_id)==$fila){		
			$sol_id_anterior = $indice == 0 ? $filas[count($filas) - 1] : $filas[$indice - 1];
			$sol_id_siguiente = $indice == count($filas) - 1 ? $filas[0] : $filas[$indice + 1];		
		}	
	}
	//echo "sol_id $sol_id<br>$ordenfilas - $sol_id $sol_id_anterior - $sol_id_siguiente";
	//echo "<br>ordenfilas $ordenfilas,<br> ordenfilas_paginado $ordenfilas_paginado";	
}
?>
<a class="volver" href="<?php echo base_url()?>index.php/solicitud/">Volver</a>
<?php if(substr_count($sol_id, '-') < 2 && $rol_botones!=3){ ?>
<div style="text-align:center">
	<a href="<?php echo base_url()?>index.php/solicitud/ver/<?php echo @$sol_id_anterior; ?>">Anterior</a> | 
	<a href="<?php echo base_url()?>index.php/solicitud/ver/<?php echo @$sol_id_siguiente; ?>">Siguiente</a><br>
</div>
<?php } ?>
<br /><br />
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Detalle</a></li>
		<li><a href="#tabs-2">Comentario</a></li>
		<?php if ($this->session->userdata('rol') !=3 ) :?>
			<li><a href="#tabs-3">Cambio de estado</a></li>
		<?php endif;?>
		<li><a href="#tabs-4">Histórico</a></li>
	</ul>
	<div id="tabs-1">
		<iframe class="tabcontent" src="<?php echo base_url()."index.php/solicitud/detalle/".$sol_id; ?>" frameborder="0" ></iframe>
	</div>                                  
	<div id="tabs-2">
		<iframe class="tabcontent" src="<?php echo base_url()."index.php/solicitud/comentario/".$sol_id; ?>" frameborder="0" ></iframe>
	</div>                                  
	<?php if ($this->session->userdata('rol') !=3 ) :?>
		<div id="tabs-3">
			<iframe class="tabcontent" src="<?php echo base_url()."index.php/solicitud/formaestado/".$sol_id."?raw=1"; ?>" frameborder="0" ></iframe>			
		</div>
	<?php endif;?>
	<div id="tabs-4">
		<iframe class="tabcontent" src="<?php echo base_url()."index.php/solicitud/historico/".$sol_id."?raw=1"; ?>" frameborder="0" ></iframe>
	</div>
</div>
<?php $this->load->view("footer"); ?>