
 	var tabla;

	function init(){
		
		listar();

		$("#roles_form").on("submit",function(e){

			guardaryeditar(e);	
		});
		$("#add_button").click(function(){
				
			$(".modal-title").text("Registrar roles");
		});
	}


	function limpiar(){
	
		$('#nombre').val("");
		$('#descripcion').val("");
		$('#idroles').val("");	
	}

	function listar(){
		tabla=$('#roles_data').dataTable({
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
						url: '../ajax/roles.php?op=listar',
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

	function mostrar(idroles){
		$.post("../ajax/roles.php?op=mostrar",{idroles : idroles}, function(data, status){
			data = JSON.parse(data);
			$('#rolesModal').modal('show');
			$('#nombre').val(data.nombre);
			$('#descripcion').val(data.descripcion);
			$('#estado').val(data.estado);
			$('.modal-title').text("Editar roles");
			$('#idroles').val(idroles);
			$('#action').val("Edit");	
		});        
	}

	function guardaryeditar(e){
		e.preventDefault();
		var formData = new FormData($("#roles_form")[0]);

		$.ajax({
			url: "../ajax/roles.php?op=guardaryeditar",
		    type: "POST",
		    data: formData,
		    contentType: false,
		    processData: false,

		    success: function(datos){
		        console.log(datos);

	            $('#roles_form')[0].reset();
				$('#rolesModal').modal('hide');

				$('#resultados_ajax10').html(datos);
				$('#roles_data').DataTable().ajax.reload();
				
                limpiar();		
		    }
		});
	}



    function cambiarEstado(idroles, est){
 		bootbox.confirm("¿Está seguro de cambiar de estatus?", function(result){
			if(result){
				$.ajax({
					url:"../ajax/roles.php?op=activarydesactivar",
					method:"POST",
					data:{idroles:idroles, est:est},
					success: function(data){
	                 
	                	$('#roles_data').DataTable().ajax.reload();
				    
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


 	init();