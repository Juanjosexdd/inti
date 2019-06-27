
 	var tabla;

	function init(){
		
		listar();

		$("#recaudos_form").on("submit",function(e){

			guardaryeditar(e);	
		});
		$("#add_button").click(function(){
				
			$(".modal-title").text("Registrar Recaudos");
		});
	}


	function limpiar(){
	
		$('#idrecaudos').val("");
		$('#nombre').val("");
		$('#descripcion').val("");
	}

	function listar(){
		tabla=$('#recaudos_data').dataTable({
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
						url: '../ajax/mrecaudos.php?op=listar',
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

	function mostrar(idrecaudos){
		$.post("../ajax/mrecaudos.php?op=mostrar",{idrecaudos : idrecaudos}, function(data, status){
			data = JSON.parse(data);
			$('#recaudosModal').modal('show');
			$('#nombre').val(data.nombre);
			$('#descripcion').val(data.descripcion);
			$('#idrecaudos').val(idrecaudos);
			$('#estado').val(data.estado);
			$('.modal-title').text("Editar Recaudos");
			$('#action').val("Edit");	
		});        
	}

	function guardaryeditar(e){
		e.preventDefault();
		var formData = new FormData($("#recaudos_form")[0]);

		$.ajax({
			url: "../ajax/mrecaudos.php?op=guardaryeditar",
		    type: "POST",
		    data: formData,
		    contentType: false,
		    processData: false,

		    success: function(datos){
		        console.log(datos);

	            $('#recaudos_form')[0].reset();
				$('#recaudosModal').modal('hide');

				$('#resultados_ajax11').html(datos);
				$('#recaudos_data').DataTable().ajax.reload();
				
                limpiar();		
		    }
		});
	}



    function cambiarEstado(idrecaudos, est){
 		bootbox.confirm("¿Está seguro de cambiar de estatus?", function(result){
			if(result){
				$.ajax({
					url:"../ajax/mrecaudos.php?op=activarydesactivar",
					method:"POST",
					data:{idrecaudos:idrecaudos, est:est},
					success: function(data){
	                	$('#recaudos_data').DataTable().ajax.reload();
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


 	init();