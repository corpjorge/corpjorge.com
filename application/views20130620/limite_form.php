<script type="text/javascript">
function save_limite(id){
    var data1 = $('#form_limite').serialize();
    //alert(data1);
    $.ajax({
      url: '<?php echo base_url()?>index.php/departamento/relate/'+id,
      data: data1,
      type: "POST",
      success: function(html){
	if(html=="OK")
	    window.location.href='<?php echo base_url()?>index.php/departamento/actualizar/';//+id;
	else
	$("#limites").html(html);
      }
    });
}
$(function() {
    $('.datetime').datepicker({
    	duration: '',
        showTime: true,
        constrainInput: false,
        stepMinutes: 1,  
        stepHours: 1,  
        altTimeField: '',  
        time24h: true,
		dateFormat: 'yy-mm-dd',
		onSelect: function () {
			$.datepicker._hideDatepicker();
		}
		/*monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
		monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
		dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
		dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab']*/	
     });  
});  
</script>
<?php if(validation_errors('<p class="error">','</p>')!=''){
echo form_open();
echo str_replace('&lt;', '<', str_replace('&gt;', '>', htmlentities(validation_errors('<p class="error">','</p>'), ENT_NOQUOTES)));
echo form_close();
} ?>
<?php
    $attributes = array('id' => 'form_limite');
    echo form_open('departamento/relate/'.$dep_id,$attributes);
?>
	<table class='formtable'>
	<tr>
		<td class="tdlabel">Fecha apertura de solicitud: </td>
		<td><input type="text" name="lim_fec_a_sol" id="lim_fec_a_sol" value="<?php echo set_value('lim_fec_a_sol', $lim_fec_a_sol); ?>" class="datetime" readonly>
		<?php //echo form_error('descripcion'); ?></td>
	</tr>
	<tr>
		<td class="tdlabel">Fecha cierre de solicitud: </td>
		<td><input type="text" name="lim_fec_c_sol" id="lim_fec_c_sol" value="<?php echo set_value('lim_fec_c_sol', $lim_fec_c_sol); ?>" class="datetime" readonly>
		<?php //echo form_error('descripcion'); ?></td>
	</tr>
	<tr>
		<td class="tdlabel">Fecha apertura de gesti&oacute;n: </td>
		<td><input type="text" name="lim_fec_a_ges" id="lim_fec_a_ges" value="<?php echo set_value('lim_fec_a_ges', $lim_fec_a_ges); ?>" class="datetime" readonly>
		<?php //echo form_error('descripcion'); ?></td>
	</tr>
	<tr>
		<td class="tdlabel">Fecha cierre de gesti&oacute;n: </td>
		<td><input type="text" name="lim_fec_c_ges" id="lim_fec_c_ges" value="<?php echo set_value('lim_fec_c_ges', $lim_fec_c_ges); ?>" class="datetime" readonly>
		<?php //echo form_error('descripcion'); ?>
		<input type="hidden" name="dep_id" id="dep_id" value="<?php echo $dep_id?>"></td>
	</tr>
	<tr>
	    <td class="tdlabel">Marque la casilla si desea replicar las fechas actuales en los dem&aacute;s programas: <?php		 
		 $valores = array(
			'name'        => 'replicar',
			'id'          => 'replicar',
			'value'       => 1,
			'checked'     => FALSE,			
		 );
		 echo form_checkbox($valores);
	    ?></td>
	    <td>&nbsp;</td>
	</tr>
	<tr>
		<td><input type="button" value="Actualizar" onclick="save_limite(<?php echo "'".$dep_id."'"?>)"></td>
		<td>&nbsp;</td>
	</tr>
	</table>
<?php echo form_close(); ?>
