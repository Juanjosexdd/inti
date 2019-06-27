var tabla;
 
 	//Función que se ejecuta al inicio
  	function init(){
	    listar();
	    //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
		$("#ciudadano_form").on("submit",function(e){
			guardaryeditar(e);	
		})
		//cambia el titulo de la ventana modal cuando se da click al boton
		$("#add_button").click(function(){	
			$(".modal-title").text("Registrar Ciudadano");
		});
	}
	//funcion que limpia los campos del formulario
    function limpiar(){
    	$('nacionalidad')
   		$("#cedula").val("");
   		$('#rif').val("");
		$('#primernombre').val("");
		$('#segundonombre').val("");
		$('#primerapellido').val("");
		$('#segundoapellido').val("");
		$('#direccion').val("");
		$('#telefono').val("");
		$('#email').val("");
		$('#estatus').val("");
		$('#idciudadano').val("");
   	}
    //function listar 
    function listar(){

    	tabla=$('#ciudadano_data').dataTable({

    	"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],

		"ajax":

		   {
					url: '../ajax/ciudadano.php?op=listar',
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
	    "order": [[ 0, "asc" ]],//Ordenar (columna,orden)

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
    //Mostrar datos delciudadano en la ventana modal del formulario 
    function mostrar(idciudadano){
     	$.post("../ajax/ciudadano.php?op=mostrar",{idciudadano : idciudadano}, function(data, estatus){ 
         	data = JSON.parse(data);
            $("#ciudadanoModal").modal("show");
            $("#nacionalidad").val(data.nacionalidad);
            $("#cedula").val(data.cedula);
            $('#tiporif').val(data.tiporif);
            $('#rif').val(data.rif);
			$('#primernombre').val(data.primernombre);
			$('#segundonombre').val(data.segundonombre);
			$('#primerapellido').val(data.primerapellido);
			$('#segundoapellido').val(data.segundoapellido);
			$('#direccion').val(data.direccion);
			$('#telefono').val(data.telefono);
			$('#email').val(data.email);
			$('#direccion').val(data.direccion);
			$('#estatus').val(data.estatus);
			$('.modal-title').text("Editar Ciudadano");
			$('#idciudadano').val(idciudadano);
			$('#action').val("Edit");
		});
	}
    //la funcion guardaryeditar(e); se llama cuando se da click al boton submit  
    function guardaryeditar(e){

      	e.preventDefault(); //No se activará la acción predeterminada del evento
      	var formData = new FormData($("#ciudadano_form")[0]);

            $.ajax({
           	    url: "../ajax/ciudadano.php?op=guardaryeditar",
			    type: "POST",
			    data: formData,
			    contentType: false,
			    processData: false,

			    success: function(datos){

			    	console.log(datos);

			    	$('#ciudadano_form')[0].reset();
					$('#ciudadanoModal').modal('hide');

					$('#resultados_ajax2').html(datos);
					$('#ciudadano_data').DataTable().ajax.reload();
			
                    limpiar();
			    }
            });
    }     
    //EDITAR ESTADO DEL USUARIO
    //importante:idciudadano, est se envia por post via ajax
    function cambiarEstado(idciudadano,estatus){
        bootbox.confirm("¿Está Seguro de cambiar de estado?", function(result){
			if(result){
	           	$.ajax({
					url:"../ajax/ciudadano.php?op=activarydesactivar",
					method:"POST",
					//toma el valor del id y del estado
					data:{idciudadano:idciudadano, estatus:estatus},
					
					success: function(data){
	                  	$('#ciudadano_data').DataTable().ajax.reload();
					}
				});
			}
		});//bootbox
    }
    //ELIMINAR USUARIO
	function eliminar(idciudadano){
	    bootbox.confirm("¿Está Seguro de eliminar el ciudadano?", function(result){
			if(result) {
				$.ajax({
					url:"../ajax/ciudadano.php?op=eliminar_ciudadano",
					method:"POST",
					data:{idciudadano:idciudadano},

					success:function(data){
						//alert(data);
						$("#resultados_ajax2").html(data);
						$("#ciudadano_data").DataTable().ajax.reload();
					}
				});
			}
		});//bootbox
    }

    function fnv_soloNumeros(){
	    var keynum = window.event ? window.event.keyCode : e.which;
	    
	    if ((keynum == 8))
			return true;
		
		return /\d/.test(String.fromCharCode(keynum));
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