<?php
$this->load->view("header");
$buscar="Buscar";
?>
<script  type="text/javascript">
function elreporte(id){
    $("#tiporeporte").val(id);
}

/*$(document).ready(function(){    
    
	if($('[name="pidm"]').attr('value')=='' || $('[name="pidm"]').attr('value')=='0'){
    $('.wrapper-header').css('display','none');
    //$('input[placeholder]').placeholder();
    $.ajax({
               type: 'POST',
			   data: 'id_input=<? echo @$id_input ?>',
               url: '<?php echo base_url()?>index.php/reporte/busquedaReporte',                              
               success: function(datos){
                   //$("#tablaResultados").append(datos);
		   $("#tablaResultados").html(datos);
               }
           });
	}
});*/
function buscar(actual,filas,busqueda){
    
    var res = false;
    var datoini = $('input:text[name=fecha_ini]').val();
    var datofin = $('input:text[name=fecha_fin]').val();
    
    datoa = datoini.split(' ');
    datob = datofin.split(' ');
    
    datoa = datoa[0];
    datob = datob[0];
    
    dato1 = datoa.split('-');
    dato2 = datob.split('-');
    
    reporte = $('#tiporeporte').val();
    
    if(datoini!=''&&datofin!=''){
	
	fecini = new Date(dato1[2],dato1[1],dato1[0]);
	fecfin = new Date(dato2[2],dato2[1],dato2[0]);
	
	timeini = fecini.getTime();
	timefin = fecfin.getTime();
	if(timeini<=timefin){
	    res=true;
	}
    }
    if(reporte=='')
	res = false;
    
	res = true; //omite la validacion
    if(res){
	$.ajax({
		   type: 'POST',
		   data: 'actual='+actual+
				 '&filas='+filas+
				 '&busqueda='+busqueda+
				 '&programa_id='+$('select[name=programa_id]').val()+
				 '&estado_id='+$('select[name=estado_id]').val()+
				 '&periodo_id='+$('select[name=periodo_id]').val()+				 
				 '&fecha_ini='+$('input:text[name=fecha_ini]').val()+
				 '&fecha_fin='+$('input:text[name=fecha_fin]').val()+
				 '&reporte='+$('#tiporeporte').val(),
		   url: '<?php echo base_url()?>index.php/reporte/busquedaReporte',
		   success: function(datos){
			   //$("#tablaResultados").append(datos);
			   $("#tablaResultados").html(datos);
		   }
	   });
    }else{
	alert('Verifique la fecha, Fecha inicial debe ser menor que Fecha final');	
    }	
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
     });  
});
</script>
<style>
	#minicartelera{
		padding-top: 30px;
		margin-top: 20px;
	}
</style>
<div id="minicartelera">
    <?php echo form_open('reporte/busquedaReporte'); ?>
	<input type="hidden" name="tiporeporte" id="tiporeporte" value="1">
	<h1><?php echo $titulo; ?></h1>
	<div id="filtros">
		<table class='formtable' cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
				<td colspan="2" align="center">
					<table class='formtable' style="margin-top: 10px;">
						<tr>
							<td colspan="6" align="center"><label style="font-size:14pt;font-weight:bold; margin-bottom: 10px; display: inline-block">Seleccione el tipo de reporte</label></td>
						</tr>
						<tr>				
							<td>
							<?php $js = ' onchange="elreporte(this.value)"'; ?>							
							<?php echo form_radio('reporte', '1', TRUE, $js) ?></td><td>Generar Reporte de Solicitudes</td>
							<td>							
							<?php echo form_radio('reporte', '2', FALSE, $js) ?></td><td>Generar Reporte de Solicitudes por Estado y Programa</td>
							<td>							
							<?php echo form_radio('reporte', '3', FALSE, $js) ?></td><td>Generar Reporte de Solicitudes por CRN</td>
							<td>							
							<?php echo form_radio('reporte', '4', FALSE, $js) ?></td><td>Generar Reporte Comentarios de Solicitudes</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>				
				<td><br><label>Programa</label></td>
				<td><?php echo form_dropdown('programa_id',$option_prog); ?></td>				
			</tr>			
			<tr>				
				<td><br><label>Estado</label></td>
				<td><?php echo form_dropdown('estado_id',$option_est); ?></td>				
			</tr>
			<tr>				
				<td><br><label>Período</label></td>
				<td><br>
				<?php echo form_dropdown('periodo_id',$option_perid); ?>
			</tr>
			<tr>				
				<td><br><label>Fecha inicial</label></td>
				<td><br>
				<?php echo form_input('fecha_ini','',' id="fecha_ini" placeholder="Fecha inicial" class="datetime" readonly="readonly"' ); ?>
			</tr>
			<tr>				
				<td><br><label>Fecha final</label></td>
				<td><br><?php echo form_input('fecha_fin','',' id="fecha_fin" placeholder="Fecha final" class="datetime" readonly="readonly"' ); ?></td>				
			</tr>			
			<tr><td colspan='2' align="center"><?php echo form_button('buscar3', $buscar,'onclick="buscar(0,'.PAGINAS.',\'buscar3\')"'); ?></td></tr>
		</table>
	</div>
    <div id="tablaResultados"></div>
    <?php echo form_close(); ?>
</div>
<?php
$this->load->view("footer");
?>