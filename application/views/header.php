<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $titulo;?></title>
<link href="<?php echo base_url();?>css/ci_functions.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
//<![CDATA[
base_url = '<?php echo base_url();?>index.php/';
//]]>
</script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/horario.css">
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/flexigrid.css">
<script type="text/javascript" src="<?php echo base_url();?>js/flexigrid.js"></script>
<!--Timepicker-->
<link type="text/css" href="<?php echo base_url();?>css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
<!--<link type="text/css" href="<?php echo base_url();?>css/smoothness/jquery-ui-1.9.0.custom.css" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url();?>css/smoothness/jquery-ui-1.9.0.custom.min.css" rel="stylesheet" />-->
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui-1.9.0.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui-1.9.0.custom.min.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui-1.7.2.custom.min.js"></script>-->
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.ui.autocomplete.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/timepicker.js"></script>
<!--Fancybox-->
<script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<?php
if (isset($extraHeadContent)) {
	echo $extraHeadContent;
}
?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-32994176-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-88625311-14"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-88625311-14');
</script>


<?php 
$controller = $this->router->fetch_class();
$task = $this->router->fetch_method();
?>
<script>
	function saveOrderColumns(){
		rol = '<?php echo $this->session->userdata('rol');?>';
		login = '<?php echo $this->session->userdata('login');?>';
		strJson = "";
		var colums = new Object(); // creamos un objeto
		
		jQuery(".hDivBox table thead th").each(function(){
			//alert(jQuery(this).attr("axis"));
			

			//colums['abbr']['axis'] = jQuery(this).attr("axis") ;

			

			
		})		
		//var otroArray = jQuery.makeArray(colums);
		//alert(JSON.stringify(otroArray));
		<?php if($controller == "coordinador" && $task == "index"): ?>
			
			$.ajax({
			  url: '<?php echo base_url()?>index.php/general/saveOrderColumns/',
			  data: 'login='+login,
			  type: "POST",
			  success: function(msg){		
				//alert(msg);	
			  }
			});
		<?php endif; ?>
	}
</script>

<script>
jQuery().ready(function(){
	jQuery(document).ajaxComplete(function(event, xhr, settings) {
		
			//alert('<?php echo base_url()."index.php/auth/index?e=1"?>');
			
			if(xhr.responseText == "expired"){
				window.location='<?php echo base_url()."index.php/auth/index?e=1"?>';
			}else{
				if (jQuery('#dgquery3').length && jQuery('#dgestados').html() == ""){
					jQuery('#dgquery3').hide();
					jQuery('#dgdeestados').append("<input type='text' name='dgquery31' placeholder='Seleccione estado' id='dgquery31'></input>");
					jQuery('.dgoptions').each(function(){
						//alert(jQuery(this).text());
						jQuery('#dgestados').append('<label class="dglabel"><input type="checkbox" class="dgcheck" value = "'+jQuery(this).val()+'"name="dgcheck[]"/><span class="dgspan">'+(jQuery(this).text()).replace(/^\s+/g,'').replace(/\s+$/g,'')+'</span></label>');
						
					});
					jQuery(".hole").append(jQuery("#dgestados"));
					
					jQuery(document).click(function(event){
						if(jQuery(event.target).attr("class")=="dgcheck"){
							elEstado = jQuery(event.target).val();
							estadoText = jQuery(event.target).parent().find(".dgspan").html();
							estadoText = estadoText.replace(/^\s+/g,'').replace(/\s+$/g,'')
							jQuery("#dgquery31").val("")
							if(jQuery(event.target).attr("checked")){
								jQuery("#dgquery3 option[value="+ elEstado +"]").attr("selected","selected");			
								
								jQuery(".dgcheck:checked").each(function(){
								  //cada elemento seleccionado
								  
								  actual = (jQuery("#dgquery31").val() !="" ) ? jQuery("#dgquery31").val() + ", " : '';
								  jQuery("#dgquery31").val(actual+(jQuery(this).parent().find(".dgspan").html()).replace(/^\s+/g,'').replace(/\s+$/g,'').replace('&nbsp;','').replace('&nbsp;','') );
								});
								
							}else{
							
								jQuery("#dgquery3 option[value="+ elEstado +"]").removeAttr("selected");
								jQuery(".dgcheck:checked").each(function(){
								  //cada elemento seleccionado
								  actual = (jQuery("#dgquery31").val() !="" ) ? jQuery("#dgquery31").val() + ", " : '';
								  jQuery("#dgquery31").val(actual+(jQuery(this).parent().find(".dgspan").html()).replace(/^\s+/g,'').replace(/\s+$/g,'').replace('&nbsp;','').replace('&nbsp;','') );
								});
							}
						}else if(jQuery(event.target).attr("id")=="dgquery31" 
								|| jQuery(event.target).attr("id")=="dgestados" 
								|| jQuery(event.target).attr("class")=="dgspan" 
								|| jQuery(event.target).attr("class")=="dglabel" 
								|| jQuery(event.target).attr("class")=="dgcheck" ){
								
							if(jQuery(event.target).attr("id")=="dgquery31" && jQuery('#dgestados').is(':visible')){
								jQuery("#dgestados").hide();
							}else{
								var posicion = jQuery('#dgdeestados').position(); 
								var posicion2 = jQuery('.sDiv').position(); 
								
								//alert	(parseInt(posicion.left))		
								jQuery("#dgestados").css({"display":"block","left":(parseInt(posicion.left)+5),"top":(parseInt(posicion2.top)-81)});;
						
							}
						}else{
							jQuery("#dgestados").hide();
						}
					})
				}
			}
		
	});
	/*jQuery("body").click(function(event){
		alert(jQuery(event.target).attr("class"))
		if(jQuery(event.target).hasClass("ui-datepicker-current")){
			jQuery(".ui-datepicker").hide();
			alert("fhdjfdhj")
		}
	});*/
	
});

</script>
</head>

<body>
<div class="hole">
<div class="wrapper-header">
		<!-- position: wrapper -->
		<div class="container">
			<div class="content-header">			
				<div class="top">				
				</div><!-- fin top -->
				<div class="header">
					<div class="lb"></div>
					<div class="contiene-elementos">
						<a class="logo-uniandes" title="" href="/"><!--span>Universidad de los Andes</span--></a>
						<h1>Conflicto horarios</h1>
					</div><!-- fin contiene-elementos -->
					<div class="rb"></div>
				</div><!-- fin header -->
				<?php echo @$menu;?>
				
			</div><!-- fin content-header -->
		</div><!-- fin container -->        
		</div>
