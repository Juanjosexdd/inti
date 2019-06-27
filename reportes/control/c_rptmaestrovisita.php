<?php 
	include_once('../modelo/m_rptmaestrovisita.php');
	$obj_repcargo = new Repvisita;
	$_GET['titulo']= utf8_decode('Listado Tipos de Visitas');
	$result = $obj_repcargo->consultar($_GET['estatus'],$_GET['dato']);
	$obj_repcargo->reporte($result);
 ?>