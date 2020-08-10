<?php
$this->load->view("header");
?>
  <body>
      <script>mensaje = '<?php if(!empty($login_fail_msg))echo urldecode($login_fail_msg);else echo '';?>';
  if(mensaje!='')
    alert(mensaje);  

$(document).ready(function(){    
    //$('input[placeholder]').placeholder();
});
    </script>
      <?php echo form_fieldset('Login',array('class'=>'login_fieldset')); ?>
      <?php echo validation_errors('<p class="error">','</p>');?>

      <?php echo form_open('auth/login', array('id' => 'loginform')); ?>
      <?php      
	  //echo "<p align='justify' style='font-size:12px;text-decoration:none; text-align: center'>Atenci&oacute;n: Este sistema s&oacute;lo est&aacute; habilitado para conflictos con materias.</p>";
	  
      $table = array(array('', ''),
          array(form_label('Nombre de usuario', 'username'),
                form_input(array('name' => 'username', 'id' => 'username',
                     'class' => 'formfield',' placeholder'=>'Nombre de usuario')),form_label('@uniandes.edu.co', 'username')),
          array(form_label('Contrase&ntilde;a', 'password'),
                form_password(array('name' => 'password', 'id' => 'password',
                     'class' => 'formfield',' placeholder'=>'Contrase&ntilde;a'))));
          echo $this->table->generate($table);
      ?>

      <?php //echo form_label('Remember me', 'remember'); ?>
      <?php //echo form_checkbox(array('name' => 'remember', 'id' => 'remember','value' => 1,  'checked' => FALSE, 'disabled' => TRUE)); ?>
      <br />
      <?php echo form_submit('login', 'Ingreso'); ?>
	  
	  <?php echo "<p align='center' style='font-size:12px'><a href='http://manuales.uniandes.edu.co/conflictohorario' target='_blank'>Manual de uso para estudiantes</a></p>"; ?>
      <?php echo form_close(); ?>
      <?php echo form_fieldset_close(); ?>
<form id="form_consultas" action="<?php echo base_url()?>index.php/solicitud/page2/" method="post">
page<input id="page" name="page" value="1"><br>
rp<input id="rp" name="rp" value="20"><br>
sortname<input id="sortname" name="sortname" value="sol_id"><br>
sortorder<input id="sortorder" name="sortorder" value="asc"><br>
query<input id="query" name="query" value=""><br>
query2<input id="query2" name="query2" value=""><br>
qtype<input id="qtype" name="qtype" value="sol_descripcion"><br>
qtype2<input id="qtype2" name="qtype2" value="sol_descripcion"><br>
rol<input id="rol" name="rol" value="1"><br>
cantpag<input id="cantpag" name="cantpag" value="20"><br>
programas<input id="programas" name="programas" value="ADMI*ANTR*ECON*ISIS"><br>
niveles<input id="niveles" name="niveles" value="1*3"><br>
imprimir_consulta<input id="imprimir_consulta" name="imprimir_consulta" value="0"><br>
<input type="submit" value="consultas">
</form>
 <?php
$this->load->view("footer");
?>