<?php 
	include_once('../modelo/m_rptcargo.php');
	$obj_repcargo = new Repcargo;
	$_GET['titulo']='Listado de Cargos';
	$result = $obj_repcargo->consultar($_GET['estatus'],$_GET['dato']);
	$obj_repcargo->reporte($result);
 ?>