<?php 
	include_once('../modelo/m_rptmunicipio.php');
	$obj_repcargo = new Repmunicipio;
	$_GET['titulo']='Listado de Municipios';
	$result = $obj_repcargo->consultar($_GET['estatus'],$_GET['dato']);
	$obj_repcargo->reporte($result);
 ?>