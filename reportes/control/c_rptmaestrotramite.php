<?php 
	include_once('../modelo/m_rptmaestrotramite.php');
	$obj_repcargo = new Reptramite;
	$_GET['titulo']= utf8_decode('Listado Tipos de Trámites');
	$result = $obj_repcargo->consultar($_GET['estatus'],$_GET['dato']);
	$obj_repcargo->reporte($result);
 ?>