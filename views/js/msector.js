
 	var tabla;

     function init(){
         
         listar();
 
          //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
         $("#sector_form").on("submit",function(e){
 
             guardaryeditar(e);	
         });
         $("#add_button").click(function(){
                
            $(".modal-title").text("Registrar Sector");
        });
     }
 
 
     function limpiar(){
        $('#nombre').val("");
        $('#codsector').val("");
        $('#codparroquia').val("");
        $('#codmunicipio').val("");	
        $('#codestado').val("");
        $('#codpais').val("");	
     }
 
     function listar(){
         tabla=$('#sector_data').dataTable({
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
                         url: '../ajax/msector.php?op=listar',
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
 
     function mostrar(codsector){
         $.post("../ajax/msector.php?op=mostrar",{codsector : codsector}, function(data, status){
             data = JSON.parse(data);
             $('#sectorModal').modal('show');
             $('#nombre').val(data.nombre);
             $('.modal-title').text("Editar Sector");
             $('#codestado').val(codestado);
             $('#codmunicipio').val(codmunicipio);
             $('#codparroquia').val(codparroquia);
             $('#codsector').val(codsector);
             $('#estado').val(data.estado);
             $('#action').val("Edit");	

           
            cargarCombo('','','pais','codpais','nombre',data.codpais);
            cargarCombo(data.codpais,'codpais','estado','codestado','nombre',data.codestado);
            cargarCombo(data.codestado,'codestado','municipio','codmunicipio','nombre',data.codmunicipio);
            cargarCombo(data.codmunicipio,'codmunicipio','parroquia','codparroquia','nombre',data.codparroquia);


         });        
     }
 
     function guardaryeditar(e){
         e.preventDefault();
         var formData = new FormData($("#sector_form")[0]);
 
         $.ajax({
             url: "../ajax/msector.php?op=guardaryeditar",
             type: "POST",
             data: formData,
             contentType: false,
             processData: false,
 
             success: function(datos){
                 console.log(datos);
 
                 $('#sector_form')[0].reset();
                 $('#sectorModal').modal('hide');
 
                 $('#resultados_ajax').html(datos);
                 $('#sector_data').DataTable().ajax.reload();
                 
                 limpiar();		
             }
         });
            
     }
 
 
     function cambiarEstado(codsector, est){
          bootbox.confirm("¿Está seguro de cambiar de estatus?", function(result){
             if(result){
                 $.ajax({
                     url:"../ajax/msector.php?op=activarydesactivar",
                     method:"POST",
                     data:{codsector:codsector, est:est},
                     success: function(data){
                      
                         $('#sector_data').DataTable().ajax.reload();
                     
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
                        [field_foreign] => codestado
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
                  $("#codestado").html(data);
              
              }

          });
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



 
 
      init();