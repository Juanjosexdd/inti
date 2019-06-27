
 	var tabla;

	 function init(){
		 
		 listar();
 
		  //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
		 $("#tramite_form").on("submit",function(e){
 
			 guardaryeditar(e);	
		 });
		 
		 //cambia el titulo de la ventana modal cuando se da click al boton
		 $("#add_button").click(function(){
				 
			 $(".modal-title").text("Registrar Trámite");
		 });


		 $("#tramite_asociar_recaudo_tramite_form").on("submit",function(e){
			guardarAsociarRecaudo(e);	
		})
	 }
 
 
	 function limpiar(){
	 
		$('#nombre').val("");
		//$('#estado').val("");
		$('#codtramite').val("");	

		$("#idrecaudos").val("");
		$("#cantidad").val("");

		$("#resultados_ajax_msj").html("");

		$('.js-example-basic-multiple').select2({
			  language: "es"
			, theme: "bootstrap"
			, width: null
			, tokenSeparators: [',', ' ']
			, minimumInputLength: 0
		});


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
						 url: '../ajax/mtramite.php?op=listar',
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
		 $.post("../ajax/mtramite.php?op=mostrar",{codtramite : codtramite}, function(data, status){
			 data = JSON.parse(data);
			 $('#tramiteModal').modal('show');
			 $('#nombre').val(data.nombre);
			 $('#descripcion').val(data.descripcion);
			 $('#estado').val(data.estado);
			 $('.modal-title').text("Editar Trámite");
			 $('#codtramite').val(codtramite);
			 $('#action').val("Edit");	
		 });        
	 }
 
	 function guardaryeditar(e){
		 e.preventDefault();
		 var formData = new FormData($("#tramite_form")[0]);
 
		 $.ajax({
			 url: "../ajax/mtramite.php?op=guardaryeditar",
			 type: "POST",
			 data: formData,
			 contentType: false,
			 processData: false,
 
			 success: function(datos){
				 console.log(datos);
 
				 $('#tramite_form')[0].reset();
				 $('#tramiteModal').modal('hide');
 
				 $('#resultados_ajax4').html(datos);
				 $('#tramite_data').DataTable().ajax.reload();
				 
				 limpiar();		
			 }
		 });
			
	 }

	 function guardarAsociarRecaudo(e){
		//console.log(e);
		e.preventDefault();
		e.stopImmediatePropagation();
		var formData = new FormData($("#tramite_asociar_recaudo_tramite_form")[0]);

		$.ajax({
			url: "../ajax/mtramite.php?op=AsociarRecaudos",
			type: "POST",
			data: formData,
			dataType:'Json',
			contentType: false,
			processData: false,

			success: function(datos){
				console.log(datos);

				$("#recaudo_data_tbody").html(datos.tbody);

				if(datos.error){
					$("#resultados_ajax_msj").html(datos.error);
				}else{
					limpiar();
				}

				
				/*

				$('#tramite_form')[0].reset();
				$('#tramiteModal').modal('hide');

				$('#resultados_ajax4').html(datos);
				$('#tramite_data').DataTable().ajax.reload();
				
				limpiar();
				*/		
			}
		});

	 }
 
	 function cambiarEstado(codtramite, est){
		  bootbox.confirm("¿Está seguro de cambiar de estatus?", function(result){
			 if(result){
				 $.ajax({
					 url:"../ajax/mtramite.php?op=activarydesactivar",
					 method:"POST",
					 data:{codtramite:codtramite, est:est},
					 success: function(data){
					  
						$('#tramite_data').DataTable().ajax.reload();
					 
					 }
 
				 });
 
				 }
		 });//bootbox
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

		 function removerRecaudos(id,codtramite){
			$.ajax({
				url:"../ajax/mtramite.php?op=removerRecaudos",
				method:"POST",
				data:{ id:id, codtramite:codtramite },
				dataType:'Json',
				success: function(data){
				
					console.log(data);
					$("#recaudo_data_tbody").html(data.tbody);
					limpiar();	

					

				}
			});
		 }

		 function asociarRecaudos(codtramite,nombre,descripcion){

			$("#codtramiteAsociarRecaudos").val(codtramite);
            $("#spannombre").html(nombre);
			$("#spandescripcion").html(descripcion);

			var bar_progress = ' <tr> '+
						'<td colspan="4"> <div class="progress progress-sm"> '+
							'<div class="progress-bar bg-success progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span class="">Cargando...</span> '+
							'</div> </div> '+
						'</td> '+
					'</tr>';

			$("#recaudo_data_tbody").html(bar_progress);


			$("#tramiteAsociarRecaudoModal").modal("show"); 


			$.ajax({
                url:"../ajax/mtramite.php?op=cargarRecaudos",
                method:"POST",
                data:{ codtramite:codtramite },
                dataType:'Json',
                success: function(data){
                
                    console.log(data);

                    
                    setTimeout(function(){
						$("#recaudo_data_tbody").html(data.tbody);
						
						limpiar();		
					}, 1000);
                   
                
				}
			});
			
		 }

		 function fnv_soloNumeros(e){
			var keynum = window.event ? window.event.keyCode : e.which;
			
			if ((keynum == 8))
				return true;
			
			return /\d/.test(String.fromCharCode(keynum));
		}
		
 
 
	  init();