<?php 
	include_once('../modelo/m_rptestado.php');
	$obj_repcargo = new Repestado;
	$_GET['titulo']='Listado de Estados';
	$result = $obj_repcargo->consultar($_GET['estatus'],$_GET['dato']);
	$obj_repcargo->reporte($result);
 ?>
