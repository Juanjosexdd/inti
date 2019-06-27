/*
	onKeyPress="return fnjSoloNumeros(event)" 
	onKeyUp="javascript:this.value=this.value.toUpperCase();"
*/

function fnComboDinamico(comboPadre,comboHijo){
	$('#'+comboPadre).ready(function(){
		var id=$('#'+comboPadre).val();
		//aAlert("ID:"+id);
		$('#'+comboHijo).load('../control/ctrl_combos.php?h='+comboHijo+'&id='+id);
	});    
}
			
function aAlert(msj){	bootbox.alert({ message:msj});  }


function fnv_campoVacioTxt (campo) {
    //console.log(campo);
	if(document.getElementById(campo).value.length==0 || /^\s+$/.test( document.getElementById(campo).value)){
		document.getElementById(campo).style.border="2px solid #FF0000";
		return 1;
	}else{
		document.getElementById(campo).style.border="2px solid #E5E5E5";	
		return 0;
	}
}
function fnv_campoVacioTxtRango (campo,rango) {
	if(document.getElementById(campo).value.length<=rango || /^\s+$/.test( document.getElementById(campo).value)){
		document.getElementById(campo).style.border="2px solid #FF0000";
		return 1;
	}else{
		document.getElementById(campo).style.border="2px solid #E5E5E5";	
		return 0;
	}
}

function fnv_campoVacioSelect (campo) {
var id=document.getElementById(campo).value;
	if (id == '' || id  == 0) {
		document.getElementById(campo).style.border="2px solid #FF0000";
		 return 1;
	}else{	
		document.getElementById(campo).style.border="1px solid #E5E5E5";	
		return 0;	}  
}




function fnv_soloNumeros(e){
    var keynum = window.event ? window.event.keyCode : e.which;
    
    if ((keynum == 8) || (keynum == 46))
		return true;
	
	return /\d/.test(String.fromCharCode(keynum));
}

function fnjSoloLetrasNum(e){
   tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true; // borrar
    if (tecla==32) return false; // espacio
    
    if ( tecla>=48 && tecla<=57 ) return true; // numeros del 0 al 9
    
    //if (e.ctrlKey && tecla==86) { return true;} //Ctrl v
    //if (e.ctrlKey && tecla==67) { return true;} //Ctrl c
    //if (e.ctrlKey && tecla==88) { return true;} //Ctrl x
    
    patron = /[a-zA-Z]/; //patron
    
    te = String.fromCharCode(tecla);
    return patron.test(te); // prueba de patron
}
function fnjSoloLetrasNumConEspacio(e){
   tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true; // borrar
    if (tecla==32) return true; // espacio
    
    if ( tecla>=48 && tecla<=57 ) return true; // numeros del 0 al 9
    
    //if (e.ctrlKey && tecla==86) { return true;} //Ctrl v
    //if (e.ctrlKey && tecla==67) { return true;} //Ctrl c
    //if (e.ctrlKey && tecla==88) { return true;} //Ctrl x
    
    patron = /[a-zA-Z]/; //patron
    
    te = String.fromCharCode(tecla);
    return patron.test(te); // prueba de patron
}
function fnjSoloLetrasNumCaracter(e){
   tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true; // borrar
    if (tecla==32) return true; // espacio
    if (tecla==45) return true; // guion
    
    if ( tecla>=48 && tecla<=57 ) return true; // numeros del 0 al 9
    
    //if (e.ctrlKey && tecla==86) { return true;} //Ctrl v
    //if (e.ctrlKey && tecla==67) { return true;} //Ctrl c
    //if (e.ctrlKey && tecla==88) { return true;} //Ctrl x
    
    patron = /[a-zA-Z]/; //patron
    
    te = String.fromCharCode(tecla);
    return patron.test(te); // prueba de patron
}

function fnjSoloLetras(e) { 
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

function soloLetrasSinEspacio(e) { 
	// 1
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true; // backspace
    //if (tecla==32) return true; // espacio
    //if (e.ctrlKey && tecla==86) { return true;} //Ctrl v
    //if (e.ctrlKey && tecla==67) { return true;} //Ctrl c
    //if (e.ctrlKey && tecla==88) { return true;} //Ctrl x
 
    patron = /[a-zA-Z]/; //patron
 
    te = String.fromCharCode(tecla);
    return patron.test(te); // prueba de patron
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

