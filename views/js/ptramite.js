
 	var tabla;

     function init(){
         
        listar();
 
        //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
        $("#tramite_form").on("submit",function(e){
            e.preventDefault();
            guardaryeditar(e);	
        })
         
        //cambia el titulo de la ventana modal cuando se da click al boton
        $("#add_button").click(function(){
                 
             $(".modal-title").text("Registrar Trámite");
        });

        $("#tramite_anular_recaudo_form").on("submit",function(e){
            e.preventDefault();
            guardarAnular(e);	
        });

        $("#tramite_procesar_tramite_form").on("submit",function(e){
            e.preventDefault();
            guardarProcesar(e);	
        });

        $(".agregarModal").on('click', function(){
            $("#tramiteModal").modal("show");
        });

     }
 
 
     function limpiar(){
        //if( $("#") ){

        //}else{
            $('#nombre').val("");
            $('#codestado').html("<option value=''>Seleccione una opcion</option>");
            $('#codmunicipio').html("<option value=''>Seleccione una opcion</option>");
            $('#codparroquia').html("<option value=''>Seleccione una opcion</option>");
            $('#codsector').html("<option value=''>Seleccione una opcion</option>");
            $('#idtramite').val("");
            $("#codpais").val("");
            $("#cedulasolicitante").val("");	
            $("#fechainicio").val("");
    
            $('.js-example-basic-multiple').select2({
                language: "es"
                , theme: "bootstrap"
                , width: null
                , tokenSeparators: [',', ' ']
                , minimumInputLength: 1
            });
        
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                startDate: '-1m',
                autoclose: true,
                endDate: new Date()
            }); 
        //}
        
     }
 
     function listar(){
         tabla=$('#tramite_data').dataTable({
             "aProcessing": true,
             "aServerSide": true,
             dom: 'Bfrtip',
             buttons: [
                         'copyHtml5',
                         'excelHtml5',
                         'csvHtml5',
                         'pdf'
                     ],
             "ajax":
                     {
                         url: '../ajax/ptramite.php?op=listar',
                         type : "get",
                         dataType : "json",						
                         error: function(e){
                             console.log(e.responseText);	
                         }
                     },
             "bDestroy": true,
             "responsive": true,
             "bInfo":true,
             "iDisplayLength": 10,//Por cada 10 registros hace una paginación
             "order": [[ 0, "desc" ]],//Ordenar (columna,orden)
             
             "language": {
                     "sProcessing":     "Procesando...",
                     "sLengthMenu":     "Mostrar _MENU_ registros",
                     "sZeroRecords":    "No se encontraron resultados",
                     "sEmptyTable":     "Ningún dato disponible en esta tabla",
                     "sInfo":           "Mostrando un total de _TOTAL_ registros",
                     "sInfoEmpty":      "Mostrando un total de 0 registros",
                     "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                     "sInfoPostFix":    "",
                     "sSearch":         "Buscar:",
                     "sUrl":            "",
                     "sInfoThousands":  ",",
                     "sLoadingRecords": "Cargando...",
                     "oPaginate": {
                         "sFirst":    "Primero",
                         "sLast":     "Último",
                         "sNext":     "Siguiente",
                         "sPrevious": "Anterior"
                     },
                     "oAria": {
                         "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                         "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                         }
                        }//cerrando language
         }).DataTable();
     }
 
     function mostrar(codtramite){
         $.post("../ajax/ptramite.php?op=mostrar",{codtramite : codtramite}, function(data, status){
             data = JSON.parse(data);
             $('#tramiteModal').modal('show');
             $('#nombre').val(data.nombre);
             $('#estado').val(data.estado);
             $('.modal-title').text("Editar tramite");
             $('#idtramite').val(codtramite);
             $('#action').val("Edit");	

             /*
                Array
                    (
                        [id] => 8
                        [field_foreign] => codpais
                        [table] => estado
                        [value] => codestado
                        [description] => nombre
                    )
            
            */
            //console.log(data);
            //$("#codpais option:selected").removeAttr("selected");	
            

            //$("#codpais option[value="+ data.codpais +"]").attr('selected', 'selected');
            cargarCombo('','','pais','codpais','nombre',data.codpais);
            cargarCombo(data.codpais,'codpais','estado','codestado','nombre',data.codestado);

         });        
     }
 
     function guardaryeditar(e){
         e.preventDefault();
         e.stopImmediatePropagation();
         var formData = new FormData($("#tramite_form")[0]);
 
         $.ajax({
             url: "../ajax/ptramite.php?op=guardaryeditar",
             type: "POST",
             data: formData,
             contentType: false,
             processData: false,
 
             success: function(datos){
                 console.log(datos);

                 $('#resultados_ajax').html(datos);

                if( $("#tipomensaje").val() == 'correcto' ){
                    $('#tramite_form')[0].reset();
                    $('#tramiteModal').modal('hide');
    
                    $('#resultados_ajax_session').html("");
                    $('#tramite_data').DataTable().ajax.reload();
                    
                    limpiar();	
                }else{
                    $('#tramiteModal').modal('hide');
                }
 
                 	
             }
         });
            
     }
 
 
 
     function cambiarEstado(codtramite, est){
          bootbox.confirm("¿Está seguro de cambiar de estatus?", function(result){
             if(result){
                 $.ajax({
                     url:"../ajax/ptramite.php?op=activarydesactivar",
                     method:"POST",
                     data:{codtramite:codtramite, est:est},
                     success: function(data){
                      
                         $('#tramite_data').DataTable().ajax.reload();
                     
                     }
 
                 });
 
                 }
         });//bootbox
        }

        function cargarCombo(id,field_foreign,table,value,description,selected){
            /*
                Array
                    (
                        [id] => 8
                        [field_foreign] => codpais
                        [table] => estado
                        [value] => codestado
                        [description] => nombre
                    )
            
            */
          $.ajax({
              url:"../ajax/c_combo.php?op=list_combo",
              method:"POST",
              data:{ id:id, field_foreign:field_foreign, table:table, value:value, description:description, selected:selected},
              success: function(data){
              
                  //console.log(data);
                  $("#"+ value).html(data);
              
              }

          });
        }


        
        function soloLetrasConEspacio(e) { 
             // 1
             tecla = (document.all) ? e.keyCode : e.which;
             if (tecla==8) return true; // backspace
             if (tecla==32) return true; // espacio
             //if (e.ctrlKey && tecla==86) { return true;} //Ctrl v
             //if (e.ctrlKey && tecla==67) { return true;} //Ctrl c
             //if (e.ctrlKey && tecla==88) { return true;} //Ctrl x
         
             patron = /[a-zA-Z]/; //patron
         
             te = String.fromCharCode(tecla);
             return patron.test(te); // prueba de patron
         } 


        function cambiarEstatus(e){
            console.log(location.href="http://localhost/inti/views/ptramite.php?estatus="+e);
        }

        function anularTramite(idtramite,codtramite,ciudadano,tramite,fecha,sector,estatus,observacion){
            $("#idtramiteanular").val(idtramite);
            $("#spanciudadano_2").html(ciudadano);
            $("#spantramite_2").html(tramite);
            $("#spanfecha_2").html(fecha);
            $("#spansector_2").html(sector);
            $("#spanobservacion_2").html(observacion);
            $("#tramiteAnularModal").modal("show"); 
        }

        function procesarTramite(idtramite,codtramite,ciudadano,tramite,fecha,sector,codestatus,observacion){
            $("#idtramiteprocesar").val(idtramite);
            $("#codestatusprocesar").val(codestatus);
            $("#spanciudadano_3").html(ciudadano);
            $("#spantramite_3").html(tramite);
            $("#spanfecha_3").html(fecha);
            $("#spansector_3").html(sector);
            $("#spanobservacion_3").html(observacion);
            $("#tramiteProcesarModal").modal("show");   
        }

        function guardarProcesar(e){
            e.preventDefault();
            e.stopImmediatePropagation();
            var formData = new FormData($("#tramite_procesar_tramite_form")[0]);
    
            $.ajax({
                url: "../ajax/ptramite.php?op=ProcesarTramite",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
    
                success: function(datos){
                    console.log(datos);

          
                    location.reload();
                    
                    
                    /*
                    $('#tramite_anular_recaudo_form')[0].reset();
                    $('#tramiteModal').modal('hide');
    
                    $('#resultados_ajax').html(datos);
                    $('#resultados_ajax_session').html("");
                    $('#tramite_data').DataTable().ajax.reload();
                    
                    limpiar();		
                    */
                }
            });
        }

        function guardarAnular(e){
            e.preventDefault();
            e.stopImmediatePropagation();
            var formData = new FormData($("#tramite_anular_recaudo_form")[0]);
    
            $.ajax({
                url: "../ajax/ptramite.php?op=AnularTramite",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
    
                success: function(datos){
                    console.log(datos);

          
                    location.reload();
                    
                    
                    /*
                    $('#tramite_anular_recaudo_form')[0].reset();
                    $('#tramiteModal').modal('hide');
    
                    $('#resultados_ajax').html(datos);
                    $('#resultados_ajax_session').html("");
                    $('#tramite_data').DataTable().ajax.reload();
                    
                    limpiar();		
                    */
                }
            });
        }

        function listarRecaudos(idtramite,codtramite,ciudadano,tramite,fecha,sector,estatus,observacion){

           // console.log(idtramite);

            $("#spanciudadano").html(ciudadano);
            $("#spantramite").html(tramite);
            $("#spanfecha").html(fecha);
            $("#spansector").html(sector);
            $("#spanobservacion").html(observacion);

            

            var bar_progress = ' <tr> '+
                            '<td colspan="4"> <div class="progress progress-sm"> '+
                                '<div class="progress-bar bg-success progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span class="">Cargando...</span> '+
                                '</div> </div> '+
                            '</td> '+
                        '</tr>';

            $("#tramite_data_tbody").html(bar_progress);

            $("#tramiteRecaudoModal").modal("show");

            $.ajax({
                url:"../ajax/ptramite.php?op=cargarRecaudos",
                method:"POST",
                data:{ idtramite:idtramite, codtramite:codtramite },
                dataType:'Json',
                success: function(data){
                
                    console.log(data);

                    
                    setTimeout(function(){
                        $("#tramite_data_tbody").html(data.tbody);

                        /*
                        $('.minimal input').iCheck({
                            checkboxClass: 'icheckbox_square-blue',
                            radioClass: 'iradio_square-green',
                            cursor: true,
                            insert: '<div class="icheck_line-icon"></div>',
                            increaseArea: '20%'
                        });*/

                        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                            checkboxClass: 'icheckbox_minimal-blue',
                            radioClass   : 'iradio_minimal-blue'
                        });


                        $('input').on('ifChecked', function(event){

                            // event.delegateTarget.attributes.value.nodeType
                            var idrecaudo  = event.delegateTarget.attributes.value.value;
                            var idtramite  = event.delegateTarget.attributes.idtramite.value;
                            var codtramite = event.delegateTarget.attributes.codtramite.value;

                            $.ajax({
                                url:"../ajax/ptramite.php?op=agregarRecaudos",
                                method:"POST",
                                data:{ idtramite:idtramite, idrecaudo:idrecaudo, codtramite:codtramite },
                                dataType:'Json',
                                success: function(data){
                                
                                    //console.log(data);

                                    if ( data.tramiteactualizado == "SI" ){
                                        location.reload();
                                    }

                                }
                            });
                       
                        });

                        $('input').on('ifUnchecked', function(event){

                            // event.delegateTarget.attributes.value.nodeType
                            var idrecaudo = event.delegateTarget.attributes.value.value;
                            var idtramite = event.delegateTarget.attributes.idtramite.value;
                            var codtramite = event.delegateTarget.attributes.codtramite.value;

                            $.ajax({
                                url:"../ajax/ptramite.php?op=removerRecaudos",
                                method:"POST",
                                data:{ idtramite:idtramite, idrecaudo:idrecaudo, codtramite:codtramite },
                                dataType:'Json',
                                success: function(data){
                                
                                    //console.log(data);

                                    if ( data.tramiteactualizado == "SI" ){
                                        location.reload();
                                    }

                                }
                            });

                        });





                    }, 1000);
                   
                
                }
  
            });

        }


 
 
      init();