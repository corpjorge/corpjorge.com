<?php
$this->load->view("header");
?>
<script type="text/javascript">  
$(function() {
    $('.datetime').datepicker({
    	duration: '',
        showTime: true,
        constrainInput: false,
        stepMinutes: 1,  
        stepHours: 1,  
        altTimeField: '',  
        time24h: true,
		dateFormat: 'yy-mm-dd'
     });  
});  
</script>
<a  class="volver" href="<?php echo base_url()?>index.php/coordinador/">Volver</a><br>
<?php if(validation_errors('<p class="error">','</p>')!=''){
echo form_open();
echo str_replace('&lt;', '<', str_replace('&gt;', '>', htmlentities(validation_errors('<p class="error">','</p>'), ENT_NOQUOTES)));
echo form_close();
} ?>
<?php echo form_open('coordinador/'.$accion.'/'.$coo_id); ?>

	<h1><?php echo $titulo; ?> coordinador</h1>
	<table class='formtable'>
	<?php echo form_hidden('coo_id', set_value('coo_id', $coo_id)); ?>
	<?php $_POST['coo_id'] = isset($_POST['coo_id']) ? $_POST['coo_id'] : ''; ?>
	<tr>
		<td class="tdlabel">Nombre: </td>
		<td><?php echo form_input('coo_nombre', set_value('coo_nombre', $coo_nombre)); ?>
		<?php //echo form_error('coo_nombre'); ?></td>
	</tr>
	<tr>
		<td class="tdlabel">Login: </td>
		<td><?php echo form_input('coo_login', set_value('coo_login', $coo_login)); ?>
		<?php //echo form_error('coo_login'); ?></td>
	</tr>
	<!--<tr>
		<td class="tdlabel">Email: </td>
		<td><?php echo form_input('coo_email', set_value('coo_email', $coo_email)); ?>
		<?php //echo form_error('coo_email'); ?></td>
	</tr>-->
	<tr>
		<td class="tdlabel">Asistente: </td>
		<td><?php //$c = set_value('coo_asistente', $coo_asistente)=='1' ? true : false; ?>
		<?php //echo form_checkbox('coo_asistente', '1', set_checkbox('coo_asistente', '1', $c)); ?>
		<?php
		$_POST['coo_asistente'] = isset($_POST['coo_asistente']) ? $_POST['coo_asistente'] : '';
		$checked = ($_POST['coo_id']=='' && $coo_asistente=='1') || $_POST['coo_asistente']=='1' ? 'checked' : ''; ?>
		<input name="coo_asistente" type="checkbox" value="1" id="coo_asistente" <?php echo $checked; ?> />
		<?php //echo form_error('coo_asistente'); ?></td>
	</tr>	
	<tr>
		<td class="tdlabel">Nivel: </td>
		<td>
		    <?php
			$niv_ids = $niv_id!='' ? explode('*', $niv_id) : array();
			$_POST['niv_ids'] = isset($_POST['niv_ids']) || $_POST['coo_id']!='' ? @$_POST['niv_ids'] : $niv_ids;
			?>			
		    <?php foreach ($options_nivel as $key=>$row):?>
		    <?php if($key !=""){?>			
			<?php $checked = ($_POST['niv_ids']=='' && $_POST['coo_id']=='' && in_array($key, $niv_id)) || (is_array($_POST['niv_ids']) && in_array($key, $_POST['niv_ids'])) || $_POST['niv_ids']==$key ? 'checked' : ''; ?>
			<input name="niv_ids[]" type="checkbox" value="<?php echo $key?>" id="niv_ids" <?php echo $checked; ?> /><label><?php echo utf8_encode($row) ?></label>&nbsp;
		    <?php }?>							     
		    <?php endforeach; ?>
		</td>
	</tr>
	<!--<tr>
		<td>Departamento: </td>
		<td><?php echo form_dropdown('dep_id',$options_departamento, set_value('dep_id', $dep_id)); ?>
		<?php //echo form_error('dep_id'); ?><td>
	</tr>-->
	<tr>
		<td class="tdlabel">Rol: </td>
		<td><?php echo form_dropdown('rol_id',$options_rol, set_value('rol_id', $rol_id)); ?>
		<?php //echo form_error('rol_id'); ?></td>
	</tr>
	<tr>
		<table class='formtable' width="80%" style="border:1px #F2F2F2 solid" border="0">
			<tr>
				<td class="cellh">&nbsp;</td>
				<!--<td class="cellh"><strong>Id</strong> <img src="order2.gif" border="0" /></td>-->
				<td class="cellh"><strong>Programa</strong> <!--<img src="order2.gif" border="0" />--></td>
			</tr>
			<?php $dep_id = $dep_id!='' ? explode('*', $dep_id) : array(); ?>
			<?php foreach ($departamentos as $row): ?>
			<tr>
				<td class="cell"><label>
				<?php
				$_POST['dep_ids'] = isset($_POST['dep_ids']) ? $_POST['dep_ids'] : '';								
				$checked = ($_POST['dep_ids']=='' && $_POST['coo_id']=='' && in_array($row['dep_id'], $dep_id)) || (is_array($_POST['dep_ids']) && in_array($row['dep_id'], $_POST['dep_ids'])) || $_POST['dep_ids']==$row['dep_id'] ? 'checked' : ''; ?>
				<input name="dep_ids[]" type="checkbox" value="<?php echo $row['dep_id']?>" id="dep_ids" <?php echo $checked; ?> />
				</label></td>
				<!--<td class="cell"><?php echo $row['dep_id']?></td>-->
				<td class="cell"><?php echo $row['dep_nombre']?></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</tr>
	<tr>
		<?php echo form_submit('submit', $titulo); ?>
	</tr>
	</table>
<?php echo form_close(); ?>
<?php
$this->load->view("footer");
?>