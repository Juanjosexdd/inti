<?php 
	include_once('../modelo/m_rptorden.php');
	$obj_repcargo = new Reporden;
	$_GET['titulo']= utf8_decode('Secuencia de Aprobación');
	$result = $obj_repcargo->consultar($_GET['estatus'],$_GET['dato']);
	$obj_repcargo->reporte($result);
 ?>