
 	var tabla;

	function init(){
		
		listar();

		 //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
		$("#pais_form").on("submit",function(e){

			guardaryeditar(e);	
		})
	    
	    //cambia el titulo de la ventana modal cuando se da click al boton
		$("#add_button").click(function(){
				
			$(".modal-title").text("Registrar País");
		});
	}


	function limpiar(){
	
		$('#nombre').val("");
		//$('#estado').val("");
		$('#codpais').val("");	
	}

	function listar(){
		tabla=$('#pais_data').dataTable({
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
						url: '../ajax/mpais.php?op=listar',
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

	function mostrar(codpais){
		$.post("../ajax/mpais.php?op=mostrar",{codpais : codpais}, function(data, status){
			data = JSON.parse(data);
			$('#paisModal').modal('show');
			$('#nombre').val(data.nombre);
			$('#estado').val(data.estado);
			$('.modal-title').text("Editar País");
			$('#codpais').val(codpais);
			$('#action').val("Edit");	
		});        
	}

	function guardaryeditar(e){
		e.preventDefault();
		var formData = new FormData($("#pais_form")[0]);

		$.ajax({
			url: "../ajax/mpais.php?op=guardaryeditar",
		    type: "POST",
		    data: formData,
		    contentType: false,
		    processData: false,

		    success: function(datos){
		        console.log(datos);

	            $('#pais_form')[0].reset();
				$('#paisModal').modal('hide');

				$('#resultados_ajax4').html(datos);
				$('#pais_data').DataTable().ajax.reload();
				
                limpiar();		
		    }
		});
	       
	}



    function cambiarEstado(codpais, est){
 		bootbox.confirm("¿Está seguro de cambiar de estatus?", function(result){
			if(result){
				$.ajax({
					url:"../ajax/mpais.php?op=activarydesactivar",
					method:"POST",
					data:{codpais:codpais, est:est},
					success: function(data){
	                 
	                	$('#pais_data').DataTable().ajax.reload();
				    
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