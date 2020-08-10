<?php
$this->load->view("header");
$mas ="iniciosolo";
?>
  <body>
      <script>mensaje = '<?php if(!empty($login_fail_msg))echo urldecode($login_fail_msg);else echo '';?>';
  if(mensaje!='')
    alert(mensaje);  

$(document).ready(function(){    
    //$('input[placeholder]').placeholder();
});
    </script>
    <?php if(count($noticias)>0){;?>
    <div class="inicio" style="float: left;">
    <?php
    echo form_fieldset('Noticias',array('class'=>'noticias_fieldset'));
    foreach ($noticias as $noticia) {
        echo "<div class='noticia'><a class ='noticias' href='http://".$noticia['link']."' target='_blank'><span class='not_titulo'>".$noticia['not_titulo']."</span><br>".$noticia['noticia']."</a>";
    }
    echo form_fieldset_close();
    ?>
    </div>
    <?php 
	$mas ='';
	}?>
    <div class="inicio <?php echo $mas; ?>">
      <?php echo form_fieldset('Login',array('class'=>'login_fieldset')); ?>
      <?php echo validation_errors('<p class="error">','</p>');?>
		<?php if(isset($msgExpired)):?>
			<span class="msgExpired" style="font-size: 12px; text-align: left !important;"><?php echo $msgExpired; ?> </span>
			<style>
				#loginform{
					padding-top: 0 !important;
				}
				.login_fieldset{
					text-align: left !important;
				}
			</style>
		<?php endif;?>
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
	  
	  <?php echo "<p align='center' style='font-size:12px'><a href='https://registro.uniandes.edu.co/images/stories/videos/conflicto_horario.mp4' target='_blank'>Manual de uso para estudiantes</a></p>"; ?>
      <?php echo form_close(); ?>
      <?php echo form_fieldset_close(); ?>
      </div>
 <?php
$this->load->view("footer");
?>
