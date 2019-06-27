<?php 
	include_once('../modelo/m_rptrecaudos.php');
	$obj_repcargo = new Reprecaudos;
	$_GET['titulo']='Listado de Recaudos';
	$result = $obj_repcargo->consultar($_GET['estatus'],$_GET['dato']);
	$obj_repcargo->reporte($result);
 ?>