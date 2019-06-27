//(function(){
	var formulario = document.getElementById('formulario'),
		user = formulario.user,
		pass = formulario.pass,
		checked = formulario.check,
		error = document.getElementById('error');

	function validarUser(e){
		if(user.value == '' || user.value == null){
			console.log('Por favor completa el nombre');
			error.style.display = 'block';
			error.innerHTML += '<li>Por favor completa el nombre</li>';
			e.preventDefault();
		} else {
			error.style.display = 'none';
		}
	}

	function validarPass(e){
		if(pass.value == '' || pass.value == null){
			console.log('Por favor completa el nombre');
			error.style.display = 'block';
			error.innerHTML += '<li>Por favor completa el nombre</li>';
			e.preventDefault();
		} else {
			error.style.display = 'none';
		}
	}
	

	function validarFormulario(e){
		error.innerHTML = '';

		validarUser(e);
		validarPass(e);
	}

	


	formulario.addEventListener('submit', validarFormulario);

//})