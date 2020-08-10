<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<style type="text/css">
*{
	font-family: Arial;
	font-size: 12px;
}
a{
	text-decoration: none; 
	Color: #1A406E;
	font-weight: bold;
}
.table thead th{
	background: #CCC;
	padding: 8px;
}
tr.row1{
	background: #E6E6E6;
}
</style>
<table class="table" width="100%">
	<thead>
		<tr>
			<th>CRN</th>
			<th>Código de Curso</th>
			<th>Nombre de Curso</th>
			<th>Tipo de Solicitud</th>
			<th>Estado de Solicitud</th>
			<th>Fecha de Solicitud</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$retiro = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAB+gAAAfoBF4pEbwAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAACaSURBVDiN3ZIxCsMwEARng2o3adK6yDP8kjTp/BC/JW/xI/KBNCnk3mwaBUSQQEZdDrbQsTtwd5JtaiXpBmD7UTXZLgoYgZg0Vn2VcABWwEkrEI4Aliz81dIEACZgLwB2YGoBDMAFmLPwnHrDrz8UlroBm6SYtaPtV+kIp+p5GusPAKp9ZUln4JqeT9vvQ4DW6h8BuPcCumb4ALLEwcdHlpDvAAAAAElFTkSuQmCC7c795e78ec7f6b52be3fab90dc1d597e"; 
		$inscripcion = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQBAMAAADt3eJSAAAAA3NCSVQICAjb4U/gAAAACXBIWXMAAAH6AAAB+gEXikRvAAAAGXRFWHRTb2Z0d2FyZQB3d3cuaW5rc2NhcGUub3Jnm+48GgAAACRQTFRF////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAxyY+ZQAAAAt0Uk5TAAccKC5PWJGT0O3fZtDAAAAAN0lEQVQIW2NgYGDI3sYAAaQw3Kq3p4AZWrt3LwIzWHfvDoDIde+AKpacCGUwGzBgBWlQwLAbCgCTbRfYmoPMpwAAAABJRU5ErkJggg8b6180e496ed4727db0f744efb1a374f"; 
		?>
		<?php foreach($items as $k=>$i){ 
		$crn = array(); $desc = array(); $mat = array();
		if(!empty($i->sol_ins_crn)){
			$crn[]  = "<span style='color: #04B431;' title='CRN Inscripción'><img src='".$inscripcion."' title='Inscripción' width='13' /> " .$i->sol_ins_crn."</span>";
			$desc[] = $i->sol_ins_des;
			$mat[] = $i->sol_ins_mat;
		}
		if(!empty($i->sol_ret_crn)){
			$crn[]  = "<span style='color: #FE2E2E;' title='CRN Retiro'>".$i->sol_ret_crn." <img src='".$retiro."' title='Retiro' width='13' /></span>";
			$desc[] = $i->sol_ret_des;
			$mat[] = $i->sol_ret_mat;
		}
		
		// echo "<pre>";
		// print_r($i);
		// echo "</pre>";
		?>
		<tr class="row<?php echo $k % 2; ?>">
			<td align="center">
				<?php
					$posicion = strpos($this->session->userdata('programas'), substr(implode(" - ", $mat),0,4));
					if ( $posicion !== false )
					:?>
						<a href="<?php echo base_url()."index.php/solicitud/ver/".$i->sol_id; ?>" target="_top">
							<?php echo implode(" - ", $crn); ?>
						</a>
			<?php   else:?>
						<?php echo implode(" - ", $crn); ?>
			<?php   endif ?>
			</td>
			<td align="center"><?php echo implode(" - ", $mat); ?></td>
			<td><?php echo implode("<br />", $desc); ?></td>
			<td><?php echo $i->tip_descripcion; ?></td>
			<td><?php echo $i->est_descripcion; ?></td>
			<td align="center"><?php echo $i->sol_fec_creacion; ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>