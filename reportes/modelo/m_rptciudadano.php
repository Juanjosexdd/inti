<?php 
	include_once('../../config/conexion.php');
	include_once('m_repcabpie.php');
	
	class Repciudadano extends Conectar
	{

		function consultar($estatus,$dato)
		{ // consultar por aproximidad
			$conectar = parent::conexion();
			 if($estatus != "")
			 {
				 $sql ="
				 		SELECT c.cedula, c.primernombre, c.primerapellido, c.direccion, c.telefono, c.email, c.estatus
				 		FROM ciudadano c
				 		WHERE c.estatus like UPPER('%$estatus%')
				 			AND (c.primernombre like UPPER(('%$dato%')) OR c.primerapellido like UPPER(('%$dato%'))) 
				 		ORDER BY c.primernombre";
				 $sql = $conectar->prepare($sql);
				 $sql->execute();
				 return $sql->fetchAll();
			}
			else
			{
				$conectar = parent::conexion();
					$sql =" 
							SELECT c.cedula, c.primernombre, c.primerapellido, c.direccion, c.telefono, c.email, c.estatus
					 		FROM ciudadano c
					 		WHERE (c.primernombre like UPPER(('%$dato%')) OR c.primerapellido like UPPER(('%$dato%'))) 
					 		ORDER BY c.primernombre";
					$sql = $conectar->prepare($sql);
					$sql->execute();
					return $sql->fetchAll();
			}
			if($estatus =="" && $dato=="")
			{
				$conectar = parent::conexion();
					$sql =" SELECT *FROM cargo";
					$sql = $conectar->prepare($sql);
					$sql->execute();
					return $sql->fetchAll();
			}

		}

		function reporte($result = false)
		{
			$obj_pdf = new PDF('L', 'mm', 'letter');
			$obj_pdf->AddPage();
			$obj_pdf->AliasNbPages();
			$obj_pdf->SetFont('Times','B',14); // tipo de letra y con negrita
			$celdaAncho = 31; // variable ancho de tabla
			$celdaLargo = 7; // variable ancho de largo de tabla
			$bordetabla ='T'; // variable para bordes de tabla
			

			$obj_pdf->Cell(20, $celdaLargo, utf8_decode('Cédula'),0,0,'C'); // celda titulo tabla
			$obj_pdf->Cell(30, $celdaLargo, utf8_decode('Nombre'),0,0,'C');
			$obj_pdf->Cell(30, $celdaLargo, utf8_decode('Apellido'),0,0,'C');
			$obj_pdf->Cell(75, $celdaLargo, utf8_decode('Dirección'),0,0,'C');
			$obj_pdf->Cell(30, $celdaLargo, utf8_decode('Teléfono'),0,0,'C');
			$obj_pdf->Cell(45, $celdaLargo, utf8_decode('Email'),0,0,'C');
			$obj_pdf->Cell(30, $celdaLargo, utf8_decode('Estatus'),0,0,'C');
			$obj_pdf->Ln(); // salto de linea

			foreach ($result as $key => $row) 
			{
				$obj_pdf->SetFont("Times","",9);
				$obj_pdf->SetWidths(array(20,30,30,75,30,45,30));
				$obj_pdf->SetAligns(array('C','C','C','L','C','L','C'));
				
				$estatus = ($row["estatus"] == 1) ? 'ACTIVO' : 'INACTIVO';

				$obj_pdf->Row(array(
									 utf8_decode($row['cedula'])
									,utf8_decode($row['primernombre'])
									,utf8_decode($row['primerapellido'])
									,utf8_decode($row['direccion'])
									,utf8_decode($row['telefono'])
									,utf8_decode($row['email'])
									,utf8_decode($estatus)
									)
									,array('borderCell'=>'T'),'T');
			}
			$obj_pdf->Ln(5);

			$obj_pdf->Output('listado_ciudadano.pdf', 'I'); // salida del pdf.			
		}
	}
?>