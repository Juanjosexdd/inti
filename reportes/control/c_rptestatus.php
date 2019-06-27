<?php 
	include_once('../modelo/m_rptestatus.php');
	$obj_repcargo = new Repestatus;
	$_GET['titulo']='Listado de Estatus';
	$result = $obj_repcargo->consultar($_GET['estatus']);
	$obj_repcargo->reporte($result);
 ?>