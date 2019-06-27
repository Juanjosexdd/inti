
 	var tabla;

	function init(){
		
		listar();

		 //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
		$("#estatus_form").on("submit",function(e){

			guardaryeditar(e);	
		})

		$("#add_button").click(function(){
				
			$(".modal-title").text("Registrar Estatus");
		});
	}


	function limpiar(){
	
		$('#codestatus').val("");
		$('#nombre').val("");
		$('#descripcion').val("");

	}

	function listar(){
		tabla=$('#estatus_data').dataTable({
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
						url: '../ajax/mestatus.php?op=listar',
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

	function mostrar(idestatus){
		$.post("../ajax/mestatus.php?op=mostrar",{idestatus : idestatus}, function(data, status){
			data = JSON.parse(data);
			$('#estatusModal').modal('show');
			$('#codestatus').val(data.codestatus);
			$('#nombre').val(data.nombre);
			$('#descripcion').val(data.descripcion);
			$('#estado').val(data.estado);
			$('.modal-title').text("Editar Estatus");
			$('#idestatus').val(idestatus);
			$('#action').val("Edit");	
		});        
	}

	function guardaryeditar(e){
		e.preventDefault();
		var formData = new FormData($("#estatus_form")[0]);

		$.ajax({
			url: "../ajax/mestatus.php?op=guardaryeditar",
		    type: "POST",
		    data: formData,
		    contentType: false,
		    processData: false,

		    success: function(datos){
		        console.log(datos);

	            $('#estatus_form')[0].reset();
				$('#estatusModal').modal('hide');

				$('#resultados_ajax4').html(datos);
				$('#estatus_data').DataTable().ajax.reload();
				
                limpiar();		
		    }
		});
	}



    function cambiarEstado(idestatus, est){
 		bootbox.confirm("¿Está seguro de cambiar de estatus?", function(result){
			if(result){
				$.ajax({
					url:"../ajax/mestatus.php?op=activarydesactivar",
					method:"POST",
					data:{idestatus:idestatus, est:est},
					success: function(data){
	                 
	                	$('#estatus_data').DataTable().ajax.reload();
				    
				    }

				});

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
		function fnv_soloNumeros(e){
		    var keynum = window.event ? window.event.keyCode : e.which;
		    
		    if ((keynum == 8) || (keynum == 46))
				return true;
			
			return /\d/.test(String.fromCharCode(keynum));
		}

 	init();