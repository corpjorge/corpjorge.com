<?php
$this->load->view("header");
?>
<script type="text/javascript">
mensaje = '<?php if(!empty($mensaje))echo urldecode($mensaje);else echo '';?>';
  if(mensaje!='')
    alert(mensaje);
	
$(document).ready(function() {

$("#various2").fancybox({
	'titlePosition'		: 'inside',
	'transitionIn'		: 'none',
	'transitionOut'		: 'none'
});
});
</script>
<a class="volver" href="<?php echo base_url()?>index.php/solicitud/">Volver</a><br>
<?php if(validation_errors('<p class="error">','</p>')!=''){
echo form_open();
echo str_replace('&lt;', '<', str_replace('&gt;', '>', htmlentities(validation_errors('<p class="error">','</p>'), ENT_NOQUOTES)));
echo form_close();
} ?>
<?php echo form_open('solicitud/crear/'.@$sol_id); ?>

<?php
$id=' id="sol_login"';
echo form_hidden('sol_login', set_value('sol_login', @$sol_login), $id);
$id=' id="sol_email"';
echo form_hidden('sol_email', set_value('sol_email', @$sol_email), $id);
$id=' id="sol_nombre"';
echo form_hidden('sol_nombre', set_value('sol_nombre', @$sol_nombre), $id);
$id=' id="sol_apellido"';
echo form_hidden('sol_apellido', set_value('sol_apellido', @$sol_apellido), $id);
$id=' id="sol_uidnumber"';
echo form_hidden('sol_uidnumber', set_value('sol_uidnumber', @$sol_uidnumber), $id);
?>
				
	<h1>Crear solicitud</h1>
	<table class='formtable' width="100%">
			
		<tr>				
			<td class="tdlabel" width="50%">Tipo de Solicitud: </td>
			<td><?php
			  $js = ' id="tip_id"';
			  echo form_dropdown('tip_id',$options_tipo,@$tip_id,$js);		  
			?>
			</td>
		</tr>
			<tr>
			<td class="tdlabel">Motivo: </td>
			<td><?php echo form_dropdown('mov_id',$options_motivo,@$mov_id); ?></td>
		</tr>
			<td colspan="2">
				<table class='formtable' width="100%">
					<tr>
						<td class="tdlabel">&nbsp;</td>
						<td class="tdlabel">Programa</td>
						<td class="tdlabel">CRN</td>
					</tr>
					<tr>
						<td class="tdlabel" width="50%">Curso de Inscripci&oacute;n: </td>
						<td>
<SELECT id="sol_disp_crn_ins_des" name="sol_disp_crn_ins_des">
<OPTION  value="" selected>Seleccione</OPTION>
<OPTION  value="ADMI" <?php if(@$sol_disp_crn_ins_des=='ADMI') echo 'selected'; ?>>ADMINISTRACION</OPTION>
<OPTION  value="ANTR" <?php if(@$sol_disp_crn_ins_des=='ANTR') echo 'selected'; ?>>ANTROPOLOGIA</OPTION>
<OPTION  value="ARQU" <?php if(@$sol_disp_crn_ins_des=='ARQU') echo 'selected'; ?>>ARQUITECTURA</OPTION>
<OPTION  value="ARTE" <?php if(@$sol_disp_crn_ins_des=='ARTE') echo 'selected'; ?>>ARTE</OPTION>
<OPTION  value="ARTI" <?php if(@$sol_disp_crn_ins_des=='ARTI') echo 'selected'; ?>>MAEST.EN ARQUITECTURAS DE TI</OPTION>
<OPTION  value="AUTO" <?php if(@$sol_disp_crn_ins_des=='AUTO') echo 'selected'; ?>>AUTOMATIZACION DE PROC. INDUST</OPTION>
<OPTION  value="BIOL" <?php if(@$sol_disp_crn_ins_des=='BIOL') echo 'selected'; ?>>BIOLOGIA</OPTION>
<OPTION  value="BIOM" <?php if(@$sol_disp_crn_ins_des=='BIOM') echo 'selected'; ?>>CIENCIAS BIOMEDICAS</OPTION>
<OPTION  value="CBIO" <?php if(@$sol_disp_crn_ins_des=='CBIO') echo 'selected'; ?>>POSTGRADO CIENCIAS BIOLOGICAS</OPTION>
<OPTION  value="CELE" <?php if(@$sol_disp_crn_ins_des=='CELE') echo 'selected'; ?>>COMERCIO ELECTRONICO</OPTION>
<OPTION  value="CIDE" <?php if(@$sol_disp_crn_ins_des=='CIDE') echo 'selected'; ?>>CIDER</OPTION>
<OPTION  value="CISO" <?php if(@$sol_disp_crn_ins_des=='CISO') echo 'selected'; ?>>CIENCIAS SOCIALES</OPTION>
<OPTION  value="CPOL" <?php if(@$sol_disp_crn_ins_des=='CPOL') echo 'selected'; ?>>CIENCIA POLITICA</OPTION>
<OPTION  value="CSOF" <?php if(@$sol_disp_crn_ins_des=='CSOF') echo 'selected'; ?>>CONSTRUCCION DE SOFTWARE</OPTION>
<OPTION  value="DADM" <?php if(@$sol_disp_crn_ins_des=='DADM') echo 'selected'; ?>>DOCTORADO EN ADMINISTRACION</OPTION>
<OPTION  value="DCOM" <?php if(@$sol_disp_crn_ins_des=='DCOM') echo 'selected'; ?>>DERECHO COMERCIAL</OPTION>
<OPTION  value="DDER" <?php if(@$sol_disp_crn_ins_des=='DDER') echo 'selected'; ?>>DOCTORADO EN DERECHO</OPTION>
<OPTION  value="DECA" <?php if(@$sol_disp_crn_ins_des=='DECA') echo 'selected'; ?>>DECANATURA ESTUDIANTES</OPTION>
<OPTION  value="DEIN" <?php if(@$sol_disp_crn_ins_des=='DEIN') echo 'selected'; ?>>MAESTRIA EN DERECHO INTERNAL</OPTION>
<OPTION  value="DENI" <?php if(@$sol_disp_crn_ins_des=='DENI') echo 'selected'; ?>>ESPECIAL.DEREC.NEGOC.INTERNALE</OPTION>
<OPTION  value="DEPO" <?php if(@$sol_disp_crn_ins_des=='DEPO') echo 'selected'; ?>>DEPORTES</OPTION>
<OPTION  value="DEPR" <?php if(@$sol_disp_crn_ins_des=='DEPR') echo 'selected'; ?>>MAESTRIA EN DERECHO PRIVADO</OPTION>
<OPTION  value="DERE" <?php if(@$sol_disp_crn_ins_des=='DERE') echo 'selected'; ?>>DERECHO</OPTION>
<OPTION  value="DISE" <?php if(@$sol_disp_crn_ins_des=='DISE') echo 'selected'; ?>>DISEÑO INDUSTRIAL</OPTION>
<OPTION  value="DPUB" <?php if(@$sol_disp_crn_ins_des=='DPUB') echo 'selected'; ?>>MAES.EN DER.PUBLICO GEST.ADMIN</OPTION>
<OPTION  value="DUPS" <?php if(@$sol_disp_crn_ins_des=='DUPS') echo 'selected'; ?>>ESP. DERECHO URBANO POLIT PROP</OPTION>
<OPTION  value="ECON" <?php if(@$sol_disp_crn_ins_des=='ECON') echo 'selected'; ?>>ECONOMIA</OPTION>
<OPTION  value="EDUC" <?php if(@$sol_disp_crn_ins_des=='EDUC') echo 'selected'; ?>>EDUCACION</OPTION>
<OPTION  value="EECO" <?php if(@$sol_disp_crn_ins_des=='EECO') echo 'selected'; ?>>ESPECIALIZACION EN ECONOMIA</OPTION>
<OPTION  value="EGOB" <?php if(@$sol_disp_crn_ins_des=='EGOB') echo 'selected'; ?>>ESCUELA DE GOBIERNO</OPTION>
<OPTION  value="ESIO" <?php if(@$sol_disp_crn_ins_des=='ESIO') echo 'selected'; ?>>SISTEMAS DE INFORMACION - ESIO</OPTION>
<OPTION  value="FILO" <?php if(@$sol_disp_crn_ins_des=='FILO') echo 'selected'; ?>>FILOSOFIA</OPTION>
<OPTION  value="FISI" <?php if(@$sol_disp_crn_ins_des=='FISI') echo 'selected'; ?>>FISICA</OPTION>
<OPTION  value="GEOC" <?php if(@$sol_disp_crn_ins_des=='GEOC') echo 'selected'; ?>>GEOCIENCIAS</OPTION>
<OPTION  value="GPUB" <?php if(@$sol_disp_crn_ins_des=='GPUB') echo 'selected'; ?>>GESTION PUBLICA</OPTION>
<OPTION  value="GTEL" <?php if(@$sol_disp_crn_ins_des=='GTEL') echo 'selected'; ?>>GERENCIA EMPRESAS DE TELECOMUN</OPTION>
<OPTION  value="HART" <?php if(@$sol_disp_crn_ins_des=='HART') echo 'selected'; ?>>HISTORIA DEL ARTE</OPTION>
<OPTION  value="HIST" <?php if(@$sol_disp_crn_ins_des=='HIST') echo 'selected'; ?>>HISTORIA</OPTION>
<OPTION  value="IBIO" <?php if(@$sol_disp_crn_ins_des=='IBIO') echo 'selected'; ?>>INGENIERIA BIOMEDICA</OPTION>
<OPTION  value="ICYA" <?php if(@$sol_disp_crn_ins_des=='ICYA') echo 'selected'; ?>>INGENIERIA CIVIL Y AMBIENTAL</OPTION>
<OPTION  value="IDOC" <?php if(@$sol_disp_crn_ins_des=='IDOC') echo 'selected'; ?>>DOCTORADO EN INGENIERIA</OPTION>
<OPTION  value="IELE" <?php if(@$sol_disp_crn_ins_des=='IELE') echo 'selected'; ?>>ING.  ELECTRICA Y ELECTRONICA</OPTION>
<OPTION  value="IGEN" <?php if(@$sol_disp_crn_ins_des=='IGEN') echo 'selected'; ?>>INGENIERIA GENERAL</OPTION>
<OPTION  value="IIND" <?php if(@$sol_disp_crn_ins_des=='IIND') echo 'selected'; ?>>INGENIERIA INDUSTRIAL</OPTION>
<OPTION  value="IMEC" <?php if(@$sol_disp_crn_ins_des=='IMEC') echo 'selected'; ?>>INGENIERIA MECANICA</OPTION>
<OPTION  value="IQUI" <?php if(@$sol_disp_crn_ins_des=='IQUI') echo 'selected'; ?>>INGENIERIA QUIMICA</OPTION>
<OPTION  value="ISIS" <?php if(@$sol_disp_crn_ins_des=='ISIS') echo 'selected'; ?>>INGENIERIA DE SISTEMAS</OPTION>
<OPTION  value="LEGI" <?php if(@$sol_disp_crn_ins_des=='LEGI') echo 'selected'; ?>>LEGISLACION FINANCIERA</OPTION>
<OPTION  value="LENG" <?php if(@$sol_disp_crn_ins_des=='LENG') echo 'selected'; ?>>LENGUAJES Y ESTUDIOS SOCIOCULT</OPTION>
<OPTION  value="LITE" <?php if(@$sol_disp_crn_ins_des=='LITE') echo 'selected'; ?>>LITERATURA</OPTION>
<OPTION  value="MADM" <?php if(@$sol_disp_crn_ins_des=='MADM') echo 'selected'; ?>>MAESTRIA EN ADMINISTRACION</OPTION>
<OPTION  value="MAMB" <?php if(@$sol_disp_crn_ins_des=='MAMB') echo 'selected'; ?>>MANEJO INTEGRADO DEL MEDIO AMB</OPTION>
<OPTION  value="MATE" <?php if(@$sol_disp_crn_ins_des=='MATE') echo 'selected'; ?>>MATEMATICAS</OPTION>
<OPTION  value="MBAE" <?php if(@$sol_disp_crn_ins_des=='MBAE') echo 'selected'; ?>>MBA EJECUTIVO</OPTION>
<OPTION  value="MBIO" <?php if(@$sol_disp_crn_ins_des=='MBIO') echo 'selected'; ?>>MICROBIOLOGIA</OPTION>
<OPTION  value="MDER" <?php if(@$sol_disp_crn_ins_des=='MDER') echo 'selected'; ?>>MAESTRIA EN DERECHO</OPTION>
<OPTION  value="MECU" <?php if(@$sol_disp_crn_ins_des=='MECU') echo 'selected'; ?>>MAESTRIA EN ESTUD.CULTURALES</OPTION>
<OPTION  value="MEDI" <?php if(@$sol_disp_crn_ins_des=='MEDI') echo 'selected'; ?>>MEDICINA</OPTION>
<OPTION  value="MESO" <?php if(@$sol_disp_crn_ins_des=='MESO') echo 'selected'; ?>>MAEST.EN ESTUDIOS ORGANIZAC</OPTION>
<OPTION  value="MFIN" <?php if(@$sol_disp_crn_ins_des=='MFIN') echo 'selected'; ?>>MAESTRIA EN FINANZAS</OPTION>
<OPTION  value="MGAP" <?php if(@$sol_disp_crn_ins_des=='MGAP') echo 'selected'; ?>>MAEST EN GERENCIA AMBIENTAL TP</OPTION>
<OPTION  value="MGEO" <?php if(@$sol_disp_crn_ins_des=='MGEO') echo 'selected'; ?>>MAESTRIA EN GEOGRAFIA</OPTION>
<OPTION  value="MGPD" <?php if(@$sol_disp_crn_ins_des=='MGPD') echo 'selected'; ?>>MAEST.GERENC Y PRACT.DESARROLL</OPTION>
<OPTION  value="MLIT" <?php if(@$sol_disp_crn_ins_des=='MLIT') echo 'selected'; ?>>MAESTRIA EN LITERATURA</OPTION>
<OPTION  value="MMER" <?php if(@$sol_disp_crn_ins_des=='MMER') echo 'selected'; ?>>MAESTRIA EN MERCADEO</OPTION>
<OPTION  value="MPER" <?php if(@$sol_disp_crn_ins_des=='MPER') echo 'selected'; ?>>MAESTRIA EN PERIODISMO</OPTION>
<OPTION  value="MUSI" <?php if(@$sol_disp_crn_ins_des=='MUSI') echo 'selected'; ?>>MUSICA</OPTION>
<OPTION  value="PERI" <?php if(@$sol_disp_crn_ins_des=='PERI') echo 'selected'; ?>>PERIODISMO</OPTION>
<OPTION  value="PLEN" <?php if(@$sol_disp_crn_ins_des=='PLEN') echo 'selected'; ?>>MAEST.PEDAGOG.LENGUAS EXTRANJ.</OPTION>
<OPTION  value="PSCL" <?php if(@$sol_disp_crn_ins_des=='PSCL') echo 'selected'; ?>>MAEST.PSICOLOG.CLINICA Y SALUD</OPTION>
<OPTION  value="PSIC" <?php if(@$sol_disp_crn_ins_des=='PSIC') echo 'selected'; ?>>PSICOLOGIA</OPTION>
<OPTION  value="QUIM" <?php if(@$sol_disp_crn_ins_des=='QUIM') echo 'selected'; ?>>QUIMICA</OPTION>
<OPTION  value="RHID" <?php if(@$sol_disp_crn_ins_des=='RHID') echo 'selected'; ?>>INGENIER.SISTEMAS HIDRICOS URB</OPTION>
<OPTION  value="RJUR" <?php if(@$sol_disp_crn_ins_des=='RJUR') echo 'selected'; ?>>REGIMEN JURID.FINAN.CONT.IMP.</OPTION>
<OPTION  value="SAFE" <?php if(@$sol_disp_crn_ins_des=='SAFE') echo 'selected'; ?>>ESPEC.SEGURIDAD DE LA INFORMAC</OPTION>
<OPTION  value="SICO" <?php if(@$sol_disp_crn_ins_des=='SICO') echo 'selected'; ?>>SIST.DE CONTROL ORGANIZ.Y GEST</OPTION>
<OPTION  value="STRA" <?php if(@$sol_disp_crn_ins_des=='STRA') echo 'selected'; ?>>SISTEMAS DE TRANSMISION</OPTION>
</SELECT>							
						</td>		
						<td>
							<?php
							$id=' id="sol_disp_crn_ins" size="7"';
							echo form_input('sol_disp_crn_ins', set_value('sol_disp_crn_ins', @$sol_disp_crn_ins), $id);		 
							?>
						</td>
					</tr>
					<tr>
						<td class="tdlabel" width="50%">Curso de Retiro: </td>
						<td>
						<SELECT id="sol_disp_crn_ret_des" name="sol_disp_crn_ret_des">
<OPTION  value="" selected>Seleccione</OPTION>
<OPTION  value="ADMI" <?php if(@$sol_disp_crn_ret_des=='ADMI') echo 'selected'; ?>>ADMINISTRACION</OPTION>
<OPTION  value="ANTR" <?php if(@$sol_disp_crn_ret_des=='ANTR') echo 'selected'; ?>>ANTROPOLOGIA</OPTION>
<OPTION  value="ARQU" <?php if(@$sol_disp_crn_ret_des=='ARQU') echo 'selected'; ?>>ARQUITECTURA</OPTION>
<OPTION  value="ARTE" <?php if(@$sol_disp_crn_ret_des=='ARTE') echo 'selected'; ?>>ARTE</OPTION>
<OPTION  value="ARTI" <?php if(@$sol_disp_crn_ret_des=='ARTI') echo 'selected'; ?>>MAEST.EN ARQUITECTURAS DE TI</OPTION>
<OPTION  value="AUTO" <?php if(@$sol_disp_crn_ret_des=='AUTO') echo 'selected'; ?>>AUTOMATIZACION DE PROC. INDUST</OPTION>
<OPTION  value="BIOL" <?php if(@$sol_disp_crn_ret_des=='BIOL') echo 'selected'; ?>>BIOLOGIA</OPTION>
<OPTION  value="BIOM" <?php if(@$sol_disp_crn_ret_des=='BIOM') echo 'selected'; ?>>CIENCIAS BIOMEDICAS</OPTION>
<OPTION  value="CBIO" <?php if(@$sol_disp_crn_ret_des=='CBIO') echo 'selected'; ?>>POSTGRADO CIENCIAS BIOLOGICAS</OPTION>
<OPTION  value="CELE" <?php if(@$sol_disp_crn_ret_des=='CELE') echo 'selected'; ?>>COMERCIO ELECTRONICO</OPTION>
<OPTION  value="CIDE" <?php if(@$sol_disp_crn_ret_des=='CIDE') echo 'selected'; ?>>CIDER</OPTION>
<OPTION  value="CISO" <?php if(@$sol_disp_crn_ret_des=='CISO') echo 'selected'; ?>>CIENCIAS SOCIALES</OPTION>
<OPTION  value="CPOL" <?php if(@$sol_disp_crn_ret_des=='CPOL') echo 'selected'; ?>>CIENCIA POLITICA</OPTION>
<OPTION  value="CSOF" <?php if(@$sol_disp_crn_ret_des=='CSOF') echo 'selected'; ?>>CONSTRUCCION DE SOFTWARE</OPTION>
<OPTION  value="DADM" <?php if(@$sol_disp_crn_ret_des=='DADM') echo 'selected'; ?>>DOCTORADO EN ADMINISTRACION</OPTION>
<OPTION  value="DCOM" <?php if(@$sol_disp_crn_ret_des=='DCOM') echo 'selected'; ?>>DERECHO COMERCIAL</OPTION>
<OPTION  value="DDER" <?php if(@$sol_disp_crn_ret_des=='DDER') echo 'selected'; ?>>DOCTORADO EN DERECHO</OPTION>
<OPTION  value="DECA" <?php if(@$sol_disp_crn_ret_des=='DECA') echo 'selected'; ?>>DECANATURA ESTUDIANTES</OPTION>
<OPTION  value="DEIN" <?php if(@$sol_disp_crn_ret_des=='DEIN') echo 'selected'; ?>>MAESTRIA EN DERECHO INTERNAL</OPTION>
<OPTION  value="DENI" <?php if(@$sol_disp_crn_ret_des=='DENI') echo 'selected'; ?>>ESPECIAL.DEREC.NEGOC.INTERNALE</OPTION>
<OPTION  value="DEPO" <?php if(@$sol_disp_crn_ret_des=='DEPO') echo 'selected'; ?>>DEPORTES</OPTION>
<OPTION  value="DEPR" <?php if(@$sol_disp_crn_ret_des=='DEPR') echo 'selected'; ?>>MAESTRIA EN DERECHO PRIVADO</OPTION>
<OPTION  value="DERE" <?php if(@$sol_disp_crn_ret_des=='DERE') echo 'selected'; ?>>DERECHO</OPTION>
<OPTION  value="DISE" <?php if(@$sol_disp_crn_ret_des=='DISE') echo 'selected'; ?>>DISEÑO INDUSTRIAL</OPTION>
<OPTION  value="DPUB" <?php if(@$sol_disp_crn_ret_des=='DPUB') echo 'selected'; ?>>MAES.EN DER.PUBLICO GEST.ADMIN</OPTION>
<OPTION  value="DUPS" <?php if(@$sol_disp_crn_ret_des=='DUPS') echo 'selected'; ?>>ESP. DERECHO URBANO POLIT PROP</OPTION>
<OPTION  value="ECON" <?php if(@$sol_disp_crn_ret_des=='ECON') echo 'selected'; ?>>ECONOMIA</OPTION>
<OPTION  value="EDUC" <?php if(@$sol_disp_crn_ret_des=='EDUC') echo 'selected'; ?>>EDUCACION</OPTION>
<OPTION  value="EECO" <?php if(@$sol_disp_crn_ret_des=='EECO') echo 'selected'; ?>>ESPECIALIZACION EN ECONOMIA</OPTION>
<OPTION  value="EGOB" <?php if(@$sol_disp_crn_ret_des=='EGOB') echo 'selected'; ?>>ESCUELA DE GOBIERNO</OPTION>
<OPTION  value="ESIO" <?php if(@$sol_disp_crn_ret_des=='ESIO') echo 'selected'; ?>>SISTEMAS DE INFORMACION - ESIO</OPTION>
<OPTION  value="FILO" <?php if(@$sol_disp_crn_ret_des=='FILO') echo 'selected'; ?>>FILOSOFIA</OPTION>
<OPTION  value="FISI" <?php if(@$sol_disp_crn_ret_des=='FISI') echo 'selected'; ?>>FISICA</OPTION>
<OPTION  value="GEOC" <?php if(@$sol_disp_crn_ret_des=='GEOC') echo 'selected'; ?>>GEOCIENCIAS</OPTION>
<OPTION  value="GPUB" <?php if(@$sol_disp_crn_ret_des=='GPUB') echo 'selected'; ?>>GESTION PUBLICA</OPTION>
<OPTION  value="GTEL" <?php if(@$sol_disp_crn_ret_des=='GTEL') echo 'selected'; ?>>GERENCIA EMPRESAS DE TELECOMUN</OPTION>
<OPTION  value="HART" <?php if(@$sol_disp_crn_ret_des=='HART') echo 'selected'; ?>>HISTORIA DEL ARTE</OPTION>
<OPTION  value="HIST" <?php if(@$sol_disp_crn_ret_des=='HIST') echo 'selected'; ?>>HISTORIA</OPTION>
<OPTION  value="IBIO" <?php if(@$sol_disp_crn_ret_des=='IBIO') echo 'selected'; ?>>INGENIERIA BIOMEDICA</OPTION>
<OPTION  value="ICYA" <?php if(@$sol_disp_crn_ret_des=='ICYA') echo 'selected'; ?>>INGENIERIA CIVIL Y AMBIENTAL</OPTION>
<OPTION  value="IDOC" <?php if(@$sol_disp_crn_ret_des=='IDOC') echo 'selected'; ?>>DOCTORADO EN INGENIERIA</OPTION>
<OPTION  value="IELE" <?php if(@$sol_disp_crn_ret_des=='IELE') echo 'selected'; ?>>ING.  ELECTRICA Y ELECTRONICA</OPTION>
<OPTION  value="IGEN" <?php if(@$sol_disp_crn_ret_des=='IGEN') echo 'selected'; ?>>INGENIERIA GENERAL</OPTION>
<OPTION  value="IIND" <?php if(@$sol_disp_crn_ret_des=='IIND') echo 'selected'; ?>>INGENIERIA INDUSTRIAL</OPTION>
<OPTION  value="IMEC" <?php if(@$sol_disp_crn_ret_des=='IMEC') echo 'selected'; ?>>INGENIERIA MECANICA</OPTION>
<OPTION  value="IQUI" <?php if(@$sol_disp_crn_ret_des=='IQUI') echo 'selected'; ?>>INGENIERIA QUIMICA</OPTION>
<OPTION  value="ISIS" <?php if(@$sol_disp_crn_ret_des=='ISIS') echo 'selected'; ?>>INGENIERIA DE SISTEMAS</OPTION>
<OPTION  value="LEGI" <?php if(@$sol_disp_crn_ret_des=='LEGI') echo 'selected'; ?>>LEGISLACION FINANCIERA</OPTION>
<OPTION  value="LENG" <?php if(@$sol_disp_crn_ret_des=='LENG') echo 'selected'; ?>>LENGUAJES Y ESTUDIOS SOCIOCULT</OPTION>
<OPTION  value="LITE" <?php if(@$sol_disp_crn_ret_des=='LITE') echo 'selected'; ?>>LITERATURA</OPTION>
<OPTION  value="MADM" <?php if(@$sol_disp_crn_ret_des=='MADM') echo 'selected'; ?>>MAESTRIA EN ADMINISTRACION</OPTION>
<OPTION  value="MAMB" <?php if(@$sol_disp_crn_ret_des=='MAMB') echo 'selected'; ?>>MANEJO INTEGRADO DEL MEDIO AMB</OPTION>
<OPTION  value="MATE" <?php if(@$sol_disp_crn_ret_des=='MATE') echo 'selected'; ?>>MATEMATICAS</OPTION>
<OPTION  value="MBAE" <?php if(@$sol_disp_crn_ret_des=='MBAE') echo 'selected'; ?>>MBA EJECUTIVO</OPTION>
<OPTION  value="MBIO" <?php if(@$sol_disp_crn_ret_des=='MBIO') echo 'selected'; ?>>MICROBIOLOGIA</OPTION>
<OPTION  value="MDER" <?php if(@$sol_disp_crn_ret_des=='MDER') echo 'selected'; ?>>MAESTRIA EN DERECHO</OPTION>
<OPTION  value="MECU" <?php if(@$sol_disp_crn_ret_des=='MECU') echo 'selected'; ?>>MAESTRIA EN ESTUD.CULTURALES</OPTION>
<OPTION  value="MEDI" <?php if(@$sol_disp_crn_ret_des=='MEDI') echo 'selected'; ?>>MEDICINA</OPTION>
<OPTION  value="MESO" <?php if(@$sol_disp_crn_ret_des=='MESO') echo 'selected'; ?>>MAEST.EN ESTUDIOS ORGANIZAC</OPTION>
<OPTION  value="MFIN" <?php if(@$sol_disp_crn_ret_des=='MFIN') echo 'selected'; ?>>MAESTRIA EN FINANZAS</OPTION>
<OPTION  value="MGAP" <?php if(@$sol_disp_crn_ret_des=='MGAP') echo 'selected'; ?>>MAEST EN GERENCIA AMBIENTAL TP</OPTION>
<OPTION  value="MGEO" <?php if(@$sol_disp_crn_ret_des=='MGEO') echo 'selected'; ?>>MAESTRIA EN GEOGRAFIA</OPTION>
<OPTION  value="MGPD" <?php if(@$sol_disp_crn_ret_des=='MGPD') echo 'selected'; ?>>MAEST.GERENC Y PRACT.DESARROLL</OPTION>
<OPTION  value="MLIT" <?php if(@$sol_disp_crn_ret_des=='MLIT') echo 'selected'; ?>>MAESTRIA EN LITERATURA</OPTION>
<OPTION  value="MMER" <?php if(@$sol_disp_crn_ret_des=='MMER') echo 'selected'; ?>>MAESTRIA EN MERCADEO</OPTION>
<OPTION  value="MPER" <?php if(@$sol_disp_crn_ret_des=='MPER') echo 'selected'; ?>>MAESTRIA EN PERIODISMO</OPTION>
<OPTION  value="MUSI" <?php if(@$sol_disp_crn_ret_des=='MUSI') echo 'selected'; ?>>MUSICA</OPTION>
<OPTION  value="PERI" <?php if(@$sol_disp_crn_ret_des=='PERI') echo 'selected'; ?>>PERIODISMO</OPTION>
<OPTION  value="PLEN" <?php if(@$sol_disp_crn_ret_des=='PLEN') echo 'selected'; ?>>MAEST.PEDAGOG.LENGUAS EXTRANJ.</OPTION>
<OPTION  value="PSCL" <?php if(@$sol_disp_crn_ret_des=='PSCL') echo 'selected'; ?>>MAEST.PSICOLOG.CLINICA Y SALUD</OPTION>
<OPTION  value="PSIC" <?php if(@$sol_disp_crn_ret_des=='PSIC') echo 'selected'; ?>>PSICOLOGIA</OPTION>
<OPTION  value="QUIM" <?php if(@$sol_disp_crn_ret_des=='QUIM') echo 'selected'; ?>>QUIMICA</OPTION>
<OPTION  value="RHID" <?php if(@$sol_disp_crn_ret_des=='RHID') echo 'selected'; ?>>INGENIER.SISTEMAS HIDRICOS URB</OPTION>
<OPTION  value="RJUR" <?php if(@$sol_disp_crn_ret_des=='RJUR') echo 'selected'; ?>>REGIMEN JURID.FINAN.CONT.IMP.</OPTION>
<OPTION  value="SAFE" <?php if(@$sol_disp_crn_ret_des=='SAFE') echo 'selected'; ?>>ESPEC.SEGURIDAD DE LA INFORMAC</OPTION>
<OPTION  value="SICO" <?php if(@$sol_disp_crn_ret_des=='SICO') echo 'selected'; ?>>SIST.DE CONTROL ORGANIZ.Y GEST</OPTION>
<OPTION  value="STRA" <?php if(@$sol_disp_crn_ret_des=='STRA') echo 'selected'; ?>>SISTEMAS DE TRANSMISION</OPTION>
</SELECT>							
						</td>		
						<td>
							<?php
							$id=' id="sol_disp_crn_ret" size="7"';
							echo form_input('sol_disp_crn_ret', set_value('sol_disp_crn_ret', @$sol_disp_crn_ret), $id);		 
							?>
						</td>
					</tr>
					<tr>
						<td class="tdlabel" width="50%">Descripci&oacute;n: </td>
						<td><textarea id="sol_descripcion" name="sol_descripcion" rows="4" cols="20" style="width: 253px; height: 90px;"><?php echo @$sol_descripcion?></textarea></td>		
					</tr>
					<tr>
							<td colspan="2"><a id="various2" href="<?php echo base_url();?>/index.php/solicitud/condiciones" target="_blank">Acepta t&eacute;rminos y condiciones&nbsp;&nbsp;</a><?php 
								$_POST['sol_tyc'] = isset($_POST['sol_tyc']) ? $_POST['sol_tyc'] : '0';
								$checked = ($_POST['sol_tyc']==='0')?FALSE:TRUE;
								echo form_checkbox('sol_tyc', '1', $checked );?></td>			
							<td>&nbsp;</td>
					</tr>
				</table>
			</td>
		<tr>
		<tr>
		<td colspan="2"><?php echo form_submit('submit', 'Enviar');?></td>
		</tr>
	</table>

<?php echo form_close(); ?>
<?php
	$this->load->view("footer");
?>