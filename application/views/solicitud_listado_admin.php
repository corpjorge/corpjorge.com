<?php
$this->load->view("header");
?>
<style type="text/css">
    .selTodo{
        padding: 0px !important;
    }
    .ui-autocomplete.ui-menu.ui-widget.ui-widget-content.ui-corner-all{
        width: 250px!important;
        font-size: 13px;
    }
</style>
<script>
    function selall(id)
    {
        var nombre = $(".selectall").html();     
        if (nombre == 'Seleccionar todos') {
           $('#'+id+' >tbody >tr').each(
               function (){	    
                       $(this).attr('class','trSelected');		    		
               }
           );
           $(".selectall").html('Quitar selecci&oacute;n');
        } else {
           $('#'+id+' >tbody >tr').each(
               function (){	    
                       $(this).attr('class','');		    		
               }
           );
           $(".selectall").html('Seleccionar todos');
        }
    }
    function verHorario()
    {
        if ($('#flex1 tr.trSelected').length>1) {
            alert("Debe seleccionar solo un registro para consultar el horario.");
        }else if($('#flex1 tr.trSelected').length===1) {
            var id = $('#flex1 tr.trSelected').attr('id');
            id = id.substring(id.lastIndexOf('row')+3);
            window.open("<?php echo base_url()?>index.php/solicitud/horario/"+id,"horario","width=1024,height=650,scrollbars=yes,channelmode=yes");
        }
    }
    function recargar()
    {
        window.location.reload();
    }
    $(document).ready(function() {    
        $(function() {
            $("#flex1").flexigrid({
                url: '<?php echo base_url()?>index.php/solicitud/page/',
                dataType: 'json',
                    // onSuccess: recargar,
                colModel : [	
                    <?php //if(!in_array('sol_id',$ocultas)){?>
                    {display: 'Seg.', name : 'sol_marca', width : /*40*/30, sortable : true, align: 'left'},
                    <?php //}?>
                    <?php //if(!in_array('sol_id',$ocultas)){?>
                    {display: 'ID', name : 'sol_id', width : /*40*/75, sortable : true, align: 'left'},
                    <?php //}?>
                    <?php //if(!in_array('est_id',$ocultas)){?>
                    {display: 'Estado', name : 'est_id', width : 44, sortable : true, align: 'left'},
                    <?php //}?>	
                    <?php //if(!in_array('sol_fec_creacion',$ocultas)){?>
                    {display: 'Fecha', name : 'sol_fec_creacion', width : 85, sortable : true, align: 'left'},
                    <?php //}?>
                    <?php //if(!in_array('sol_uidnumber',$ocultas)){?>
                    {display: 'C&oacute;digo', name : 'sol_uidnumber', width : 60, sortable : true, align: 'left'},
                    <?php //}?> 
                    <?php //if(!in_array('sol_login',$ocultas)){?>
                    {display: 'Login', name : 'sol_login', width : 90, sortable : true, align: 'left'},
                    <?php //}?>
                    <?php //if(!in_array('sol_nombre',$ocultas)){?>
                    {display: 'Estudiante', name : 'sol_nombre', width : 100, sortable : true, align: 'left'},
                    <?php //}?>
                    <?php //if(!in_array('sol_apellido',$ocultas)){?>
                    {display: 'Apellido', name : 'sol_apellido', width : 150, sortable : true, align: 'left'},
                    <?php //}?>
                    <?php //if(!in_array('sol_ins_mat',$ocultas)){?>
                    {display: 'Programa', name : 'sol_prog', width : /*50*/160, sortable : true, align: 'left'},
                    <?php //if(!in_array('sol_ins_mat',$ocultas)){?>
                    {display: 'Doble Programa', name : 'sol_doble_prog', width : /*50*/160, sortable : true, align: 'left'},
                    <?php //if(!in_array('sol_ins_mat',$ocultas)){?>
                    {display: 'Cr&eacute;ditos Acumulados', name : 'sol_creditos', width : /*50*/100, sortable : true, align: 'left'},
                    <?php //}?>
                    <?php //if(!in_array('sol_ins_mat',$ocultas)){?>
                    {display: 'Periodo', name : 'sol_periodo', width : /*50*/60, sortable : true, align: 'left'},
                    <?php //}?>
                    <?php //if(!in_array('sol_ins_mat',$ocultas)){?>
                    {display: 'Cod materia', name : 'sol_ins_mat', width : /*50*/60, sortable : true, align: 'left'},
                    <?php //}?>
                    <?php //if(!in_array('sol_ins_crn',$ocultas)){?>
                    {display: 'CRN', name : 'sol_ins_crn', width : 40, sortable : true, align: 'left'},
                    <?php //}?>
                    <?php //if(!in_array('sol_ins_des',$ocultas)){?>
                    {display: 'Materia', name : 'sol_ins_des', width : /*200*/300, sortable : true, align: 'left'},
					{display: 'Lista cruzada', name : 'sol_lista_cruzada', width : 100, sortable : true, align: 'left'},
                    <?php //}?>
                    <?php //if(!in_array('sol_ins_seccion',$ocultas)){?>
                    {display: 'Secci&oacute;n', name : 'sol_ins_seccion', width : 40, sortable : true, align: 'left'},
                    <?php //}?>
                    <?php //if(!in_array('tip_id',$ocultas)){?>
                    {display: 'Tipo', name : 'tip_id', width : /*100*/200, sortable : true, align: 'left'},
                    <?php //}?>
                    <?php //if(!in_array('mov_id',$ocultas)){?>
                    {display: 'Motivo', name : 'mov_id', width : /*100*/200, sortable : true, align: 'left'},
                    {display: 'Alternativa1', name : 'sol_alternativas', width : /*100*/80, sortable : true, align: 'left'},
                    {display: 'Alternativa2', name : 'sol_alternativas', width : /*100*/80, sortable : false, align: 'left'},
                    <?php //}?>
                    <?php //if(!in_array('sol_descripcion',$ocultas)){?>
                    {display: 'Descripci&oacute;n', name : 'sol_descripcion', width : /*200*/300, sortable : true, align: 'left'},
                    <?php //}?>
                    <?php //if(!in_array('sol_ins_instructor',$ocultas)){?>
                    {display: 'Profesor', name : 'sol_ins_instructor', width : /*200*/300, sortable : true, align: 'left'},
                    <?php //}?>
                    {display: 'Opci&oacute;n estudiante', name : 'sol_opcion_estud', width : /*200*/300, sortable : true, align: 'left'},
                    {display: 'SSC', name : 'sol_ssc', width : /*200*/25, sortable : true, align: 'left'},
                    {display: 'Primer Semestre', name : 'sol_primer_sem', width : /*200*/100, sortable : true, align: 'left'},
                    {display: 'Fecha &Uacute;timo estado', name : 'sol_fec_est_actualiza', width : /*200*/100, sortable : true, align: 'left'},
                ],
                buttons : [
					<?php if(($this->session->userdata('rol')) != 2){?>
				    {name: 'Cancelar', bclass: 'delete', onpress : doCommand},
                    <?php }?>
                    {name: 'Cambiar estado', bclass: 'update', onpress : doCommand},
                    //{name: 'Comentarios', bclass: 'comment', onpress : doCommand},
                    {name: 'Crear solicitud', bclass: 'create', onpress : doCommand},
                    {name: 'Ver solicitud', bclass: 'view', onpress : doCommand},
                    {separator: true},
                    {name: 'Seleccionar todos', bclass: 'selectall', onpress : doCommand},
                    {name: '<img src="<?php echo base_url()."css/horario.png"; ?>" title="Ver horario" height="22" align="left" />', bclass: 'selTodo', onpress : verHorario},
                    // {name: 'Ver todas las columnas', bclass: 'view', onpress : doCommand},
                    {separator: true}
                ],
                searchitems : [
                    {display: 'ID', name : 'sol_id', isdefault: <?php $isdefault = $qtype=='sol_id' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Estado', name : 'est_descripcion', isdefault: <?php $isdefault = $qtype=='est_descripcion' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Fecha', name : 'sol_fec_creacion', isdefault: <?php $isdefault = $qtype=='sol_fec_creacion' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'C&oacute;digo', name : 'sol_uidnumber', isdefault: <?php $isdefault = $qtype=='sol_uidnumber' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Login', name : 'sol_login', isdefault: <?php $isdefault = $qtype=='sol_login' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Estudiante', name : 'sol_nombre', isdefault: <?php $isdefault = $qtype=='sol_nombre' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Apellido', name : 'sol_apellido', isdefault: <?php $isdefault = $qtype=='sol_apellido' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Programa', name : 'sol_prog', isdefault: <?php $isdefault = $qtype=='sol_prog' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Doble Programa', name : 'sol_doble_prog', isdefault: <?php $isdefault = $qtype=='sol_doble_prog' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Cr&eacute;ditos Acumulados', name : 'sol_creditos', isdefault: <?php $isdefault = $qtype=='sol_creditos' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Periodo', name : 'sol_periodo', isdefault: <?php $isdefault = $qtype=='sol_periodo' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Cod Materia', name : 'sol_ins_mat', isdefault: <?php $isdefault = $qtype=='sol_ins_mat' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'CRN', name : 'sol_ins_crn', isdefault: <?php $isdefault = $qtype=='sol_ins_crn' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Materia', name : 'sol_ins_des', isdefault: <?php $isdefault = $qtype=='sol_ins_des' ? 'true' : 'false'; echo $isdefault; ?>},
					{display: 'Lista cruzada ', name : 'sol_lista_cruzada', isdefault: <?php $isdefault = $qtype=='sol_lista_cruzada' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Secci&oacute;n', name : 'sol_ins_seccion', isdefault: <?php $isdefault = $qtype=='sol_ins_seccion' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Tipo', name : 'tip_descripcion', isdefault: <?php $isdefault = $qtype=='tip_descripcion' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Motivo', name : 'mov_descripcion', isdefault: <?php $isdefault = $qtype=='mov_descripcion' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Descripci&oacute;n', name : 'sol_descripcion', isdefault: <?php $isdefault = $qtype=='sol_descripcion' || $qtype=='' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Profesor', name : 'sol_ins_instructor', isdefault: <?php $isdefault = $qtype=='sol_ins_instructor' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Opci&oacute;n estudiante', name : 'sol_opcion_estud', isdefault: <?php $isdefault = $qtype=='sol_ins_instructor' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'SSC', name : 'sol_ssc', isdefault: <?php $isdefault = $qtype=='sol_ins_instructor' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Primer semestre', name : 'sol_primer_sem', isdefault: <?php $isdefault = $qtype=='sol_ins_instructor' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Alternativas', name : 'sol_alternativas', isdefault: <?php $isdefault = $qtype=='sol_ins_instructor' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Marca de seguimiento (Si/No)', name : 'sol_marca', isdefault: <?php $isdefault = $qtype=='sol_ins_instructor' ? 'true' : 'false'; echo $isdefault; ?>}
                ],
                searchitems2 : [
                    {display: 'ID', name : 'sol_id', isdefault: <?php $isdefault = $qtype2=='sol_id' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Estado', name : 'est_descripcion', isdefault: <?php $isdefault = $qtype2=='est_descripcion' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Fecha', name : 'sol_fec_creacion', isdefault: <?php $isdefault = $qtype2=='sol_fec_creacion' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'C&oacute;digo', name : 'sol_uidnumber', isdefault: <?php $isdefault = $qtype2=='sol_uidnumber' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Login', name : 'sol_login', isdefault: <?php $isdefault = $qtype2=='sol_login' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Estudiante', name : 'sol_nombre', isdefault: <?php $isdefault = $qtype2=='sol_nombre' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Apellido', name : 'sol_apellido', isdefault: <?php $isdefault = $qtype2=='sol_apellido' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Programa', name : 'sol_prog', isdefault: <?php $isdefault = $qtype2=='sol_prog' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Doble Programa', name : 'sol_doble_prog', isdefault: <?php $isdefault = $qtype2=='sol_doble_prog' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Cr&eacute;ditos Acumulados', name : 'sol_creditos', isdefault: <?php $isdefault = $qtype2=='sol_creditos' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Periodo', name : 'sol_periodo', isdefault: <?php $isdefault = $qtype2=='sol_periodo' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Cod Materia', name : 'sol_ins_mat', isdefault: <?php $isdefault = $qtype2=='sol_ins_mat' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'CRN', name : 'sol_ins_crn', isdefault: <?php $isdefault = $qtype2=='sol_ins_crn' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Materia', name : 'sol_ins_des', isdefault: <?php $isdefault = $qtype2=='sol_ins_des' ? 'true' : 'false'; echo $isdefault; ?>},
					{display: 'lista cruzada', name : 'sol_lista_cruzada', isdefault: <?php $isdefault = $qtype2=='sol_lista_cruzada' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Secci&oacute;n', name : 'sol_ins_seccion', isdefault: <?php $isdefault = $qtype2=='sol_ins_seccion' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Tipo', name : 'tip_descripcion', isdefault: <?php $isdefault = $qtype2=='tip_descripcion' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Motivo', name : 'mov_descripcion', isdefault: <?php $isdefault = $qtype2=='mov_descripcion' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Descripci&oacute;n', name : 'sol_descripcion', isdefault: <?php $isdefault = $qtype2=='sol_descripcion' || $qtype2=='' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Profesor', name : 'sol_ins_instructor', isdefault: <?php $isdefault = $qtype2=='sol_ins_instructor' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'Opci&oacute;n estudiante', name : 'sol_opcion_estud', isdefault: <?php $isdefault = $qtype=='sol_ins_instructor' ? 'true' : 'false'; echo $isdefault; ?>},
                    {display: 'SSC', name : 'sol_ssc', isdefault: <?php $isdefault = $qtype=='sol_ins_instructor' ? 'true' : 'false'; echo $isdefault; ?>}
                ],
                searchitems3 : [
                    {display: 'Seleccione estado', name : '0', isdefault : <?php echo (count($estados_sol)) ? 'false' : 'true' ;?>},
                    <?php   if(count($estados_sol)){
                                $xg = 0;
                                foreach($estados_sol as $est){ ?>
                                    {display: '<?php echo trim($est["est_descripcion"]); ?>', name : '<?php echo $est["est_id"]; ?>', isdefault : <?php echo ($est["est_id"] == $query3) ? 'true' : 'false' ;?>}
                    <?php           if($xg < (count($estados_sol)-1)): ?>
                                        ,
                    <?php           endif;
                                    $xg++;
                                }
                            }?>
                ],
                sortname: "<?php if($sortname!='') echo $sortname; else echo 'sol_id'; ?>",
                sortorder: "<?php if($sortorder!='') echo $sortorder; else echo 'asc'; ?>",
                usepager: true,
                title: "<?php echo $titulo;?>",
                useRp: true,
                rp: <?php echo $rp;?>,
                showTableToggleBtn: false,
                resizable: true,
                width: 1200,
                height: 600,
                singleSelect: false,
                otro:'<?php echo $otro;?>',
			
                query2: '<?php echo $query2; ?>'
            });
        });
        //$('.selectall').parent().parent().css('background-color', '#ffffff');
        $('#flex1').dblclick( function (e) {
            target = $(e.target);
            while(target.get(0).tagName != "TR"){
              target = target.parent();
            }
            var cell = {'id': target.get(0).id.substr(3)}
            var ocultos = ordencol = ordencol_label = ordencol_width = '';
            $(".hDivBox >table >thead >tr >th").each(function (index) {
                if($(this).css('display')=='none')
                    ocultos = ocultos+$(this).attr("abbr")+';';	
                ordencol = ordencol+$(this).attr("abbr")+';';
                ordencol_label = ordencol_label+$(this).children('div').text()+';';
                ordencol_width = ordencol_width+$(this).children('div').css("width")+';';
            })
            var qtype = $("select[name=qtype]").val();
            var query = $("input[name=q]").val();
            var qtype2 = $("select[name=qtype2]").val();
            var query2 = $("input[name=q2]").val();
            $.ajax({
                url: '<?php echo base_url()?>index.php/reporte/columnas',
                type: "POST",
                data: 'qtype='+qtype+'&query='+query+'&qtype2='+qtype2+'&query2='+query2,	
                success: function(html){
                    if(html=='OK'){
                        window.location.href='<?php echo base_url()?>index.php/solicitud/ver/'+cell['id'];
                    }
                }
            })        
        });
    });  
    mensaje = '<?php if(!empty($mensaje))echo urldecode($mensaje);else echo '';?>';
    if(mensaje!='')
        alert(mensaje);
    function doCommand(com, grid)
    {
        // var ocultos = ordencol = ordencol_label = ordencol_width = '';
        // $(".hDivBox >table >thead >tr >th").each(function (index) {
            // if($(this).css('display')=='none')
                // ocultos = ocultos+$(this).attr("abbr")+';';	
                    // ordencol = ordencol+$(this).attr("abbr")+';';
                    // ordencol_label = ordencol_label+$(this).children('div').text()+';';
                    // ordencol_width = ordencol_width+$(this).children('div').css("width")+';';
        // })
        var qtype = $("select[name=qtype]").val();
        var query = $("input[name=q]").val();
        var qtype2 = $("select[name=qtype2]").val();
        var query2 = $("input[name=q2]").val();
        $.ajax({
            url: '<?php echo base_url()?>index.php/reporte/columnas',
            type: "POST",
            data: 'qtype='+qtype+'&query='+query+'&qtype2='+qtype2+'&query2='+query2,	
            success: function(html){
                if(html=='OK'){
                    var lista='';
                    if (com == 'Actualizar') {
                      $('.trSelected', grid).each(function() {
                        var id = $(this).attr('id');
                        id = id.substring(id.lastIndexOf('row')+3);
                        lista=id+'*';
                      });
                      var todos = lista.split('*');
                      if(!todos[0]=='')
                        window.location.href='<?php echo base_url()?>index.php/solicitud/actualizar/'+todos[0];
                    } else if (com == 'Cancelar') {
                        $('.trSelected', grid).each(function() {	  
                          var id = $(this).attr('id');
                          id = id.substring(id.lastIndexOf('row')+3);
                          lista=lista+id+'-';
                        });
                        if(lista!='')
                         window.location.href='<?php echo base_url()?>index.php/solicitud/formacancelar/'+lista;
                        else
                         alert('Seleccione una o mas filas');
                    }else if(com=='Crear solicitud'){
                      window.location.href='<?php echo base_url()?>index.php/solicitud/crearadm';
                    }else if(com=="Cambiar estado"){
                        $('.trSelected', grid).each(function() {	  
                          var id = $(this).attr('id');
                          id = id.substring(id.lastIndexOf('row')+3);
                          lista=lista+id+'-';
                        });
                        if(lista!='')
                                    window.location.href='<?php echo base_url()?>index.php/solicitud/formaestado/'+lista + '?masivo=true';
                        else
                         alert('Seleccione una o mas filas');
                    }

                    /*else if(com=='Comentarios'){
                        $('.trSelected', grid).each(function() {
                        var id = $(this).attr('id');
                        id = id.substring(id.lastIndexOf('row')+3);
                        lista=id+'*';
                      });
                      var todos = lista.split('*');
                      if(!todos[0]=='')
                      window.location.href='<?php echo base_url()?>index.php/solicitud/comentario/'+todos[0];
                    }*/
                    else if(com=="Comentarios"){
                        var seleccionados = 0;
                        $('.trSelected', grid).each(function() {	  
                          var id = $(this).attr('id');
                          id = id.substring(id.lastIndexOf('row')+3);
                          lista=lista+id+'-';
                          seleccionados++;
                        });
                        if(lista!='') {			 
                             if(seleccionados < 2){
                                  var todos = lista.split('-');
                                 if(!todos[0]=='')
                                       window.location.href='<?php echo base_url()?>index.php/solicitud/comentario/'+todos[0]; //solo un comentario
                             }
                             else {			      
                                  window.location.href='<?php echo base_url()?>index.php/solicitud/formacomentario/'+lista; //comentarios masivos
                             }
                        }
                        else
                             alert('Seleccione una o mas filas');
                    }

                    else if(com=='Ver solicitud'){
                        $('.trSelected', grid).each(function() {
                        var id = $(this).attr('id');
                        id = id.substring(id.lastIndexOf('row')+3);
                        lista=id+'*';
                      });
                      var todos = lista.split('*');
                      if(!todos[0]=='')
                      window.location.href='<?php echo base_url()?>index.php/solicitud/ver/'+todos[0];

                    }else if(com=='Seleccionar todos'){
                        selall('flex1');
                    }else if(com=='Ver todas las columnas'){
                      window.location.href='<?php echo base_url()?>index.php/solicitud/columnasno';
                    }		
                }

            }
        });           
    }  
    function _modificar(obj)
    {
        if(obj.val()=="6"){
            obj.next().next().show();
        }else{
            obj.next().next().hide();
        }
        obj.next().next().val("");
    }
    jQuery(window).load(function(){
	jQuery(".sDiv2.searchdiv").append("<br><br><br><div class='clon_filtro' style='padding-bottom: 8px; display: block; margin-left: -8px; background: #f2f2f2'></div></div>");
	jQuery("select[name='qtype']").after("<input type='image' style='height: 32px; width:32px !important; margin-right: 20px;' id='btn_adicionar' title='Adicionar filtro' src='<?php echo base_url()."css/agregar.png"; ?>' />");
	jQuery("select[name='qtype2'], input[name='q2'], select[name='qtype'], input[name='q']").hide();
	jQuery(".searchdiv > label:first").html("Adicionar filtro &nbsp;&nbsp;&nbsp;");
	jQuery("#btn_adicionar").click(function(){ 
            if(jQuery(".clon_filtro .fDivs").length<5){
                var html = "<div class='fDivs' style='display: block; margin-top: 15px;'>";
                html += "<select name='qtype' onchange='actualizoCampo(this)'>";
                html += jQuery("select[name='qtype']:first").html();
                html += "</select>";
                html += "<select name='qoper' onclick='_modificar(jQuery(this))'>";
                html += "<option value='0'>Igual</option>";
                html += "<option value='1'>Mayor</option>";
                html += "<option value='2'>Menor</option>";
                html += "<option value='3'>Contenga</option>";
                html += "<option value='4'>Inicie con</option>";
                html += "<option value='5'>Finalice con</option>";
                html += "<option value='6'>Rango</option>";
                html += "</select> ";
                html += "<input type='text' class='qsbox' name='q' size='30' value=''/> ";
                html += "<input type='text' class='qsbox' style='display: none;' name='_q' size='30' value='' /> ";
                html += "<select name='qoper2' style='width: 40px !important'>";
                html += "<option value='2'>O</option>";
                html += "<option value='1'>Y</option>";
                html += "<input type='image' src='<?php echo base_url()."css/quitar.png"; ?>' style='height: 32px; width:32px !important; margin-left: 6px' onclick='jQuery(this).parent().remove()' />";
                html += "<br><br></div>";
                jQuery("div.clon_filtro").append(html);
            }else{
                alert("Solo puede realizar 5 filtros simultaneos.");
            }
	});
        <?php 
        $q = @json_decode(@$this->session->userdata["query"]);
        if(count(@$q->solicitud)>0){
            foreach($q->solicitud as $k=>$r){
                $valor = explode(":=:",$r->valor);?>
                jQuery("#btn_adicionar").click();
                jQuery(jQuery("[name='qtype']")[<?php echo $k+1; ?>]).val("<?php echo $r->qtype; ?>");
                jQuery(jQuery("[name='qoper']")[<?php echo $k; ?>]).val("<?php echo (int)$r->operador; ?>");
                jQuery(jQuery("[name='qoper2']")[<?php echo $k; ?>]).val("<?php echo @$r->operador2; ?>");
                _modificar(jQuery(jQuery("[name='qoper']")[<?php echo $k; ?>]));
                jQuery(jQuery("[name='q']")[<?php echo $k+1; ?>]).val("<?php echo @$valor[0]; ?>");
                jQuery(jQuery("[name='_q']")[<?php echo $k; ?>]).val("<?php echo @$valor[1]; ?>");
<?php       }
        } else { ?>
            jQuery("#btn_adicionar").click();
<?php   }?>
        jQuery("div.fDivs select[name='qtype']").each(function(index,element){
            optCampo = jQuery(element).val();
            if (optCampo == "sol_prog"){
                jQuery(element).siblings("input[name='q']").autocomplete({
                    source: [<?php echo $listProgramas; ?>]
                });
            }
            if (optCampo == "est_descripcion"){
                jQuery(element).siblings("input[name='q']").autocomplete({
                    source: [<?php echo $listEstado; ?>]
                });
            } 
			if (optCampo == "est_descripcioncolor"){
                jQuery(element).siblings("input[name='q']").autocomplete({
                    source: [<?php echo $listEstadoColor; ?>]
                });
            }
            if (optCampo == "tip_descripcion"){
                jQuery(element).siblings("input[name='q']").autocomplete({
                    source: [<?php echo $listTipo; ?>]
                });
            }
            if (optCampo == "mov_descripcion"){
                jQuery(element).siblings("input[name='q']").autocomplete({
                    source: [<?php echo $listMotivo; ?>]
                });
            }
        });
    
    });
</script>
<style>
    .searchdiv {
        width: 1200px !important;
    }
    .searchdiv input,.searchdiv select{
        width: 150px !important;	
    }
    .searchdiv input[type="button"]{
        width: 70px !important;	
        margin-right: 10px;
    }
    .alert_msg_com {
        background: #DF0101;
        color: #FFFFFF;
        display: block;
        font-family: Verdana;
        font-size: 8px;
        font-weight: bold;
        height: 2px;
        line-height: 0;
        position: absolute;
        right: -4px;
        text-align: right;
        top: -6px;
        z-index: 9;
    }
</style>
<br>
<table width="100%" border="0" style="border:1px #F2F2F2 solid; color:#FFFFFF">
    <tbody>
    <tr>
      <td style="background-color:#CC0000; font-size:10px">En revisi&oacute;n </td>
      <td style="background-color:#7030A0; font-size:10px">Solicitudes no exitosas</td>
      <td style="background-color:#00B050; font-size:10px">Solicitudes exitosas</td>
      <td style="background-color:#FFC000; font-size:10px">En espera de respuesta del estudiante </td>
      <td style="background-color:#000000; font-size:10px">Cancelada por estudiante</td>
      <td style="background-color:#0070C0; font-size:10px">Lista de espera </td>
    </tr>
  </tbody>
</table>
<br>
<input type="hidden" id="esSolicitudAdmin" value="1" />
<input type="hidden" id="recargaAdmin" value="" autocomplete="off" />
<table id="flex1" width="80%" style="border:1px #F2F2F2 solid" border="0"></table>
<script type="text/javascript">
    jQuery(window).load(function(){
            try{
                    var estados = '<?php echo $this->session->userdata("query3"); ?>';
                    estados = estados.split(",");
                    for(var d in estados){
                            jQuery("#dgestados .dgcheck[value='"+estados[d]+"']").click();
                            jQuery("#dgquery3 option[value='"+estados[d]+"']")[0].selected=true;
                    }
            }catch(e){}
    });
    function marcar_registro(obj){
        var $sol_id = jQuery(obj).val();
        var $marca = jQuery(obj).is(":checked");
        jQuery.ajax({
            url: "<?php echo base_url()?>index.php/solicitud/marcar_registro",
            type: "post",
            data: {
                sol_id: $sol_id,
                marca: ($marca ? "si" : "no")
            },
            success: function(data){
                if(data != "OK"){
                    alert("La sesión ha caducado. Por favor recargue la ventana.");
                }
            }
        });
    }
    function actualizoCampo(obj)
    {
        var opt = jQuery(obj).val();
        var parent = jQuery(obj).parent().find("[name='qoper']");
        var html = "<option value='0'>Igual</option>";
        html += "<option value='1'>Mayor</option>";
        html += "<option value='2'>Menor</option>";
        html += "<option value='3'>Contenga</option>";
        html += "<option value='4'>Inicie con</option>";
        html += "<option value='5'>Finalice con</option>";
        html += "<option value='6'>Rango</option>";
        if (opt == "sol_prog")
        {
             jQuery(obj).siblings("input[name='q']").autocomplete({
            //jQuery("div.fDivs input[name='q']").autocomplete({
                source: [<?php echo $listProgramas; ?>]
            });

        }else if (opt == "est_descripcion")
        {
            jQuery(obj).siblings("input[name='q']").autocomplete({
                source: [<?php echo $listEstado; ?>]
            });

        }else if (opt == "tip_descripcion")
        {
            jQuery(obj).siblings("input[name='q']").autocomplete({
                source: [<?php echo $listTipo; ?>]
            });

        }else if (opt == "mov_descripcion")
        {
            jQuery(obj).siblings("input[name='q']").autocomplete({
                source: [<?php echo $listMotivo; ?>]
            });

        } else if (opt == "sol_alternativas") {
            html = "<option value='3'>Contenga</option>";
            console.log("Alternativas");
        } else if (opt == "sol_marca") {
            html = "<option value='0'>Igual</option>";
            console.log("Alternativas");
        } else {
            try {
                jQuery(obj).siblings("input[name='q']").autocomplete("destroy");
            }
            catch(err) {
                //console.log("Se ha presentado la siguiente excepción :"+err);
            }
        }
        parent.html(html);
    }
</script>
<?php
$this->load->view("footer");
?>