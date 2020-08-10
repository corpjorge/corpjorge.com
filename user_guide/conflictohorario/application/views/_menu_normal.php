<!--Nombres, Apellidos, Código, Programa, login y rol-->
<div class="menu-principal" style="display:block">
        <!-- position: menu -->
        <span class="lb"></span>
            <ul class="menu">
                <li class="level2 item52" id="current"><a href="<?php echo base_url();?>index.php/solicitud"><span>Solicitudes</span></a></li>
                <?php if(@$rol!='3'){//if(@$codigo == ''){?>
                <li class="level2 item129"><a href="<?php echo base_url();?>index.php/reporte/"><span>Reportes</span></a></li>
                <?php }?>
                <li class="level2" id="current"><a href="<?php echo base_url();?>index.php/auth/logout"><span>Salir</span></a></li>                
            </ul>
        <span class="rb"></span>
</div>
<div class="clear"></div>
<div id="user" style="display:block">
<?php
@$datosusu = '';
@$datosusu .= (@$nombres!='' || @$apellidos!='' || @$usuario!='') ? @$nombres.' '.@$apellidos.'('.''.@$usuario.')<br>' : '';
@$datosusu .= @$programa!='' ? @$programa.'<br>' : '';
@$datosusu .= @$niveles!='' ? @$niveles.'<br>' : '';
@$datosusu .= @$rol_name!='' ? @$rol_name.'<br>' : '';
echo @$datosusu;
//echo @$nombres.' '.@$apellidos.'('.''.@$usuario.')<br>'.@$programa.'<br>'.@$niveles.'<br>'.@$rol_name;
?>
</div>