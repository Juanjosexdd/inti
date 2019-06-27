<?php 
	include_once('../modelo/m_rptvisita.php');
	$obj_repcargo = new Repvisita;
	$_GET['titulo']='Listado de Visitas';
	$result = $obj_repcargo->consultar($_GET['dato'],$_GET['fecha']);
	$obj_repcargo->reporte($result);


	  
 ?>