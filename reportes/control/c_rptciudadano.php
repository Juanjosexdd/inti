<?php 
	include_once('../modelo/m_rptciudadano.php');
	$obj_repcargo = new Repciudadano;
	$_GET['titulo']='Listado de Ciudadanos';
	$result = $obj_repcargo->consultar($_GET['estatus'],$_GET['dato']);
	$obj_repcargo->reporte($result);
 ?>