<?php
$this->load->view("header");
?>
<a  class="volver" href="<?php echo base_url()?>index.php/noticias/">Volver</a><br>
<?php if(validation_errors('<p class="error">','</p>')!=''){
echo form_open();
echo str_replace('&lt;', '<', str_replace('&gt;', '>', htmlentities(validation_errors('<p class="error">','</p>'), ENT_NOQUOTES)));
echo form_close();
} ?>
<?php echo form_open('noticias/'.$accion.'/'.$not_id); ?>

	<h1><?php echo $titulo; ?> </h1>
	<p>
		<label for="noticia">Noticia: </label>
                <?php echo form_input('not_titulo', set_value('titulo', $not_titulo)); ?><br>
		<label for="noticia">Descripci&oacute;n: </label>
                <textarea id="noticia" name="noticia" rows="15" cols="60"><?php echo $noticia;?></textarea>
		<?php //echo form_textarea('noticia', set_value('noticia', $noticia),array('rows'=>30,'cols'=>30)); ?>
		<label for="link">Enlace: </label>
		<?php echo form_input('link', set_value('link', $link)); ?><br>
		<label for="link">Publicado: </label>
		<?php $checkeds=($publicado)?"checked":"";?>		
		<?php $checkedn=(!$publicado)?"checked":"";?>		
		<label for="link">Si </label>
		<?php echo form_radio('publicado', '1',$checkeds); ?>
		<label for="link">No </label>
		<?php echo form_radio('publicado', '0',$checkedn); ?>
		
	</p>
	<p>
		<?php echo form_submit('submit', $titulo); ?>
	</p>
<?php echo form_close(); ?>
<?php
$this->load->view("footer");
?>