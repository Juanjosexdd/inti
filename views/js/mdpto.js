
 	var tabla;

	function init(){
		
		listar();

		$("#dpto_form").on("submit",function(e){

			guardaryeditar(e);	
		});
		
		$("#add_button").click(function(){
				
			$(".modal-title").text("Registrar Departamento");
		});
	}


	function limpiar(){
	
		$('#coddpto').val("");
		$('#nombre').val("");
		$('#id').val("");	
	}

	function listar(){
		tabla=$('#dpto_data').dataTable({
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
						url: '../ajax/mdpto.php?op=listar',
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

	function mostrar(id){
		$.post("../ajax/mdpto.php?op=mostrar",{id : id}, function(data, status){
			data = JSON.parse(data);
			$('#dptoModal').modal('show');
			$('#coddpto').val(data.coddpto);
			$('#nombre').val(data.nombre);
			$('#estado').val(data.estado);
			$('.modal-title').text("Editar Departamento");
			$('#id').val(id);
			$('#action').val("Edit");	
		});        
	}

	function guardaryeditar(e){
		e.preventDefault();
		var formData = new FormData($("#dpto_form")[0]);

		$.ajax({
			url: "../ajax/mdpto.php?op=guardaryeditar",
		    type: "POST",
		    data: formData,
		    contentType: false,
		    processData: false,

		    success: function(datos){
		        console.log(datos);

	            $('#dpto_form')[0].reset();
				$('#dptoModal').modal('hide');

				$('#resultados_ajax5').html(datos);
				$('#dpto_data').DataTable().ajax.reload();
				
                limpiar();		
		    }
		});
	       
	}



    function cambiarEstado(id, est){
 		bootbox.confirm("¿Está seguro de cambiar de estatus?", function(result){
			if(result){
				$.ajax({
					url:"../ajax/mdpto.php?op=activarydesactivar",
					method:"POST",
					data:{id:id, est:est},
					success: function(data){
	                 
	                	$('#dpto_data').DataTable().ajax.reload();
				    
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

		function fnv_soloNumeros(e){
		    var keynum = window.event ? window.event.keyCode : e.which;
		    
		    if ((keynum == 8) || (keynum == 46))
				return true;
			
			return /\d/.test(String.fromCharCode(keynum));
		}


 	init();