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
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui-1.7.2.custom.min.js"></script>
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

<!--<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-32994176-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>-->
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
