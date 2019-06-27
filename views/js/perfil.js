
//una vez se da click a submit se llama a la funcion editar_perfil(e)

	$("#perfil_form").on("submit",function(e)
	{
		editar_perfil(e);
	});


	function mostrar_perfil(idusuario){
		$.post("../ajax/perfil.php?op=mostrar_perfil",{idusuario_perfil : idusuario_perfil}, function(data, status){
			data = JSON.parse(data);

			$('#perfilModal').modal('show');
			$('#nombre_perfil').val(data.nombre);
			$('#apellido_perfil').val(data.apellido);
			$('#cedula_perfil').val(data.cedula);
			$('#telefono_perfil').val(data.telefono);
			$('#email_perfil').val(data.correo);
			$('#direccion_perfil').val(data.direccion);
			$('#usuario_perfil').val(data.usuario_perfil);
			$('#password_perfil').val(data.password);
			$('#password2_perfil').val(data.password2);
			//$('#estado').val(data.estado);
			$('.modal-title').text("Editar Usuario");
			$('#idusuario_perfil').val(idusuario);
			$('#action').val("Edit");
			$('#operation').val("Edit");	
		});

	}


	function editar_perfil(e){
		e.preventDefault(); //No se activará la acción predeterminada del evento
		//$("#btnGuardar").prop("disabled",true);
		var formData = new FormData($("#perfil_form")[0]);

		var password= $("#password_perfil").val();
		var password2= $("#password_perfil").val();

		//var id_usuario= $("#usuario_perfil_id").val();

	    //alert(id_usuario);
		if(password==password2){

			$.ajax({
				url: "../ajax/perfil.php?op=editar_perfil",
			    type: "POST",
			    data: formData,
			    contentType: false,
			    processData: false,

			    success: function(datos){                    
			          
			         console.log(datos);

		            //$('#perfil_form')[0].reset();
					$('#perfilModal').modal('hide');

					$('#resultados_ajax').html(datos);
					//$('#usuario_data').DataTable().ajax.reload();
			    }
			});
	      }	
	}