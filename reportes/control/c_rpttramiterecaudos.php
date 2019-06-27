<?php 
	include_once('../modelo/m_rpttramiterecaudos.php');
	$obj_repcargo = new Reptramiterecaudos;
	$_GET['titulo']= utf8_decode('Listado Recaudos Por Trámite');
	$result = $obj_repcargo->consultar($_GET['estatus'],$_GET['dato']);
	$obj_repcargo->reporte($result);
 ?>