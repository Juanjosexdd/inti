<?php 
	include_once('../modelo/m_rptusuario.php');
	$obj_repcargo = new Repusuario;
	$_GET['titulo']='Listado de Usuarios';
	$result = $obj_repcargo->consultar($_GET['estatus'],$_GET['dato']);
	$obj_repcargo->reporte($result);
 ?>