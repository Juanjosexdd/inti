<?php 
	include_once('../modelo/m_rptsector.php');
	$obj_repcargo = new Repsector;
	$_GET['titulo']='Listado de Sectores';
	$result = $obj_repcargo->consultar($_GET['estatus'],$_GET['dato']);
	$obj_repcargo->reporte($result);
 ?>