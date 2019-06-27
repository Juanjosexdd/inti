
 	var tabla;

	function init(){
		
		listar();

		$("#visita_form").on("submit",function(e){

			guardaryeditar(e);	
		});

		$("#add_button").click(function(){
				
			$(".modal-title").text("Registrar Visita");
		});
	}


	function limpiar(){
	
		$('#cedulaciudadano').val("");
		$('#fechainicio').val("");
		$('#codvisita').val("");
		$('#motivo').val("");
		$('#idvisita').val("");
		$('#coddpto').val("");

		$('.datepicker').datepicker({
	        format: 'dd/mm/yyyy',
	        startDate: '-1m',
	        autoclose: true,
	        endDate: new Date()
	    });
	}

	function listar(){
		tabla=$('#visita_data').dataTable({
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
						url: '../ajax/pvisita.php?op=listar',
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

	function mostrar(idvisita){
		$.post("../ajax/pvisita.php?op=mostrar",{idvisita : idvisita}, function(data, status){
			data = JSON.parse(data);
			$('#visitaModal').modal('show');
			$('#cedulaciudadano').val(data.cedulaciudadano);
			$('#fechainicio').val(data.fechainicio);
			$('#codvisita').val(data.codvisita);
			$('#motivo').val(data.motivo);
			$('#coddpto').val(data.coddpto);
			$('.modal-title').text("Editar visita");
			$('#idvisita').val(idvisita);
			$('#action').val("Edit");	
		});        
	}

	function guardaryeditar(e){
		e.preventDefault();
		var formData = new FormData($("#visita_form")[0]);

		$.ajax({
			url: "../ajax/pvisita.php?op=guardaryeditar",
		    type: "POST",
		    data: formData,
		    contentType: false,
		    processData: false,

		    success: function(datos){
		        console.log(datos);

	            $('#visita_form')[0].reset();
				$('#visitaModal').modal('hide');

				$('#resultados_ajax').html(datos);
				$('#visita_data').DataTable().ajax.reload();
				
                limpiar();		
		    }
		});
	}

	function finvisita(idvisita){
        bootbox.confirm("¿Esta seguro que finalizo la visita?", function(result){
            if(result){
                $.ajax({
                    url:"../ajax/pvisita.php?op=finvisita",
                    method:"POST",
                    data:{idvisita:idvisita},
                    success: function(data){
                    	$('#visita_data').DataTable().ajax.reload();
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
		patron = /[a-zA-Z]/; //patron
	
		te = String.fromCharCode(tecla);
		return patron.test(te); // prueba de patron
	} 


 	init();