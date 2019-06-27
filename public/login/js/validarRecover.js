//Application Programming Interface



// (function () {
	
	let formulario = document.getElementById('formulario'),
		pass = formulario.pass,
		pass2 = formulario.pass2,
		pass3 = formulario.pass3;
	let espacios = false;
	let cont = 0;

	function valuePass(e,) {
		if (pass.value == '' || pass2.value == '' || pass3.value == '') {
			//pass.setCustomValidity('Ingrese su Contraseña');
			alert('[ALERTA!] La Contraceña es Obligatoria');
			pass.style.border = ' 2px solid #ce1818';
			pass.style.borderRadius = '4px';
			return false;
			e.preventDefault();
		}else{
			pass.setCustomValidity('');
		}
	}
	function iguales(e) {
		if (pass2.value != pass3.value) {
			alert("('[ALERTA!]Las Contraseñas no Coinciden");
			return false;
		}
	}

	// function espacios(e) {

	// 	while (!espacios && (cont < pass2.length)) {
	// 		if (pass2.charAt(cont) == " ")
	// 			espacios = true;
	// 			cont++;
	// 		}

	// 		if (espacios) {
	// 			alert ("La contraseña no puede contener espacios en blanco");
	// 			return false;
	// 		}
	// }

	function todas(e) {

		valuePass(e);
		iguales(e);
		//espacios(e);
	}


	formulario.addEventListener('submit', todas);


// }())