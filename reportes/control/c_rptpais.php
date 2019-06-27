<?php 
	include_once('../modelo/m_rptpais.php');
	$obj_repcargo = new Reppais;
	$_GET['titulo']='Listado de Paises';
	$result = $obj_repcargo->consultar($_GET['estatus']);
	$obj_repcargo->reporte($result);
 ?>