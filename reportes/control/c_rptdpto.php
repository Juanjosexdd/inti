<?php 
	include_once('../modelo/m_rptdpto.php');
	$obj_repcargo = new Repdpto;
	$_GET['titulo']='Listado de Departamentos';
	$result = $obj_repcargo->consultar($_GET['estatus']);
	$obj_repcargo->reporte($result);
 ?>