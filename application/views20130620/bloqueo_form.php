<?php
$this->load->view("header");
?>
<script>
$(document).ready(function(){
        
       $('#crnval').autocomplete({   
            
            source :'autocomplete',
            select : function(event,ui){
                $('#crn').val(ui.item.crn);
                $('#materia').val(ui.item.materia);
                $('#seccion').val(ui.item.seccion);
                $('#titulo').val(ui.item.titulo);
            }
        });

    
})
</script>
<style>
    #ui-id-1{width: 400px!important;}
    .ui-menu-item{list-style-type: none; font-size: 12px; font-weight: normal;}
</style>
<a  class="volver" href="<?php echo base_url()?>index.php/bloqueo/">Volver</a><br>
<?php if(validation_errors('<p class="error">','</p>')!=''){
echo form_open();
echo str_replace('&lt;', '<', str_replace('&gt;', '>', htmlentities(validation_errors('<p class="error">','</p>'), ENT_NOQUOTES)));
echo form_close();
} ?>
<?php echo form_open('bloqueo/'.$accion.'/'.$blq_id); ?>

	<h1><?php echo $titulo; ?> </h1>
	<p>
		<label for="crn">Bloquear CRN: </label>
		<?php echo form_input('crnval', '',' id="crnval" size="60"'); ?>		
	</p>
	<p>
            <input type="hidden" name="crn" id="crn" value="">
		<?php //echo form_hidden('crn', '',' id="crn"'); ?>		
	</p>
	<p>
		<label for="crn">Cod Materia: </label>
		<?php echo form_input('materia', set_value('materia', $materia),' id="materia" readonly'); ?>
	</p>
	<p>
		<label for="crn">Secci&oacute;n: </label>
		<?php echo form_input('seccion', set_value('seccion', $seccion),' id="seccion" readonly'); ?>
	</p>
	<p>
		<label for="crn">Titulo: </label>
		<?php echo form_input('titulo', set_value('titulo', $titulo),' id="titulo" readonly size="50"'); ?>
	</p>	
	<p>
		<?php echo form_submit('submit', $title); ?>
	</p>
<?php echo form_close(); ?>
<?php
$this->load->view("footer");
?>