<?php 
	include_once('../modelo/m_rpttramitedetalle.php');
	$obj_repcargo = new Reptramitedetalle;
	$_GET['titulo']='Listado de Tramites';
	$result = $obj_repcargo->consultar($_GET['tramite'],$_GET['cedula'],$_GET['estatus']);
	$obj_repcargo->reporte($result);
 ?>