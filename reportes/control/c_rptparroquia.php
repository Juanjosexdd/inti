<?php 
	include_once('../modelo/m_rptparroquia.php');
	$obj_repcargo = new Repparroquia;
	$_GET['titulo']='Listado de Parroquias';
	$result = $obj_repcargo->consultar($_GET['estatus'],$_GET['dato']);
	$obj_repcargo->reporte($result);
 ?>