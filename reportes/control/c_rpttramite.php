<?php 
	include_once('../modelo/m_rpttramite.php');
	$obj_repcargo = new Reptramite;
	$_GET['titulo']='Listado de Tramites';

	if( isset($_GET['fecha']) )
	{
		$fecha = convertir_fecha_bd($_GET['fecha']);
	}
	else
	{
		$fecha = '';
	}


	$result = $obj_repcargo->consultar($_GET['cedula'],$_GET['nombres'],$_GET['fecha']);
	$obj_repcargo->reporte($result);

	function convertir_fecha_bd($fecha = false){
        $date = date_create( str_replace("/", "-", $fecha) );
        $date = date_format($date, 'Y-m-d'); // 'Y-m-d H:i:s'
        return $date;
	}
	  


 ?>