//Application programming interface

window.addEventListener('load', login , false);

function login () {
	usuario = document.getElementById('user');
	pass = document.getElementById('pass');
	enviar.addEventListener('click',evento);
	error = document.getElementById('error');
	check = document.getElementById('check');
}

function evento () {
	if (usuario.value == '' || usuario.value == null) {
		usuario.setCustomValidity('Ingrese su Usuario');
		alert('[ALERTA!] El usuario es Obligatorio');
		usuario.style.border = ' 2px solid #ce1818';
		usuario.style.borderRadius = '4px';

		return false;
	}else{
		usuario.setCustomValidity('');
		usuario.style.border = 'none';
	}
	
	if (usuario.value.length < 4 || usuario.value.length > 30) {
		alert('[ALERTA!] El usuario es debe tener entre 4 y 30 caracteres');
		usuario.style.border = ' 2px solid #ce1818';
		usuario.style.borderRadius = '4px';
		return false;
	}else{
	 	usuario.setCustomValidity('');
		usuario.style.border = 'none';
	}

	if (pass.value == '') {
		pass.setCustomValidity('Ingrese su Contraseña');
		alert('[ALERTA!] La Contraceña es Obligatoria');
		pass.style.border = ' 2px solid #ce1818';
		pass.style.borderRadius = '4px';
		return false;
	}else{
		pass.setCustomValidity('');

	}

	if (pass.value.length < 6 || pass.value.length > 20) {
		pass.setCustomValidity('La contraseña debe tener  en 6 y 20 caracteres');
		alert('[ALERTA!] La contraseña debe tener  entre 6 y 10 caracteres');
		pass.style.border = ' 2px solid #ce1818';
		pass.style.borderRadius = '4px';
		return false;

	}
	if (check.checked == false){
		confirm('[ALERTA!] Su contraseña no se guardara');
		return false;
	} else {
		confirm('[ALERTA!] Desea guardar su contraseña?')
	}
}


