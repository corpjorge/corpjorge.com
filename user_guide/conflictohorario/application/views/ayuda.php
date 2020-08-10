<script>
 function enviar(id, seccion){      
    window.opener.put_crn(id,seccion,'<?php echo $id_input?>');
    window.close();
 }
</script>
<table>
<?php foreach($secciones as $key=>$seccion){ ?>
<tr><td><input type="radio" name="sec" onchange="enviar(<?php echo $key ?>,'<?php echo $seccion ?>')" value='<?php echo $key?>'></td><td id="secnom_<?php echo $key ?>"><?php echo $seccion ?></td></tr>
<?php }?>
</table>